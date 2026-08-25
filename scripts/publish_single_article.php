<?php

/**
 * Daily AI World — Single Article Dual-DB Publisher
 * Publishes an article JSON file to both Local MySQL and Hostinger Remote MySQL.
 * Usage: php scripts/publish_single_article.php /path/to/article.json
 */

if ($argc < 2) {
    echo json_encode([
        'success' => false,
        'error' => 'Usage: php scripts/publish_single_article.php <path_to_json>'
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
if (!$data || !isset($data['title']) || !isset($data['content'])) {
    echo json_encode([
        'success' => false,
        'error' => "Invalid article JSON payload in $jsonFile"
    ], JSON_PRETTY_PRINT);
    exit(1);
}

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

// Setup Hostinger connection
config([
    'database.connections.hostinger' => [
        'driver' => 'mysql',
        'host' => '193.203.184.64',
        'port' => '3306',
        'database' => 'u775719140_dailyai',
        'username' => 'u775719140_admin',
        'password' => 'Dailyaiworld@3093',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => false,
    ]
]);

try {
    $slug = !empty($data['slug']) ? Str::slug($data['slug']) : Article::generateSeoSlug($data['title']);
    $slug = Article::ensureUniqueSlug($slug);

    // Normalize FAQs
    $faqs = $data['faqs'] ?? [];
    $normalizedFaqs = [];
    if (is_array($faqs)) {
        foreach ($faqs as $f) {
            if (is_array($f)) {
                $normalizedFaqs[] = [
                    'question' => $f['question'] ?? $f['q'] ?? '',
                    'answer' => $f['answer'] ?? $f['a'] ?? ''
                ];
            }
        }
    }

    // Set published_at strictly in the past (UTC) to ensure immediate live visibility
    $publishedAt = now()->subMinutes(rand(5, 30));

    $categoryId = (int) ($data['category_id'] ?? 1);

    // Determine public URL pattern
    $urlPath = match ($categoryId) {
        1 => "/workflow/{$slug}",
        5 => "/mcp-directory/{$slug}",
        default => "/blogs/{$slug}",
    };
    $liveUrl = "https://dailyaiworld.com" . $urlPath;

    $row = [
        'category_id'    => $categoryId,
        'author_id'      => (int) ($data['author_id'] ?? 1),
        'title'          => $data['title'],
        'slug'           => $slug,
        'deck'           => $data['deck'] ?? ($data['meta_description'] ?? ''),
        'ai_summary'     => $data['ai_summary'] ?? ($data['deck'] ?? ''),
        'content'        => $data['content'],
        'excerpt'        => $data['excerpt'] ?? ($data['deck'] ?? ''),
        'featured_image' => $data['featured_image'] ?? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
        'reading_time'   => (int) ($data['reading_time'] ?? max(5, round(str_word_count(strip_tags($data['content'])) / 200))),
        'audio_url'      => $data['audio_url'] ?? null,
        'key_takeaways'  => json_encode($data['key_takeaways'] ?? []),
        'faqs'           => json_encode($normalizedFaqs),
        'tier'           => $data['tier'] ?? 'Deep Dive',
        'is_hero'        => 1,
        'is_featured'    => 0,
        'status'         => 'published',
        'published_at'   => $publishedAt,
        'updated_date'   => $publishedAt,
        'view_count'     => 0,
        'trending_score' => (float) ($data['trending_score'] ?? 85.0),
        'created_at'     => now(),
        'updated_at'     => now(),
    ];

    // 1. Reset previous heroes & Insert into Local Database
    DB::table('articles')->update(['is_hero' => 0]);
    $localId = DB::table('articles')->insertGetId($row);

    // 2. Reset previous heroes & Insert into Remote Hostinger Database
    $remoteId = null;
    try {
        DB::connection('hostinger')->table('articles')->update(['is_hero' => 0]);
        $remoteId = DB::connection('hostinger')->table('articles')->insertGetId($row);
    } catch (\Throwable $re) {
        // Retry remote insertion once
        try {
            DB::purge('hostinger');
            DB::connection('hostinger')->table('articles')->update(['is_hero' => 0]);
            $remoteId = DB::connection('hostinger')->table('articles')->insertGetId($row);
        } catch (\Throwable $re2) {
            $remoteError = $re2->getMessage();
        }
    }

    // 3. Fast Indexing Notification (IndexNow & Search Engines)
    $indexingResult = null;
    try {
        if (class_exists(\App\Services\IndexingService::class)) {
            $indexingResult = \App\Services\IndexingService::submitToIndexNow([
                $liveUrl,
                'https://dailyaiworld.com/',
                'https://dailyaiworld.com/sitemap.xml',
                'https://dailyaiworld.com/feed.xml',
            ]);
            \App\Services\IndexingService::pingSitemaps();
        }
    } catch (\Throwable $ie) {
        // Fast indexing notification error is non-blocking
    }

    $wordCount = str_word_count(strip_tags($data['content']));

    echo json_encode([
        'success' => true,
        'local_id' => $localId,
        'remote_id' => $remoteId,
        'remote_error' => isset($remoteError) ? $remoteError : null,
        'indexing_notified' => $indexingResult !== null,
        'title' => $data['title'],
        'slug' => $slug,
        'url' => $liveUrl,
        'word_count' => $wordCount,
        'published_at' => $publishedAt->toIso8601String()
    ], JSON_PRETTY_PRINT);
    exit(0);

} catch (\Throwable $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
    exit(1);
}
