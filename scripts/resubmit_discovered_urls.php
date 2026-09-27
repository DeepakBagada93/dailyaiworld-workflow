<?php

/**
 * Daily AI World — Resubmit Discovered URLs to Google Indexing API
 * Submits all URLs from Table.csv to Google Indexing API (URL_UPDATED).
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GoogleIndexingService;
use App\Services\IndexingService;

echo "=========================================================\n";
echo " 🚀 Resubmitting Table.csv URLs to Google Indexing API\n";
echo "=========================================================\n";

$csvFiles = ['Table.csv', 'Table 24 sept.csv'];
$urls = [];
foreach ($csvFiles as $f) {
    $p = base_path($f);
    if (file_exists($p)) {
        $lines = file($p, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach (array_slice($lines, 1) as $line) {
            $parts = str_getcsv($line);
            if (!empty($parts[0])) {
                $urls[] = trim($parts[0]);
            }
        }
    }
}

$urls = array_values(array_unique($urls));
$total = count($urls);
echo "Loaded {$total} unique URLs from " . implode(' & ', $csvFiles) . "\n\n";

$credPath = GoogleIndexingService::getCredentialsPath();
echo "Credentials: {$credPath}\n";
if (!$credPath || !file_exists($credPath)) {
    echo "❌ Google Service Account credentials not found.\n";
    exit(1);
}

$successCount = 0;
$failCount = 0;
$results = [];

foreach ($urls as $idx => $url) {
    $num = $idx + 1;
    echo "[{$num}/{$total}] Submitting: {$url} ... ";
    
    $res = GoogleIndexingService::publishUrl($url, 'URL_UPDATED');
    
    if ($res['success']) {
        echo "✅ HTTP {$res['status']}\n";
        $successCount++;
    } else {
        echo "❌ HTTP {$res['status']}\n";
        if (!empty($res['friendly_error'])) {
            echo "   Error: {$res['friendly_error']}\n";
        }
        $failCount++;
        // If quota exceeded (429), stop
        if ($res['status'] === 429) {
            echo "\n⚠️ Google daily quota (200 requests) reached! Stopping.\n";
            break;
        }
    }
    
    $results[] = $res;
    usleep(150000); // 150ms delay between requests to be gentle on Google API
}

echo "\n=========================================================\n";
echo " SUMMARY REPORT\n";
echo "=========================================================\n";
echo "Total URLs:  {$total}\n";
echo "Successful:  {$successCount}\n";
echo "Failed:      {$failCount}\n";

// Also notify IndexNow (Bing/Yandex) in batch
try {
    echo "\nNotifying IndexNow (Bing & Yandex) for all {$total} URLs...\n";
    $indexNowRes = IndexingService::submitIndexNow($urls);
    if ($indexNowRes['success'] ?? false) {
        echo "✅ IndexNow accepted batch submission (HTTP " . ($indexNowRes['status'] ?? 200) . ")\n";
    } else {
        echo "⚠️ IndexNow response: " . json_encode($indexNowRes) . "\n";
    }
} catch (\Throwable $e) {
    echo "⚠️ IndexNow notice: " . $e->getMessage() . "\n";
}

echo "\nDone!\n";
