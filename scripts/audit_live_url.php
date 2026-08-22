<?php

/**
 * Daily AI World — Live URL Quality & HTTP 200 Auditor
 * Usage: php scripts/audit_live_url.php "https://dailyaiworld.com/workflow/my-slug"
 */

if ($argc < 2) {
    echo json_encode([
        'success' => false,
        'error' => 'Usage: php scripts/audit_live_url.php <url>'
    ], JSON_PRETTY_PRINT);
    exit(1);
}

$url = $argv[1];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'DailyAIWorld-LiveAuditor/2.0');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

if ($error) {
    echo json_encode([
        'success' => false,
        'url' => $url,
        'http_code' => $httpCode,
        'error' => "cURL Error: $error"
    ], JSON_PRETTY_PRINT);
    exit(1);
}

$checks = [
    'http_200' => ($httpCode === 200),
    'has_content' => (strlen($response) > 500),
    'has_author' => (stripos($response, 'Deepak Bagada') !== false || stripos($response, 'SaaSNext') !== false),
    'has_internal_links' => (substr_count($response, 'dailyaiworld.com') >= 2),
    'not_error_page' => (stripos($response, '404') === false && stripos($response, 'Page Not Found') === false && stripos($response, 'Server Error') === false),
];

$allPassed = !in_array(false, $checks, true);

echo json_encode([
    'success' => $allPassed,
    'url' => $url,
    'http_code' => $httpCode,
    'checks' => $checks,
    'message' => $allPassed ? 'URL is live, healthy, and verified with HTTP 200!' : 'URL audit failed on one or more checks.'
], JSON_PRETTY_PRINT);

exit($allPassed ? 0 : 1);
