<?php

/**
 * Daily AI World — Automated Dual-DB Publisher Script
 * Inserts dispatches into both Local MySQL and Live Hostinger Remote MySQL.
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use Illuminate\Support\Facades\DB;

// Configure Hostinger Remote Connection
$hostingerHost = env('HOSTINGER_DB_HOST', '193.203.184.64');
$hostingerDb   = env('HOSTINGER_DB_DATABASE', 'u775719140_dailyai');
$hostingerUser = env('HOSTINGER_DB_USERNAME', 'u775719140_admin');
$hostingerPass = env('HOSTINGER_DB_PASSWORD', 'Dailyaiworld@3093');

config([
    'database.connections.hostinger' => [
        'driver' => 'mysql',
        'host' => $hostingerHost,
        'port' => '3306',
        'database' => $hostingerDb,
        'username' => $hostingerUser,
        'password' => $hostingerPass,
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => false,
    ]
]);

// Read payload from file if passed via command line argument, or stdin
$jsonFile = $argv[1] ?? __DIR__ . '/dispatches_payload.json';

if (!file_exists($jsonFile)) {
    echo "Error: Payload file not found at: {$jsonFile}\n";
    echo "Usage: php publish_high_intent.php [path_to_dispatches.json]\n";
    exit(1);
}

$rawJson = file_get_contents($jsonFile);
$dispatches = json_decode($rawJson, true);

if (!$dispatches || !is_array($dispatches)) {
    echo "Error: Invalid JSON payload in {$jsonFile}\n";
    exit(1);
}

echo "========================================\n";
echo "STARTING DUAL-DB PUBLISHING PIPELINE\n";
echo "========================================\n";

$localCount = 0;
$remoteCount = 0;

foreach ($dispatches as $index => $data) {
    $num = $index + 1;
    $wordCount = str_word_count(strip_tags($data['content'] ?? ''));
    echo "[$num/" . count($dispatches) . "] Publishing ({$wordCount} words): {$data['title']}\n";

    try {
        // 1. Local Database Insert (triggers Article boot SEO slug generation)
        $article = Article::create($data);
        $localCount++;
        echo "  [LOCAL DB] Success -> Slug: {$article->slug}\n";
        echo "  [LOCAL DB] URL: {$article->url}\n";

        // 2. Prepare payload for Hostinger Remote DB
        $remoteData = $data;
        $remoteData['slug'] = $article->slug;
        $remoteData['key_takeaways'] = is_array($data['key_takeaways']) ? json_encode($data['key_takeaways']) : $data['key_takeaways'];
        $remoteData['faqs'] = is_array($data['faqs']) ? json_encode($data['faqs']) : $data['faqs'];
        $remoteData['created_at'] = now();
        $remoteData['updated_at'] = now();
        $remoteData['published_at'] = $data['published_at'] ?? now();

        // 3. Remote Hostinger DB Insert
        try {
            $exists = DB::connection('hostinger')->table('articles')->where('slug', $remoteData['slug'])->exists();
            if ($exists) {
                DB::connection('hostinger')->table('articles')->where('slug', $remoteData['slug'])->update($remoteData);
                echo "  [HOSTINGER LIVE DB] Updated existing record.\n";
            } else {
                DB::connection('hostinger')->table('articles')->insert($remoteData);
                echo "  [HOSTINGER LIVE DB] Successfully inserted live!\n";
            }
            $remoteCount++;
        } catch (\Exception $e) {
            echo "  [HOSTINGER LIVE DB ERROR] " . $e->getMessage() . "\n";
        }

    } catch (\Exception $e) {
        echo "  [LOCAL DB ERROR] " . $e->getMessage() . "\n";
    }

    echo "----------------------------------------\n";
}

echo "\n========================================\n";
echo "PUBLISHING COMPLETE SUMMARY\n";
echo "========================================\n";
echo "Local DB: $localCount / " . count($dispatches) . "\n";
echo "Hostinger Live DB: $remoteCount / " . count($dispatches) . "\n";
echo "========================================\n";

// Clear view cache
@exec('php artisan view:clear');
