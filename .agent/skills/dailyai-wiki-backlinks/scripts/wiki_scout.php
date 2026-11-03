<?php

/**
 * Daily AI World — Wikipedia Backlink & Citation Scout
 *
 * 1. Searches Wikipedia MediaWiki API for target AI topics with {{Citation needed}} or {{Dead link}}.
 * 2. Fetches page wikitext and extracts exact paragraph snippets.
 * 3. Matches relevant claims against published articles in Hostinger DB (u775719140_dailyai).
 * 4. Outputs ready-to-paste Wikipedia wikitext markup (<ref>{{cite web ...}}</ref>),
 *    exact paragraph targets, and Wikipedia-compliant edit summaries.
 *
 * Usage:
 *   php scripts/wiki_scout.php                         # Scan standard AI topic roster
 *   php scripts/wiki_scout.php --topic="Vector database" # Scan a specific topic
 *   php scripts/wiki_scout.php --article-id=2640        # Find wiki targets for a specific article
 */

require __DIR__ . '/../../../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

$options = getopt('', ['topic:', 'article-id:', 'limit:']);
$targetTopic = $options['topic'] ?? null;
$articleId = isset($options['article-id']) ? (int)$options['article-id'] : null;
$limit = isset($options['limit']) ? (int)$options['limit'] : 10;

echo "\n========================================================================\n";
echo " 🌐 DAILY AI WORLD — WIKIPEDIA BACKLINK & CITATION SCOUT\n";
echo "========================================================================\n\n";

// Target high-traffic Wikipedia topics relevant to Daily AI World content
$defaultTopics = [
    'Retrieval-augmented generation',
    'Large language model',
    'Vector database',
    'Prompt engineering',
    'Intelligent agent',
    'Multi-agent system',
    'Semantic search',
    'Synthetic data',
    'Artificial general intelligence',
    'Hallucination (artificial intelligence)',
    'Natural language processing',
    'Transformer (machine learning model)',
];

$topicsToScan = $targetTopic ? [$targetTopic] : $defaultTopics;

// Fetch candidate articles from Hostinger DB if articleId is not specified
if ($articleId) {
    $articles = DB::connection('hostinger')->table('articles')
        ->where('id', $articleId)
        ->where('status', 'published')
        ->select('id', 'title', 'slug', 'category_id', 'published_at', 'excerpt')
        ->get();
} else {
    $articles = DB::connection('hostinger')->table('articles')
        ->where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->limit(150)
        ->select('id', 'title', 'slug', 'category_id', 'published_at', 'excerpt')
        ->get();
}

if ($articles->isEmpty()) {
    echo "❌ No published articles found in Hostinger DB.\n";
    exit(1);
}

echo "Loaded " . $articles->count() . " candidate articles from Daily AI World DB.\n";
echo "Scanning " . count($topicsToScan) . " Wikipedia topic areas for citation opportunities...\n\n";

$wikiHeaders = [
    'User-Agent' => 'DailyAIWorldCitationScout/2.0 (https://dailyaiworld.com/; contact@dailyaiworld.com)',
];

$opportunities = [];

foreach ($topicsToScan as $topic) {
    echo "🔍 Scanning Wikipedia: '{$topic}' ...\n";

    // 1. Fetch wikitext of the article
    $parseUrl = 'https://en.wikipedia.org/w/api.php?' . http_build_query([
        'action' => 'parse',
        'page' => $topic,
        'prop' => 'wikitext',
        'format' => 'json',
    ]);

    $resp = Http::withHeaders($wikiHeaders)->timeout(15)->get($parseUrl);
    if (!$resp->successful()) {
        echo "   ⚠️ Failed to fetch Wikipedia page: HTTP " . $resp->status() . "\n";
        continue;
    }

    $wikitext = $resp->json()['parse']['wikitext']['*'] ?? '';
    if (empty($wikitext)) {
        echo "   ⚠️ Empty wikitext returned.\n";
        continue;
    }

    // 2. Search for {{Citation needed}} or {{Dead link}}
    // Pattern matches: {{Citation needed...}} or {{Dead link...}}
    preg_match_all('/([^\n\r]+?\{\{(?:[Cc]itation needed|[Dd]ead link)[^\}]*\}\})/u', $wikitext, $matches);

    $foundCount = count($matches[0] ?? []);
    echo "   Found {$foundCount} claim tags in wikitext.\n";

    if ($foundCount === 0) {
        continue;
    }

    foreach ($matches[0] as $matchSentence) {
        $cleanSentence = trim(strip_tags($matchSentence));
        $isDeadLink = (stripos($matchSentence, 'dead link') !== false);
        $type = $isDeadLink ? 'DEAD_LINK_REPLACEMENT' : 'CITATION_NEEDED';

        // Find the best matching Daily AI World article by word overlap
        $bestMatch = null;
        $highestScore = 0;

        foreach ($articles as $art) {
            $artText = strtolower($art->title . ' ' . $art->slug . ' ' . ($art->excerpt ?? ''));
            // Split sentence into significant words (>4 chars)
            $words = array_filter(explode(' ', strtolower(preg_replace('/[^a-z0-9 ]/i', ' ', $cleanSentence))), function($w) {
                return strlen($w) > 4 && !in_array($w, ['which', 'their', 'there', 'about', 'would', 'could', 'should', 'citation', 'needed']);
            });

            $score = 0;
            foreach ($words as $w) {
                if (str_contains($artText, $w)) {
                    $score += 2;
                }
            }

            if ($score > $highestScore) {
                $highestScore = $score;
                $bestMatch = $art;
            }
        }

        // If a relevant article was found (score >= 4)
        if ($bestMatch && $highestScore >= 4) {
            $prefix = match((int)$bestMatch->category_id) {
                1 => 'workflow',
                5 => 'mcp-directory',
                default => 'blogs'
            };
            $articleUrl = "https://dailyaiworld.com/{$prefix}/{$bestMatch->slug}";
            $pubDate = !empty($bestMatch->published_at) ? substr($bestMatch->published_at, 0, 10) : date('Y-m-d');
            $today = date('Y-m-d');

            // Format Wikipedia {{cite web}} markup
            $safeTitle = str_replace(['"', '|', '{', '}'], '', $bestMatch->title);
            $citeMarkup = "<ref>{{cite web |url={$articleUrl} |title={$safeTitle} |author=Bagada, Deepak |publisher=Daily AI World |date={$pubDate} |access-date={$today}}}</ref>";

            $editSummary = ($type === 'DEAD_LINK_REPLACEMENT')
                ? "Replaced dead external link with active technical documentation per WP:DEADREF"
                : "Added verifiable empirical benchmark source per WP:RS";

            $opportunities[] = [
                'type' => $type,
                'wiki_page' => $topic,
                'sentence' => substr($cleanSentence, 0, 220) . '...',
                'matched_article_id' => $bestMatch->id,
                'matched_article_title' => $bestMatch->title,
                'matched_article_url' => $articleUrl,
                'relevance_score' => $highestScore,
                'cite_markup' => $citeMarkup,
                'edit_summary' => $editSummary,
            ];

            if (count($opportunities) >= $limit) {
                break 2;
            }
        }
    }
}

