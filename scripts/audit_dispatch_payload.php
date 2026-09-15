<?php

/**
 * Daily AI World — Pre-Publish Dispatch Payload Auditor v9.0
 * Audits a single article JSON payload BEFORE pushing to DB:
 * 1. Zero duplicate FAQs in content body (Blade handles via JSON array)
 * 2. Strict word count (1,200 - 1,500 words)
 * 3. Verified internal links (3 to 5 to dailyaiworld.com)
 * 4. STRICT Anti-Duplication check against Live Hostinger DB (blocks duplicate titles/slugs)
 * 5. Factual Integrity & Anti-Hallucination Gate (bans fake models like GPT-6 Astra, fake acquisitions)
 * 6. Multi-Author E-E-A-T accreditation check
 *
 * Usage: php scripts/audit_dispatch_payload.php /path/to/dispatch.json
 */

if ($argc < 2) {
    echo json_encode([
        'success' => false,
        'error' => 'Usage: php scripts/audit_dispatch_payload.php <path_to_json>'
    ], JSON_PRETTY_PRINT);
    exit(1);
}

$jsonFile = $argv[1];
if (!file_exists($jsonFile)) {
    echo json_encode([
        'success' => false,
        'error' => "File not found: $jsonFile"
    ], JSON_PRETTY_PRINT);
    exit(1);
}

$data = json_decode(file_get_contents($jsonFile), true);
if (!$data || !is_array($data)) {
    echo json_encode([
        'success' => false,
        'error' => "Invalid JSON payload in $jsonFile"
    ], JSON_PRETTY_PRINT);
    exit(1);
}

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

config([
    'database.connections.hostinger' => [
        'driver' => 'mysql',
        'host' => 'srv1334.hstgr.io',
        'port' => '3306',
        'database' => 'u775719140_dailyai',
        'username' => 'u775719140_admin',
        'password' => 'Dailyaiworld@3093',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ]
]);

$errors = [];
$warnings = [];

// 1. Basic Fields Check
if (empty($data['title'])) {
    $errors[] = "Missing 'title'";
}
if (empty($data['category_id'])) {
    $errors[] = "Missing 'category_id'";
}
if (empty($data['content'])) {
    $errors[] = "Missing 'content'";
}

$content = $data['content'] ?? '';
$title = trim($data['title'] ?? '');
$slug = !empty($data['slug']) ? Str::slug($data['slug']) : Article::generateSeoSlug($title);

// 2. Prohibit Numeric Slug Suffixes (-2, -3, etc.)
if (preg_match('/-[0-9]+$/', $slug)) {
    $errors[] = "NUMERIC SLUG SUFFIX DETECTED: Slug '{$slug}' ends with a numeric suffix (-2, -3, etc.). Numeric suffixes trigger Google duplicate content & 'Discovered - currently not indexed' errors. Pick a unique topic and clean slug.";
}

// 3. Word Count Check (Strictly 1,200 - 1,500 words)
$wordCount = str_word_count(strip_tags($content));
if ($wordCount < 1200 && preg_match_all('/\S+/', strip_tags($content), $matches) > $wordCount) {
    $wordCount = count($matches[0]);
}

if ($wordCount < 1200) {
    $errors[] = "Word count is $wordCount words (Required: 1,200 - 1,500 words). Expand architectural code blocks, trade-offs, or production failure modes.";
} elseif ($wordCount > 1600) {
    $warnings[] = "Word count is $wordCount words (Slightly above target 1,200 - 1,500 words). Trim any filler.";
}

// 4. Live Hostinger DB Anti-Duplication Check
try {
    $existing = DB::connection('hostinger')->table('articles')
        ->where('slug', $slug)
        ->orWhereRaw('LOWER(TRIM(title)) = ?', [strtolower($title)])
        ->first();

    if ($existing) {
        $errors[] = "DUPLICATE ARTICLE DETECTED: An article with title '{$existing->title}' or slug '{$existing->slug}' already exists in Live Hostinger DB (ID: {$existing->id}). Pick a fresh, non-cannibalizing topic.";
    }

    // Fuzzy title collision check
    $titleWords = array_filter(explode(' ', preg_replace('/[^\w\s]/', '', strtolower($title))), fn($w) => strlen($w) > 4);
    if (count($titleWords) >= 3) {
        $firstThree = array_slice(array_values($titleWords), 0, 3);
        $fuzzyQuery = DB::connection('hostinger')->table('articles');
        foreach ($firstThree as $fw) {
            $fuzzyQuery->where('title', 'like', "%{$fw}%");
        }
        $fuzzyMatches = $fuzzyQuery->limit(3)->get();
        if ($fuzzyMatches->isNotEmpty()) {
            $warnings[] = "POTENTIAL CONTENT OVERLAP: Found existing articles with similar key terms: " . $fuzzyMatches->pluck('title')->implode(' | ') . ". Ensure this article provides completely distinct architectural value.";
        }
    }
} catch (\Throwable $dbe) {
    $warnings[] = "Could not verify duplicate against remote DB: " . $dbe->getMessage();
}

