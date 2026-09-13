<?php

/**
 * Daily AI World — Google Fast Indexing CLI Tool
 *
 * Fast-tracks Googlebot indexing for August & September 2026 (and any custom timeframe)
 * using the official Google Indexing API (URL_UPDATED).
 *
 * Usage:
 *   php scripts/fast_google_index.php --test                   # Test API connectivity with 1 URL
 *   php scripts/fast_google_index.php --status                 # View quota and history
 *   php scripts/fast_google_index.php --dry-run                # Preview URLs without submitting
 *   php scripts/fast_google_index.php --month=09 --limit=100   # Submit top 100 September URLs
 *   php scripts/fast_google_index.php --month=08,09 --limit=200 # Submit up to 200 (Google daily quota)
 *   php scripts/fast_google_index.php --all                    # Submit all matching articles
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GoogleIndexingService;
use App\Services\IndexingService;
use Illuminate\Support\Facades\DB;

// Configure remote Hostinger DB connection
config([
    'database.connections.hostinger' => [
        'driver'    => 'mysql',
        'host'      => 'srv1334.hstgr.io',
        'port'      => '3306',
        'database'  => 'u775719140_dailyai',
        'username'  => 'u775719140_admin',
        'password'  => 'Dailyaiworld@3093',
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
        'strict'    => false,
        'options'   => [
            \PDO::ATTR_TIMEOUT => 8,
        ],
    ]
]);

// Parse CLI options
$options = getopt('', [
    'test',
    'status',
    'dry-run',
    'month:',
    'year:',
    'limit:',
    'all',
    'force',
    'submit-indexnow',
    'help',
]);

if (isset($options['help'])) {
    echo "\n=== Daily AI World Google Fast Indexing CLI ===\n";
    echo "Options:\n";
    echo "  --test             Test credentials with 1 URL\n";
    echo "  --status           Show submission stats and today's usage\n";
    echo "  --dry-run          Preview URLs without submitting\n";
    echo "  --month=MM         Specific month (e.g. 08, 09, or 08,09). Default: 08,09\n";
    echo "  --year=YYYY        Year (default: 2026)\n";
    echo "  --limit=N          Max URLs to submit (default: 200, Google's daily quota)\n";
    echo "  --all              Submit without limit (will stop if quota exceeded)\n";
    echo "  --force            Submit even if previously recorded in history\n";
    echo "  --submit-indexnow  Also submit batch to IndexNow (Bing/Yandex)\n\n";
    exit(0);
}

echo "\n=========================================================\n";
echo " 🚀 Daily AI World — Google Fast Indexing Engine v1.0\n";
echo "=========================================================\n";

// Check credentials file
$credPath = GoogleIndexingService::getCredentialsPath();
echo "Credentials: " . ($credPath ?: "MISSING") . "\n";
if (!$credPath || !file_exists($credPath)) {
    echo "❌ Error: Google Service Account credentials not found.\n";
    echo "Place your JSON in storage/credentials/google-indexing-service-account.json\n\n";
    exit(1);
}

// 1. STATUS MODE
if (isset($options['status'])) {
    $todayCount = GoogleIndexingService::getSubmittedTodayCount();
    $historyPath = storage_path('app/google_indexing_history.json');
    $totalLogged = file_exists($historyPath) ? count(json_decode(file_get_contents($historyPath), true) ?? []) : 0;

    echo "\n--- Google Indexing Quota & Stats ---\n";
    echo "Submitted Today:      {$todayCount} / 200 URLs (Google daily limit)\n";
    echo "Total URLs in History: {$totalLogged}\n";
    echo "Service Account Email: " . env('GA_SERVICE_ACCOUNT_EMAIL', 'dailyaiworld-analytics@saasnext-kpi.iam.gserviceaccount.com') . "\n";
    echo "Google Project ID:     " . env('GOOGLE_PROJECT_ID', 'saasnext-kpi') . "\n\n";
    exit(0);
}

// 2. TEST MODE
if (isset($options['test'])) {
    $testUrl = 'https://dailyaiworld.com/';
    echo "\nTesting Google Indexing API with: {$testUrl}\n";
    echo "Connecting...\n";
    $result = GoogleIndexingService::publishUrl($testUrl);

    if ($result['success']) {
        echo "✅ SUCCESS! Google accepted URL notification.\n";
        echo "HTTP Status: {$result['status']}\n";
        echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n\n";
    } else {
        echo "❌ FAILED (HTTP {$result['status']})\n";
        if (!empty($result['friendly_error'])) {
            echo "\n👉 Action Required:\n" . $result['friendly_error'] . "\n\n";
        } else {
            echo "Error: " . json_encode($result['response'] ?? $result['error'], JSON_PRETTY_PRINT) . "\n\n";
        }
    }
    exit($result['success'] ? 0 : 1);
}

// 3. QUERY ARTICLES FOR FAST INDEXING
$year = $options['year'] ?? '2026';
$monthsArg = $options['month'] ?? '08,09';
$months = array_map('trim', explode(',', $monthsArg));

echo "Target Year:   {$year}\n";
echo "Target Months: " . implode(', ', $months) . "\n";

$isDryRun = isset($options['dry-run']);
$isForce = isset($options['force']);
$limit = isset($options['all']) ? null : (int) ($options['limit'] ?? 200);

echo "Limit:         " . ($limit ? "{$limit} URLs" : "ALL") . "\n";
echo "Dry Run:       " . ($isDryRun ? "YES (No requests will be sent)" : "NO") . "\n";
echo "Force Repeat:  " . ($isForce ? "YES" : "NO") . "\n";

echo "\nConnecting to Hostinger Live Database (srv1334.hstgr.io)...\n";

try {
    $query = DB::connection('hostinger')->table('articles')
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->where(function ($q) use ($year, $months) {
            foreach ($months as $i => $m) {
                $monthFormatted = str_pad($m, 2, '0', STR_PAD_LEFT);
                $start = "{$year}-{$monthFormatted}-01 00:00:00";
                $end = date("Y-m-t 23:59:59", strtotime($start));
                if ($i === 0) {
                    $q->whereBetween('published_at', [$start, $end]);
                } else {
                    $q->orWhereBetween('published_at', [$start, $end]);
                }
            }
        })
        ->orderBy('published_at', 'desc')
        ->select('id', 'title', 'slug', 'category_id', 'published_at');

    $allArticles = $query->get();
    echo "Found " . $allArticles->count() . " total articles published in target window.\n";

} catch (\Throwable $e) {
    echo "❌ Failed to query Hostinger DB: " . $e->getMessage() . "\n";
    exit(1);
}

// Build Canonical URLs
$candidateUrls = [];
foreach ($allArticles as $art) {
    if ($art->category_id == 1) {
        $categorySlug = 'workflow';
    } elseif ($art->category_id == 5) {
        $categorySlug = 'mcp-directory';
    } else {
        $categorySlug = 'blogs';
    }

    $url = "https://dailyaiworld.com/{$categorySlug}/{$art->slug}";

    if (!$isForce && GoogleIndexingService::isAlreadySubmitted($url)) {
        continue;
    }

    $candidateUrls[] = [
        'id'           => $art->id,
        'title'        => $art->title,
        'slug'         => $art->slug,
        'published_at' => $art->published_at,
        'url'          => $url,
    ];

    if ($limit && count($candidateUrls) >= $limit) {
        break;
    }
}

echo "Selected for submission: " . count($candidateUrls) . " URLs\n";

if (empty($candidateUrls)) {
    echo "✨ All articles in this window have already been submitted! Use --force to re-submit.\n\n";
    exit(0);
}

// DRY RUN DISPLAY
if ($isDryRun) {
    echo "\n--- DRY RUN PREVIEW (First 20 URLs) ---\n";
    foreach (array_slice($candidateUrls, 0, 20) as $i => $item) {
        echo sprintf("[%02d] %s | %s\n     %s\n", $i + 1, $item['published_at'], $item['title'], $item['url']);
    }
    if (count($candidateUrls) > 20) {
        echo "... and " . (count($candidateUrls) - 20) . " more URLs.\n";
    }
    echo "\nDry run complete. Remove --dry-run to execute Google Indexing API submission.\n\n";
    exit(0);
}

// SUBMISSION LOOP
echo "\nInitiating Google Indexing API submissions...\n";
$successCount = 0;
$failCount = 0;
$urlsToSubmit = array_column($candidateUrls, 'url');

foreach ($candidateUrls as $index => $item) {
    $num = $index + 1;
    $total = count($candidateUrls);
    $url = $item['url'];

    echo sprintf("[%d/%d] Submitting: %s ... ", $num, $total, substr($url, 25));

    $res = GoogleIndexingService::publishUrl($url, 'URL_UPDATED');

    if ($res['success']) {
        echo "✅ OK (200)\n";
        $successCount++;
    } else {
        echo "❌ HTTP {$res['status']}\n";
        $failCount++;

        if (!empty($res['friendly_error'])) {
            echo "   👉 " . $res['friendly_error'] . "\n";
        }

        // Stop if API disabled or permissions missing to avoid quota burn
        if (in_array($res['status'], [401, 403])) {
            $reason = $res['response']['error']['details'][0]['reason'] ?? '';
            if ($reason === 'SERVICE_DISABLED' || str_contains($res['friendly_error'] ?? '', 'NOT enabled')) {
                echo "\n🛑 Execution halted: Web Search Indexing API is disabled on your Google Cloud project.\n";
                echo "Please enable it in Google Cloud Console, then re-run this command.\n\n";
                break;
            }
        }
    }

    // Gentle pacing (200ms)
    usleep(200000);
}

// Also submit to IndexNow if requested
if (isset($options['submit-indexnow'])) {
    echo "\nSubmitting all candidate URLs to IndexNow (Bing/Yandex)...\n";
    $indexNowRes = IndexingService::submitToIndexNow($urlsToSubmit);
    echo "IndexNow submitted: " . ($indexNowRes['submitted_urls_count'] ?? count($urlsToSubmit)) . " URLs\n";
}

echo "\n=========================================================\n";
echo " 📊 Submission Summary\n";
echo "=========================================================\n";
echo "Total Processed: " . ($successCount + $failCount) . "\n";
echo "Successful:      {$successCount} ✅\n";
echo "Failed:          {$failCount} ❌\n";
echo "=========================================================\n\n";

exit($failCount > 0 ? 1 : 0);
