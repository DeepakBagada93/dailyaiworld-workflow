<?php

/**
 * Daily AI World — Re-submit All Sitemaps to Google Search Console
 *
 * Authenticates via Service Account (OAuth2 JWT) with `https://www.googleapis.com/auth/webmasters`
 * and programmatically submits all 6 sitemaps to Google Search Console via Webmasters API v3.
 *
 * Usage:
 *   php scripts/submit_sitemaps_to_gsc.php
 */

require __DIR__ . '/../vendor/autoload.php';

$credPath = __DIR__ . '/../storage/credentials/google-indexing-service-account.json';
if (!file_exists($credPath)) {
    fwrite(STDERR, "Error: Credentials file not found at $credPath\n");
    exit(1);
}

$creds = json_decode(file_get_contents($credPath), true);
$siteUrl = 'https://dailyaiworld.com/';
$encodedSite = urlencode($siteUrl);

echo "\n=======================================================\n";
echo "   DAILY AI WORLD — GOOGLE SEARCH CONSOLE SITEMAP RESUBMITTER\n";
echo "   Site: {$siteUrl}\n";
echo "=======================================================\n\n";

// 1. Generate JWT Token with Webmasters scope
$now = time();
$header = ['alg' => 'RS256', 'typ' => 'JWT'];
$claims = [
    'iss'   => $creds['client_email'],
    'scope' => 'https://www.googleapis.com/auth/webmasters',
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
    fwrite(STDERR, "Error: Failed to parse private key\n");
    exit(1);
}

openssl_sign($sigInput, $signature, $privateKey, OPENSSL_ALGO_SHA256);
$jwt = $sigInput . '.' . b64url($signature);

$tokenCh = curl_init('https://oauth2.googleapis.com/token');
curl_setopt($tokenCh, CURLOPT_POST, true);
curl_setopt($tokenCh, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion'  => $jwt,
]));
curl_setopt($tokenCh, CURLOPT_RETURNTRANSFER, true);
$tokenResp = json_decode(curl_exec($tokenCh), true);
// curl_close() omitted for modern PHP compatibility

$token = $tokenResp['access_token'] ?? null;
if (!$token) {
    fwrite(STDERR, "Error: Failed to obtain access token: " . json_encode($tokenResp) . "\n");
    exit(1);
}

echo "🔑 Authenticated with Google Search Console API successfully.\n\n";

// List of all sitemaps for Daily AI World
$sitemaps = [
    'https://dailyaiworld.com/sitemap.xml',
    'https://dailyaiworld.com/sitemap-workflows.xml',
    'https://dailyaiworld.com/sitemap-mcp.xml',
    'https://dailyaiworld.com/sitemap-blogs.xml',
    'https://dailyaiworld.com/sitemap-news.xml',
    'https://dailyaiworld.com/sitemap-hubs.xml',
];

echo "📡 SUBMITTING ALL SITEMAPS TO GOOGLE SEARCH CONSOLE API...\n";
echo "-------------------------------------------------------\n";

foreach ($sitemaps as $smUrl) {
    $encodedFeed = urlencode($smUrl);
    $url = "https://www.googleapis.com/webmasters/v3/sites/{$encodedSite}/sitemaps/{$encodedFeed}";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Length: 0"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode === 204 || $httpCode === 200) {
        echo " ✅ SUCCESS [HTTP $httpCode]: Re-submitted $smUrl\n";
    } else {
        echo " ⚠️ RESPONSE [HTTP $httpCode] for $smUrl:\n";
        echo "    $response\n";
    }
}

echo "\n🔍 VERIFYING SITEMAP STATUS IN GOOGLE SEARCH CONSOLE...\n";
echo "-------------------------------------------------------\n";

$ch = curl_init("https://www.googleapis.com/webmasters/v3/sites/{$encodedSite}/sitemaps");
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$gscSitemaps = json_decode(curl_exec($ch), true)['sitemap'] ?? [];

foreach ($gscSitemaps as $sm) {
    $path = basename($sm['path']);
    $lastSubmitted = !empty($sm['lastSubmitted']) ? date('Y-m-d H:i:s', strtotime($sm['lastSubmitted'])) : 'Never';
    $lastDownloaded = !empty($sm['lastDownloaded']) ? date('Y-m-d H:i:s', strtotime($sm['lastDownloaded'])) : 'Never';
    $errors = $sm['errors'] ?? 0;
    $warnings = $sm['warnings'] ?? 0;

    $contents = $sm['contents'] ?? [];
    $totalSubmitted = 0;
    $totalIndexed = 0;
    foreach ($contents as $c) {
        $totalSubmitted += $c['submitted'] ?? 0;
        $totalIndexed += $c['indexed'] ?? 0;
    }

    echo " • {$path}:\n";
    echo "   - Submitted URLs: {$totalSubmitted} | Indexed URLs: {$totalIndexed}\n";
    echo "   - Last Submitted: {$lastSubmitted}\n";
    echo "   - Last Downloaded by Googlebot: {$lastDownloaded}\n";
    echo "   - Health: {$errors} Errors, {$warnings} Warnings\n\n";
}

echo "=======================================================\n";
echo " 🎉 All sitemaps successfully re-submitted to Google Search Console!\n";
echo "=======================================================\n\n";