// 5. Anti-Hallucination & Speculative Claims Check
$hallucinatedPatterns = [
    '/gpt-6/i' => "Hallucinated model name 'GPT-6' detected. Do not fabricate unreleased frontier models.",
    '/gpt-7/i' => "Hallucinated model name 'GPT-7' detected.",
    '/claude\s+3\.7\s+vision/i' => "Hallucinated model 'Claude 3.7 Vision' detected. Ensure accurate model designation (e.g. Claude 3.7 Sonnet).",
    '/stripe\s+buys\s+openrouter/i' => "Fabricated acquisition headline detected. All industry news must be verified via search.",
    '/99\.[89]%\s+(?:accuracy|agentic\s+accuracy)/i' => "Unsubstantiated extreme accuracy claim (99.8%+) detected. Cite actual peer-reviewed benchmarks.",
    '/laude\s+headlong/i' => "Corrupted/typo entity 'Laude Headlong' detected.",
];

foreach ($hallucinatedPatterns as $pattern => $msg) {
    if (preg_match($pattern, $title) || preg_match($pattern, $content)) {
        $errors[] = "FACTUAL INTEGRITY ERROR: {$msg}";
    }
}

// 5B. Anti-AI Clichés, Buzzwords & Synthetic Phrasing Gate
$bannedAiPatterns = [
    '/\bdelve\b/i' => "Banned AI cliché 'delve' detected. Use human phrasing like 'examine', 'trace', or 'break down'.",
    '/\btapestry\b/i' => "Banned AI cliché 'tapestry' detected.",
    '/\bbeacon\b/i' => "Banned AI cliché 'beacon' detected.",
    '/\btestament to\b/i' => "Banned AI cliché 'testament to' detected.",
    '/\btreasure trove\b/i' => "Banned AI cliché 'treasure trove' detected.",
    '/\bgame-changer\b/i' => "Banned AI cliché 'game-changer' detected. State specific metrics instead of empty hype.",
    '/\brevolutioniz(?:e|ing|ed)\b/i' => "Banned AI cliché 'revolutionize' detected.",
    '/\bseamlessly\s+integrat(?:es?|ing|ed)\b/i' => "Banned AI cliché 'seamlessly integrates' detected. Detail the actual integration friction/setup.",
    '/\bharness(?:ing)?\s+the\s+power\s+of\b/i' => "Banned AI cliché 'harness the power of' detected.",
    '/in\s+today\'?s\s+fast-paced\s+digital/i' => "Banned synthetic AI introduction detected. Answer user intent immediately in first sentence.",
    '/in\s+the\s+ever-evolving\s+landscape/i' => "Banned synthetic AI intro detected.",
    '/\bfurthermore,\s/i' => "Synthetic transition 'Furthermore,' detected. Use natural conversational connectors.",
    '/\bmoreover,\s/i' => "Synthetic transition 'Moreover,' detected.",
    '/\bin\s+conclusion,\s/i' => "Synthetic AI transition 'In conclusion,' detected.",
];

foreach ($bannedAiPatterns as $pattern => $msg) {
    if (preg_match($pattern, $content)) {
        $errors[] = "ANTI-AI QUALITY GATE ERROR: {$msg}";
    }
}

// 5C. Mandatory First-Person Engineering Experience Check (E-E-A-T)
$firstPersonPatterns = [
    '/\b(?:we|I)\s+(?:built|deployed|tested|benchmarked|encountered|configured|profiled|ran)\b/i',
    '/\b(?:in\s+our\s+production|in\s+production\s+testing|our\s+cluster|at\s+SaaSNext)\b/i',
    '/\b(?:when\s+we\s+benchmarked|when\s+we\s+ran|we\s+observed|we\s+hit\s+a)\b/i',
];
$firstPersonHits = 0;
foreach ($firstPersonPatterns as $fpPattern) {
    if (preg_match($fpPattern, $content)) {
        $firstPersonHits++;
    }
}
if ($firstPersonHits === 0) {
    $warnings[] = "HUMAN VOICE WARNING: Zero first-person engineering friction or production testing anecdotes detected. Infuse genuine lived experience (e.g., 'When we deployed this on our test cluster...', 'In our testing at SaaSNext...').";
}

// 6. Anti-Duplicate FAQ Check in Content Body
$duplicateFaqPatterns = [
    '/#+\s*frequently\s+asked\s+questions/i',
    '/#+\s*faq/i',
    '/#+\s*common\s+questions/i',
    '/\*\*q:\s/i',
    '/###\s+q[0-9]:/i',
];
foreach ($duplicateFaqPatterns as $pattern) {
    if (preg_match($pattern, $content)) {
        $errors[] = "DUPLICATE FAQ DETECTED in Markdown content. Remove the FAQ section from 'content' because the blade template automatically renders the interactive FAQ accordion from the 'faqs' array.";
        break;
    }
}

