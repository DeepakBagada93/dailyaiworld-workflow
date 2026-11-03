<?php

/**
 * Daily AI World — Google Search Console (GSC) Live Report CLI Tool
 *
 * Connects directly to Google Search Console API via service account
 * and outputs live search clicks, impressions, CTR, average position,
 * top performing search queries, top landing pages, countries, and sitemaps.
 *
 * Usage:
 *   php scripts/google_search_console_report.php
 *   php scripts/google_search_console_report.php --days=90
 *   php scripts/google_search_console_report.php --json
 */

require __DIR__ . '/../vendor/autoload.php';

$options = getopt('', ['days:', 'json', 'help']);

if (isset($options['help'])) {
    echo "\n=== Daily AI World — Google Search Console Reporter ===\n";
    echo "Usage:\n";
    echo "  php scripts/google_search_console_report.php             # Full report (last 28 days)\n";
    echo "  php scripts/google_search_console_report.php --days=90   # Last 90 days report\n";
    echo "  php scripts/google_search_console_report.php --json      # Raw JSON output\n\n";
    exit(0);
}

$days = isset($options['days']) ? (int)$options['days'] : 28;
$startDate = date('Y-m-d', strtotime("-{$days} days"));
$endDate = date('Y-m-d', strtotime('-2 days')); // GSC typically has 2-day reporting lag

$credPath = __DIR__ . '/../storage/credentials/google-indexing-service-account.json';
if (!file_exists($credPath)) {
    fwrite(STDERR, "Error: Credentials file not found at $credPath\n");
    exit(1);
}

$creds = json_decode(file_get_contents($credPath), true);
$siteUrl = 'https://dailyaiworld.com/';
$encodedSite = urlencode($siteUrl);

// JWT Generation
$now = time();
$header = ['alg' => 'RS256', 'typ' => 'JWT'];
$claims = [
    'iss'   => $creds['client_email'],
    'scope' => 'https://www.googleapis.com/auth/webmasters.readonly',
    'aud'   => 'https://oauth2.googleapis.com/token',
    'exp'   => $now + 3600,
    'iat'   => $now,
];

