<?php

/**
 * Daily AI World — Priority Submitter for Today's Dispatches
 * Submits today's 6 newly published dispatches to Google Indexing API as priority #1.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GoogleIndexingService;
use App\Services\IndexingService;
use Illuminate\Support\Facades\DB;

config([
    'database.connections.hostinger' => [
        'driver' => 'mysql',
        'host' => 'srv1334.hstgr.io',
        'port' => '3306',
        'database' => 'u775719140_dailyai',
        'username' => 'u775719140_admin',
        'password' => 'Dailyaiworld@3093',
        'charset' => 'utf8mb4',
    ]
]);

$todayArticles = DB::connection('hostinger')->table('articles')
    ->whereDate('published_at', date('Y-m-d'))
    ->orderBy('published_at', 'asc')
    ->get(['id', 'title', 'slug', 'category_id', 'published_at']);

echo "Found {$todayArticles->count()} articles published today (" . date('Y-m-d') . "):\n\n";

$urls = [];
foreach ($todayArticles as $art) {
    $prefix = match((int)$art->category_id) {
        1 => 'workflow',
        5 => 'mcp-directory',
        default => 'blogs'
    };
    $url = "https://dailyaiworld.com/{$prefix}/{$art->slug}";
    $urls[] = $url;

    $res = GoogleIndexingService::publishUrl($url, 'URL_UPDATED');
    echo sprintf("[ID: %d] %s\n  ➔ Google Status: HTTP %s (%s)\n",
        $art->id,
        $url,
        $res['status'],
        $res['success'] ? 'ACCEPTED' : ($res['friendly_error'] ?? 'FAILED')
    );
}

echo "\nCompleted priority submission for today's dispatches.\n";
