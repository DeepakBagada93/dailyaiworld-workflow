<?php

/**
 * Daily AI World — Google Analytics (GA4) Live Report CLI Tool
 *
 * Connects directly to Google Analytics Data API v1beta via the service account
 * and outputs live metrics, traffic acquisition, top content, and audience geography.
 *
 * Usage:
 *   php scripts/google_analytics_report.php
 *   php scripts/google_analytics_report.php --days=7
 *   php scripts/google_analytics_report.php --json
 */

require __DIR__ . '/../vendor/autoload.php';

$options = getopt('', ['days:', 'json', 'realtime', 'help']);

if (isset($options['help'])) {
    echo "\n=== Daily AI World — Google Analytics GA4 Reporter ===\n";
    echo "Usage:\n";
    echo "  php scripts/google_analytics_report.php             # Full report (last 30 days)\n";
    echo "  php scripts/google_analytics_report.php --days=7    # Last 7 days report\n";
    echo "  php scripts/google_analytics_report.php --realtime  # Realtime active users\n";
    echo "  php scripts/google_analytics_report.php --json      # Raw JSON output\n\n";
    exit(0);
}

$days = isset($options['days']) ? (int)$options['days'] : 30;
$startDate = "{$days}daysAgo";

$credPath = __DIR__ . '/../storage/credentials/google-indexing-service-account.json';
if (!file_exists($credPath)) {
    fwrite(STDERR, "Error: Credentials file not found at $credPath\n");
    exit(1);
}

$creds = json_decode(file_get_contents($credPath), true);
$propertyId = getenv('GA_PROPERTY_ID') ?: '518661645';