function b64url(string $data): string {
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

$sigInput = b64url(json_encode($header)) . '.' . b64url(json_encode($claims));
$privateKey = openssl_pkey_get_private($creds['private_key']);
if (!$privateKey) {
    fwrite(STDERR, "Error: Unable to load private key\n");
    exit(1);
}

openssl_sign($sigInput, $signature, $privateKey, OPENSSL_ALGO_SHA256);
$jwt = $sigInput . '.' . b64url($signature);

$ch = curl_init('https://oauth2.googleapis.com/token');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion'  => $jwt,
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$tokenData = json_decode($res, true);
$token = $tokenData['access_token'] ?? null;

if (!$token) {
    fwrite(STDERR, "Error obtaining access token: " . ($tokenData['error_description'] ?? $res) . "\n");
    exit(1);
}

function runGscQuery(string $token, string $siteUrl, array $payload): array {
    $url = "https://www.googleapis.com/webmasters/v3/sites/{$siteUrl}/searchAnalytics/query";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    return json_decode($response, true) ?? [];
}

// 1. Overall Metrics
$overall = runGscQuery($token, $encodedSite, [
    'startDate' => $startDate,
    'endDate' => $endDate,
]);

// 2. Top Queries
$topQueries = runGscQuery($token, $encodedSite, [
    'startDate' => $startDate,
    'endDate' => $endDate,
    'dimensions' => ['query'],
    'rowLimit' => 15
]);

// 3. Top Pages
$topPages = runGscQuery($token, $encodedSite, [
    'startDate' => $startDate,
    'endDate' => $endDate,
    'dimensions' => ['page'],
    'rowLimit' => 15
]);

// 4. Countries
$countries = runGscQuery($token, $encodedSite, [
    'startDate' => $startDate,
    'endDate' => $endDate,
    'dimensions' => ['country'],
    'rowLimit' => 8
]);

// 5. Devices
$devices = runGscQuery($token, $encodedSite, [
    'startDate' => $startDate,
    'endDate' => $endDate,
    'dimensions' => ['device'],
]);

// 6. Sitemaps
$ch = curl_init("https://www.googleapis.com/webmasters/v3/sites/{$encodedSite}/sitemaps");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$sitemaps = json_decode(curl_exec($ch), true)['sitemap'] ?? [];

if (isset($options['json'])) {
    echo json_encode(compact('overall', 'topQueries', 'topPages', 'countries', 'devices', 'sitemaps'), JSON_PRETTY_PRINT);
    exit(0);
}

$summary = $overall['rows'][0] ?? ['clicks' => 0, 'impressions' => 0, 'ctr' => 0, 'position' => 0];
$clicks = number_format($summary['clicks']);
$impressions = number_format($summary['impressions']);
$ctr = round($summary['ctr'] * 100, 2) . '%';
$position = round($summary['position'], 1);

echo "\n=======================================================\n";
echo "   DAILY AI WORLD — GOOGLE SEARCH CONSOLE REPORT       \n";
echo "   Site: $siteUrl | Range: $startDate to $endDate ($days Days)\n";
echo "=======================================================\n\n";

echo "📊 EXECUTIVE SEARCH PERFORMANCE:\n";
echo "-------------------------------------------------------\n";
echo "  • Total Search Clicks:      $clicks\n";
echo "  • Total Impressions:        $impressions\n";
echo "  • Average Click-Through:    $ctr\n";
echo "  • Average Position:         $position\n";

echo "\n🏆 TOP SEARCH QUERIES (Keywords):\n";
echo "--------------------------------------------------------------------------------\n";
printf("  %-38s | %-6s | %-11s | %-7s | %-8s\n", "Search Query", "Clicks", "Impressions", "CTR", "Position");
printf("  %s\n", str_repeat('-', 78));
foreach ($topQueries['rows'] ?? [] as $row) {
    $q = substr($row['keys'][0], 0, 38);
    $c = $row['clicks'];
    $i = $row['impressions'];
    $rCtr = round($row['ctr'] * 100, 1) . '%';
    $pos = round($row['position'], 1);
    printf("  %-38s | %-6s | %-11s | %-7s | %-8s\n", $q, $c, $i, $rCtr, $pos);
}

echo "\n📄 TOP SEARCH LANDING PAGES:\n";
echo "--------------------------------------------------------------------------------\n";
printf("  %-50s | %-6s | %-11s | %-7s\n", "Landing Page", "Clicks", "Impressions", "CTR");
printf("  %s\n", str_repeat('-', 78));
foreach ($topPages['rows'] ?? [] as $row) {
    $p = str_replace('https://dailyaiworld.com', '', $row['keys'][0]);
    $p = substr($p, 0, 50);
    $c = $row['clicks'];
    $i = $row['impressions'];
    $pCtr = round($row['ctr'] * 100, 1) . '%';
    printf("  %-50s | %-6s | %-11s | %-7s\n", $p, $c, $i, $pCtr);
}

echo "\n🌍 TOP SEARCH GEOGRAPHIES:\n";
echo "-------------------------------------------------------\n";
foreach ($countries['rows'] ?? [] as $row) {
    $cCode = strtoupper($row['keys'][0]);
    $cClicks = $row['clicks'];
    $cImp = $row['impressions'];
    $cPos = round($row['position'], 1);
    echo "  • $cCode: $cClicks clicks, $cImp impressions (Avg Pos: $cPos)\n";
}

echo "\n💻 SEARCH DEVICE BREAKDOWN:\n";
echo "-------------------------------------------------------\n";
foreach ($devices['rows'] ?? [] as $row) {
    $dName = ucfirst(strtolower($row['keys'][0]));
    $dClicks = $row['clicks'];
    $dImp = $row['impressions'];
    $dCtr = round($row['ctr'] * 100, 1) . '%';
    echo "  • $dName: $dClicks clicks, $dImp impressions (CTR: $dCtr)\n";
}

echo "\n🗺️ SITEMAP HEALTH IN GSC:\n";
echo "-------------------------------------------------------\n";
foreach ($sitemaps as $sm) {
    $path = basename($sm['path']);
    $submitted = $sm['contents'][0]['submitted'] ?? ($sm['isSitemapsIndex'] ? 'Index' : 'N/A');
    $lastCrawled = substr($sm['lastDownloaded'] ?? 'N/A', 0, 10);
    $warns = $sm['warnings'] ?? 0;
    $errs = $sm['errors'] ?? 0;
    echo "  • $path: $submitted URLs submitted | Crawled: $lastCrawled | Errors: $errs, Warnings: $warns\n";
}
echo "=======================================================\n\n";