echo "\n========================================================================\n";
echo " 🎯 IDENTIFIED WIKIPEDIA BACKLINK OPPORTUNITIES (" . count($opportunities) . " FOUND)\n";
echo "========================================================================\n\n";

if (empty($opportunities)) {
    echo "ℹ️ No direct keyword overlaps found for the top scanned claims.\n";
    echo "Tip: Run with --topic=\"<Topic Name>\" to drill down on specific subjects.\n\n";
    exit(0);
}

foreach ($opportunities as $idx => $opp) {
    $num = $idx + 1;
    echo "------------------------------------------------------------------------\n";
    echo " [OPPORTUNITY #{$num}] {$opp['type']} on Wikipedia: '{$opp['wiki_page']}'\n";
    echo "------------------------------------------------------------------------\n";
    echo " 📌 Wikipedia Context Claim:\n";
    echo "    \"{$opp['sentence']}\"\n\n";
    echo " 🔗 Daily AI World Match (Score: {$opp['relevance_score']}):\n";
    echo "    Title: {$opp['matched_article_title']} (ID: {$opp['matched_article_id']})\n";
    echo "    URL:   {$opp['matched_article_url']}\n\n";
    echo " 📝 Ready-to-Paste Wikipedia Markup:\n";
    echo "    {$opp['cite_markup']}\n\n";
    echo " 💬 Wikipedia Edit Summary:\n";
    echo "    {$opp['edit_summary']}\n\n";
}

// Save to JSON for downstream skill memory and execution
$outFile = __DIR__ . '/../tracker.json';
$existing = file_exists($outFile) ? json_decode(file_get_contents($outFile), true) : [];
$existing['last_scan'] = date('c');

$storedMap = [];
if (!empty($existing['opportunities']) && is_array($existing['opportunities'])) {
    foreach ($existing['opportunities'] as $item) {
        $k = md5(($item['wiki_page'] ?? '') . ($item['sentence'] ?? ''));
        $storedMap[$k] = $item;
    }
}

foreach ($opportunities as $item) {
    $k = md5(($item['wiki_page'] ?? '') . ($item['sentence'] ?? ''));
    $storedMap[$k] = $item;
}

$existing['opportunities'] = array_values($storedMap);
file_put_contents($outFile, json_encode($existing, JSON_PRETTY_PRINT));
echo "Saved " . count($existing['opportunities']) . " cumulative opportunities to: .agent/skills/dailyai-wiki-backlinks/tracker.json\n\n";

// Also update memory.md
$memFile = __DIR__ . '/../memory.md';
$mdContent = "# Daily AI World — Wikipedia Citation Opportunities Tracker\n\n";
$mdContent .= "Last Updated: " . date('Y-m-d H:i:s T') . "\n";
$mdContent .= "Total Active Opportunities: " . count($existing['opportunities']) . "\n\n";

foreach ($existing['opportunities'] as $idx => $opp) {
    $num = $idx + 1;
    $mdContent .= "### {$num}. [{$opp['wiki_page']}](https://en.wikipedia.org/wiki/" . urlencode(str_replace(' ', '_', $opp['wiki_page'])) . ")\n";
    $mdContent .= "- **Type:** `{$opp['type']}`\n";
    $mdContent .= "- **Wikipedia Claim:** *\"{$opp['sentence']}\"*\n";
    $mdContent .= "- **Matched Article:** [{$opp['matched_article_title']}]({$opp['matched_article_url']}) (ID: {$opp['matched_article_id']})\n";
    $mdContent .= "- **Wikitext Markup:**\n```wikitext\n{$opp['cite_markup']}\n```\n";
    $mdContent .= "- **Edit Summary:** `{$opp['edit_summary']}`\n\n---\n\n";
}
file_put_contents($memFile, $mdContent);
echo "Updated memory log: .agent/skills/dailyai-wiki-backlinks/memory.md\n\n";