// JWT Generation
$now = time();
$header = ['alg' => 'RS256', 'typ' => 'JWT'];
$claims = [
    'iss'   => $creds['client_email'],
    'scope' => 'https://www.googleapis.com/auth/analytics.readonly',
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

function runGaQuery(string $token, string $propertyId, string $endpoint, array $payload): array {
    $url = "https://analyticsdata.googleapis.com/v1beta/properties/{$propertyId}:{$endpoint}";
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

// 1. Overview Summary
$overview = runGaQuery($token, $propertyId, 'runReport', [
    'dateRanges' => [['startDate' => $startDate, 'endDate' => 'today']],
    'metrics' => [
        ['name' => 'activeUsers'],
        ['name' => 'newUsers'],
        ['name' => 'sessions'],
        ['name' => 'screenPageViews'],
        ['name' => 'averageSessionDuration'],
        ['name' => 'bounceRate'],
    ]
]);

// 2. Realtime
$realtime = runGaQuery($token, $propertyId, 'runRealtimeReport', [
    'metrics' => [['name' => 'activeUsers']],
    'dimensions' => [['name' => 'country']]
]);

// 3. Top Pages
$topPages = runGaQuery($token, $propertyId, 'runReport', [
    'dateRanges' => [['startDate' => $startDate, 'endDate' => 'today']],
    'dimensions' => [['name' => 'pagePath']],
    'metrics' => [
        ['name' => 'screenPageViews'],
        ['name' => 'activeUsers'],
        ['name' => 'averageSessionDuration']
    ],
    'orderBys' => [['metric' => ['metricName' => 'screenPageViews'], 'desc' => true]],
    'limit' => 10
]);

// 4. Traffic Channels & Sources
$channels = runGaQuery($token, $propertyId, 'runReport', [
    'dateRanges' => [['startDate' => $startDate, 'endDate' => 'today']],
    'dimensions' => [['name' => 'sessionDefaultChannelGroup'], ['name' => 'sessionSourceMedium']],
    'metrics' => [
        ['name' => 'sessions'],
        ['name' => 'activeUsers'],
        ['name' => 'bounceRate']
    ],
    'orderBys' => [['metric' => ['metricName' => 'sessions'], 'desc' => true]],
    'limit' => 8
]);

// 5. Geography
$countries = runGaQuery($token, $propertyId, 'runReport', [
    'dateRanges' => [['startDate' => $startDate, 'endDate' => 'today']],
    'dimensions' => [['name' => 'country']],
    'metrics' => [
        ['name' => 'activeUsers'],
        ['name' => 'screenPageViews']
    ],
    'orderBys' => [['metric' => ['metricName' => 'activeUsers'], 'desc' => true]],
    'limit' => 7
]);

// 6. Devices
$devices = runGaQuery($token, $propertyId, 'runReport', [
    'dateRanges' => [['startDate' => $startDate, 'endDate' => 'today']],
    'dimensions' => [['name' => 'deviceCategory']],
    'metrics' => [
        ['name' => 'activeUsers'],
        ['name' => 'screenPageViews']
    ],
    'orderBys' => [['metric' => ['metricName' => 'activeUsers'], 'desc' => true]],
]);

if (isset($options['json'])) {
    echo json_encode(compact('overview', 'realtime', 'topPages', 'channels', 'countries', 'devices'), JSON_PRETTY_PRINT);
    exit(0);
}

$summaryMetrics = $overview['rows'][0]['metricValues'] ?? [];
$activeUsers = number_format((int)($summaryMetrics[0]['value'] ?? 0));
$newUsers = number_format((int)($summaryMetrics[1]['value'] ?? 0));
$sessions = number_format((int)($summaryMetrics[2]['value'] ?? 0));
$views = number_format((int)($summaryMetrics[3]['value'] ?? 0));
$avgDuration = round((float)($summaryMetrics[4]['value'] ?? 0), 1) . 's';
$bounceRate = round(((float)($summaryMetrics[5]['value'] ?? 0)) * 100, 1) . '%';

$realtimeTotal = 0;
foreach ($realtime['rows'] ?? [] as $rRow) {
    $realtimeTotal += (int)($rRow['metricValues'][0]['value'] ?? 0);
}

echo "\n=======================================================\n";
echo "    DAILY AI WORLD — GOOGLE ANALYTICS (GA4) REPORT     \n";
echo "    Property ID: $propertyId | Range: Last $days Days       \n";
echo "=======================================================\n\n";

echo "🟢 REAL-TIME ACTIVE USERS (Last 30 Mins): $realtimeTotal users online\n";
foreach ($realtime['rows'] ?? [] as $rRow) {
    echo "   - {$rRow['dimensionValues'][0]['value']}: {$rRow['metricValues'][0]['value']} user(s)\n";
}

echo "\n📊 EXECUTIVE SUMMARY ($days Days):\n";
echo "-------------------------------------------------------\n";
echo "  • Total Users:            $activeUsers\n";
echo "  • New Users:              $newUsers\n";
echo "  • Total Sessions:         $sessions\n";
echo "  • Screen Page Views:      $views\n";
echo "  • Avg Session Duration:   $avgDuration\n";
echo "  • Bounce Rate:            $bounceRate\n";

echo "\n🏆 TOP 10 VISITED PAGES:\n";
echo "-------------------------------------------------------\n";
printf("  %-45s | %-8s | %-8s | %-8s\n", "Page Path", "Views", "Users", "Avg Time");
printf("  %s\n", str_repeat('-', 75));
foreach ($topPages['rows'] ?? [] as $row) {
    $path = substr($row['dimensionValues'][0]['value'], 0, 45);
    $pViews = $row['metricValues'][0]['value'];
    $pUsers = $row['metricValues'][1]['value'];
    $pTime = round((float)$row['metricValues'][2]['value'], 1) . 's';
    printf("  %-45s | %-8s | %-8s | %-8s\n", $path, $pViews, $pUsers, $pTime);
}

echo "\n🌐 TRAFFIC ACQUISITION CHANNELS:\n";
echo "-------------------------------------------------------\n";
printf("  %-18s | %-32s | %-8s | %-8s\n", "Channel", "Source / Medium", "Sessions", "Users");
printf("  %s\n", str_repeat('-', 72));
foreach ($channels['rows'] ?? [] as $row) {
    $chan = substr($row['dimensionValues'][0]['value'], 0, 18);
    $src = substr($row['dimensionValues'][1]['value'], 0, 32);
    $sCount = $row['metricValues'][0]['value'];
    $uCount = $row['metricValues'][1]['value'];
    printf("  %-18s | %-32s | %-8s | %-8s\n", $chan, $src, $sCount, $uCount);
}

echo "\n🌍 TOP GEOGRAPHIES:\n";
echo "-------------------------------------------------------\n";
foreach ($countries['rows'] ?? [] as $row) {
    $cName = $row['dimensionValues'][0]['value'];
    $cUsers = number_format((int)$row['metricValues'][0]['value']);
    $cViews = number_format((int)$row['metricValues'][1]['value']);
    echo "  • $cName: $cUsers users ($cViews views)\n";
}

echo "\n💻 DEVICE BREAKDOWN:\n";
echo "-------------------------------------------------------\n";
foreach ($devices['rows'] ?? [] as $row) {
    $dName = ucfirst($row['dimensionValues'][0]['value']);
    $dUsers = number_format((int)$row['metricValues'][0]['value']);
    $dViews = number_format((int)$row['metricValues'][1]['value']);
    echo "  • $dName: $dUsers users ($dViews views)\n";
}
echo "\n=======================================================\n\n";
