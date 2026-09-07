<?php

/**
 * Daily AI World — Pre-Publish Dispatch Payload Auditor
 * Audits a single article JSON payload BEFORE pushing to DB to ensure zero duplicate FAQs,
 * strict word count (1,200-1,500 words), verified internal links, and E-E-A-T compliance.
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
$wordCount = str_word_count(strip_tags($content));
// Fall back to whitespace-based word count if code-heavy content undercounts
if ($wordCount < 1200 && preg_match_all('/\S+/', strip_tags($content), $matches) > $wordCount) {
    $wordCount = count($matches[0]);
}

// 2. Word Count Check (Strictly 1,200 - 1,500 words)
if ($wordCount < 1200) {
    $errors[] = "Word count is $wordCount words (Required: 1,200 - 1,500 words). Expand code blocks, architecture trade-offs, or production reality checks.";
} elseif ($wordCount > 1550) {
    $warnings[] = "Word count is $wordCount words (Slightly above target 1,200 - 1,500 words). Trim any filler.";
}

// 3. Anti-Duplicate FAQ Check in Content Body
// FAQs must ONLY live in the "faqs" JSON field. If placed in Markdown content, it renders twice!
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

// 4. Check FAQs Array in JSON
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

// 5. Internal Links Check (Must weave 3-5 links to dailyaiworld.com)
preg_match_all('/\[([^\]]+)\]\((https?:\/\/dailyaiworld\.com\/[^\)]+)\)/i', $content, $internalLinkMatches);
$internalLinkCount = count($internalLinkMatches[0] ?? []);
if ($internalLinkCount < 3) {
    $errors[] = "Only found $internalLinkCount internal links to dailyaiworld.com in content (Required: 3 to 5 verified internal links). Use get_verified_internal_links.php.";
}

// 6. No Raw Schema Scripts in Content Check
if (stripos($content, '<script') !== false || stripos($content, 'application/ld+json') !== false) {
    $errors[] = "Raw <script> or JSON-LD schema found inside 'content'. Remove it — Blade templates handle JSON-LD automatically.";
}

// 7. Author Byline / E-E-A-T Check
if (stripos($content, 'Deepak Bagada') === false && stripos($content, 'SaaSNext') === false) {
    $warnings[] = "Author byline or SaaSNext reference missing from content. Ensure Deepak Bagada E-E-A-T signature is included.";
}

// 8. AEO Direct Answer Box Heading Check — Must NOT appear in markdown content
// The AEO answer content should be the first body paragraph(s) without a visible heading.
// Blade templates render the SEO/AEO metadata from the ai_summary field and Schema.org JSON-LD.
// A visible "AEO Direct Answer Box" heading in content creates a duplicate visible <h2> that
// clutters the rendered article and pollutes the Table of Contents.
if (preg_match('/##\s+AEO\s+Direct\s+Answer\s+Box/i', $content)) {
    $errors[] = "AEO DIRECT ANSWER BOX HEADING DETECTED in Markdown content. Remove the '## AEO Direct Answer Box' heading immediately. The first paragraph(s) after the H1 should serve as the AEO answer block without any heading marker. The ai_summary JSON field and Schema.org JSON-LD already handle AEO/GEO metadata.";
}

// 9. Key Takeaways Check
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