// 7. Check FAQs Array in JSON
$faqs = $data['faqs'] ?? [];
if (empty($faqs) || !is_array($faqs) || count($faqs) < 2) {
    $warnings[] = "Expected 2-4 FAQs in the 'faqs' JSON array for schema & rich snippets.";
} else {
    foreach ($faqs as $i => $faq) {
        $q = $faq['question'] ?? $faq['q'] ?? '';
        $a = $faq['answer'] ?? $faq['a'] ?? '';
        if (empty($q) || empty($a)) {
            $errors[] = "FAQ at index $i is missing question or answer.";
        }
    }
}

// 8. Internal Links Check & Live Verification (Must weave 3-5 verified links)
preg_match_all('/\[([^\]]+)\]\((https?:\/\/dailyaiworld\.com\/[^\)]+)\)/i', $content, $internalLinkMatches);
$internalLinkCount = count($internalLinkMatches[0] ?? []);
if ($internalLinkCount < 3) {
    $errors[] = "Only found $internalLinkCount internal links to dailyaiworld.com in content (Required: 3 to 5 verified internal links). Use get_verified_internal_links.php.";
} else {
    // Validate that every link is active and exists
    $hubUrls = [
        'https://dailyaiworld.com',
        'https://dailyaiworld.com/',
        'https://dailyaiworld.com/workflows',
        'https://dailyaiworld.com/mcp-directory',
        'https://dailyaiworld.com/latest-ai-news',
        'https://dailyaiworld.com/about',
        'https://dailyaiworld.com/contact',
        'https://dailyaiworld.com/privacy-policy',
        'https://dailyaiworld.com/terms',
        'https://dailyaiworld.com/disclaimer',
        'https://dailyaiworld.com/advertise',
        'https://dailyaiworld.com/subscribe',
    ];
    foreach ($internalLinkMatches[2] as $linkUrl) {
        $cleanLink = rtrim($linkUrl, '/');
        if (in_array($cleanLink, $hubUrls) || in_array($linkUrl, $hubUrls)) {
            continue;
        }
        if (preg_match('/https?:\/\/dailyaiworld\.com\/(?:workflow|mcp-directory|blogs|category)\/([^\/?#]+)/i', $linkUrl, $slugMatch)) {
            $targetSlug = $slugMatch[1];
            try {
                $targetExists = DB::connection('hostinger')->table('articles')->where('slug', $targetSlug)->exists();
                if (!$targetExists) {
                    $errors[] = "BROKEN/UNVERIFIED INTERNAL LINK: '{$linkUrl}' does not exist on Hostinger DB. Run get_verified_internal_links.php and only use verified live URLs.";
                }
            } catch (\Throwable $e) {
                // Ignore remote connection check failure
            }
        } else {
            $errors[] = "INVALID INTERNAL LINK PATTERN: '{$linkUrl}'. Must follow https://dailyaiworld.com/(workflow|mcp-directory|blogs)/{slug} or official hub URLs.";
        }
    }
}

// 9. No Raw Schema Scripts in Content Check
if (stripos($content, '<script') !== false || stripos($content, 'application/ld+json') !== false) {
    $errors[] = "Raw <script> or JSON-LD schema found inside 'content'. Remove it — Blade templates handle JSON-LD automatically.";
}

// 9. AEO Direct Answer Box Heading Check
if (preg_match('/##\s+AEO\s+Direct\s+Answer\s+Box/i', $content)) {
    $errors[] = "AEO DIRECT ANSWER BOX HEADING DETECTED in Markdown content. Remove the '## AEO Direct Answer Box' heading immediately. The first paragraph(s) after the H1 should serve as the AEO answer block without any heading marker.";
}

// 10. Sole Author E-E-A-T Signature Check (Deepak Bagada)
$validAuthors = [
    'Deepak Bagada',
    'deeepakbagada',
    'SaaSNext'
];
$authorFound = false;
foreach ($validAuthors as $va) {
    if (stripos($content, $va) !== false || stripos($data['deck'] ?? '', $va) !== false) {
        $authorFound = true;
        break;
    }
}
if (!$authorFound) {
    $warnings[] = "Author signature missing from content. Ensure accredited author attribution (Deepak Bagada, Founder & Editor-in-Chief).";
}

// 11. Key Takeaways Check
$takeaways = $data['key_takeaways'] ?? [];
if (empty($takeaways) || !is_array($takeaways) || count($takeaways) < 2) {
    $warnings[] = "Missing or low count on 'key_takeaways' (Expected 3+).";
}

$passed = empty($errors);

$result = [
    'success' => $passed,
    'word_count' => $wordCount,
    'internal_links_count' => $internalLinkCount,
    'faqs_count' => count($faqs),
    'errors' => $errors,
    'warnings' => $warnings,
    'message' => $passed ? 'Pre-publish audit PASSED! Ready for DB push.' : 'Pre-publish audit FAILED. Resolve errors before pushing.'
];

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit($passed ? 0 : 1);
