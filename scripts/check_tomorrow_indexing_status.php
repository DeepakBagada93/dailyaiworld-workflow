<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Services\GoogleIndexingService;

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

echo "\n======================================================================\n";
echo " 🔍 TOMORROW (2026-11-07) SUBMITTED INDEXING & GSC INSPECTION STATUS\n";
echo "======================================================================\n\n";

// 1. Fetch Tomorrow's Articles from Hostinger DB
$articles = DB::connection('hostinger')->table('articles')
    ->whereDate('published_at', '2026-11-07')
    ->select('id', 'title', 'slug', 'category_id', 'published_at')
    ->orderBy('published_at', 'asc')
    ->get();

echo "Found " . $articles->count() . " articles scheduled for tomorrow (2026-11-07).\n\n";

// 2. Obtain GSC OAuth2 Token
$credPath = __DIR__ . '/../storage/credentials/google-indexing-service-account.json';
$creds = json_decode(file_get_contents($credPath), true);

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
openssl_sign($sigInput, $signature, $privateKey, OPENSSL_ALGO_SHA256);
$jwt = $sigInput . '.' . b64url($signature);

$tokenRes = Http::asForm()->timeout(10)->post('https://oauth2.googleapis.com/token', [
    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
    'assertion'  => $jwt,
]);
$gscToken = $tokenRes->json()['access_token'] ?? null;

if (!$gscToken) {
    echo "❌ Failed to obtain GSC token.\n";
    exit(1);
}

// 3. Inspect each URL
foreach ($articles as $index => $art) {
    $prefix = match((int)$art->category_id) {
        1 => 'workflow',
        5 => 'mcp-directory',
        default => 'blogs'
    };
    $fullUrl = "https://dailyaiworld.com/{$prefix}/{$art->slug}";

    $inspectRes = Http::withToken($gscToken)->timeout(12)->post('https://searchconsole.googleapis.com/v1/urlInspection/index:inspect', [
        'inspectionUrl' => $fullUrl,
        'siteUrl' => 'https://dailyaiworld.com/',
    ]);

    echo "----------------------------------------------------------------------\n";
    echo sprintf("[%02d] ID: %d | %s\n", $index + 1, $art->id, $art->title);
    echo "     URL: $fullUrl\n";

    if ($inspectRes->successful()) {
        $idx = $inspectRes->json()['inspectionResult']['indexStatusResult'] ?? [];
        $verdict = $idx['verdict'] ?? 'UNKNOWN';
        $coverage = $idx['coverageState'] ?? 'UNKNOWN';
        $lastCrawl = !empty($idx['lastCrawlTime']) ? $idx['lastCrawlTime'] : 'Never';
        $indexingState = $idx['indexingState'] ?? 'UNKNOWN';

        if ($verdict === 'PASS' || str_contains(strtolower($coverage), 'indexed')) {
            $badge = "✅ [INDEXED]";
        } elseif (str_contains(strtolower($coverage), 'crawled')) {
            $badge = "⏳ [CRAWLED - PENDING INDEX]";
        } else {
            $badge = "⚡ [IN BOT QUEUE / SUBMITTED]";
        }

        echo "     GSC Badge:     $badge\n";
        echo "     Verdict:       $verdict\n";
        echo "     Coverage:      $coverage\n";
        echo "     IndexingState: $indexingState\n";
        echo "     Last Crawled:  $lastCrawl\n";
    } else {
        echo "     ⚠️ GSC API Response: HTTP " . $inspectRes->status() . " (" . $inspectRes->body() . ")\n";
    }

    echo "\n";
}

echo "======================================================================\n";
echo " ✅ Inspection complete.\n";
echo "======================================================================\n\n";
