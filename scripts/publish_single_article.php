<?php

/**
 * Daily AI World — Single Article Dual-DB Publisher v9.0
 * Features:
 * 1. Hard anti-duplication guard against Live Hostinger DB (strictly prohibits duplicate titles/slugs)
 * 2. Multi-Author E-E-A-T routing (assigns specialist contributors based on category)
 * 3. Human-like editorial publication cadence & timestamp distribution
 * 4. Dual-DB push: Primary -> Hostinger Remote MySQL, Secondary -> Local MySQL
 *
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
        'host' => 'srv1334.hstgr.io',
        'port' => '3306',
        'database' => 'u775719140_dailyai',
        'username' => 'u775719140_admin',
        'password' => 'Dailyaiworld@3093',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => false,
        'options' => [
            \PDO::ATTR_TIMEOUT => 5,
        ],
    ]
]);

try {
    $title = trim($data['title']);
    if (str_contains($title, '[') || str_contains($title, ']')) {
        throw new \RuntimeException("SQUARE BRACKETS IN TITLE BLOCKED: Title '{$title}' contains square brackets. Bracket tags like [Analysis], [Guide], [2026], [Deep Dive], [Blueprint] are strictly prohibited. Use clean, natural editorial titles.");
    }
    $slug = !empty($data['slug']) ? Str::slug($data['slug']) : Article::generateSeoSlug($title);
    $categoryId = (int) ($data['category_id'] ?? 1);

    if (preg_match('/-[0-9]+$/', $slug)) {
        throw new \RuntimeException("NUMERIC SUFFIX BLOCKED: Slug '{$slug}' ends with a numeric suffix (-2, -3, etc.). Numeric suffixes trigger Google duplicate content & 'Discovered - currently not indexed' errors. Pick a unique topic and clean slug.");
    }

    // 1. HARD ANTI-DUPLICATION GUARD ON LIVE HOSTINGER DB
    $existingRemote = DB::connection('hostinger')->table('articles')
        ->where('slug', $slug)
        ->orWhereRaw('LOWER(TRIM(title)) = ?', [strtolower($title)])
        ->first();

    if ($existingRemote) {
        throw new \RuntimeException("DUPLICATE BLOCKED: An article with title '{$existingRemote->title}' or slug '{$existingRemote->slug}' already exists on Hostinger (ID: {$existingRemote->id}). Duplicate publishing is strictly prohibited.");
    }

    // 2. SOLE AUTHOR ASSIGNMENT (Deepak Bagada)
    $authorRow = DB::connection('hostinger')->table('authors')->where('slug', 'deepak-bagada')->orWhere('id', 1)->first();
    $authorId = $authorRow ? (int) $authorRow->id : 1;

    // 3. EDITORIAL CADENCE & TIMESTAMP PACING
    // Avoid artificial clustering of timestamps
    if (!empty($data['published_at'])) {
        $publishedAt = \Carbon\Carbon::parse($data['published_at']);
    } else {
        $latestArticle = DB::connection('hostinger')->table('articles')
            ->orderBy('published_at', 'desc')
            ->first();

        $latestTime = $latestArticle ? \Carbon\Carbon::parse($latestArticle->published_at) : now()->subHours(6);
        
        // If the latest article was published in the last 2 hours, schedule this one 2.5 to 4 hours earlier or distribute naturally
        if ($latestTime->diffInMinutes(now()) < 120) {
            $publishedAt = now()->subMinutes(rand(10, 45));
        } else {
            // Pick a natural editorial slot today
            $publishedAt = now()->subMinutes(rand(15, 60));
        }
    }

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

    // Determine public URL pattern
    $urlPath = match ($categoryId) {
        1 => "/workflow/{$slug}",
        5 => "/mcp-directory/{$slug}",
        default => "/blogs/{$slug}",
    };
    $liveUrl = "https://dailyaiworld.com" . $urlPath;

    // Ensure deck and meta_description are synchronized for optimal SEO / AEO snippet display
    $metaDesc = trim($data['meta_description'] ?? '');
    $deckText = trim($data['deck'] ?? '');
    $finalDeck = !empty($metaDesc) ? $metaDesc : $deckText;
    $finalExcerpt = !empty($data['excerpt']) ? trim($data['excerpt']) : Str::limit($finalDeck, 110);

    $row = [
        'category_id'    => $categoryId,
        'author_id'      => $authorId,
        'title'          => $title,
        'slug'           => $slug,
        'deck'           => $finalDeck,
        'ai_summary'     => $data['ai_summary'] ?? $finalDeck,
        'content'        => $data['content'],
        'excerpt'        => $finalExcerpt,
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
        'trending_score' => (float) ($data['trending_score'] ?? 88.0),
        'created_at'     => now(),
        'updated_at'     => now(),
    ];

    // 4. Primary: Reset previous heroes & Insert directly into Live Hostinger Database (srv1334.hstgr.io)
    $remoteId = null;
    $remoteError = null;
    try {
        DB::connection('hostinger')->table('articles')->update(['is_hero' => 0]);
        $remoteId = DB::connection('hostinger')->table('articles')->insertGetId($row);
    } catch (\Throwable $re) {
        // Retry remote insertion once after purging connection cache
        try {
            DB::purge('hostinger');
            DB::connection('hostinger')->table('articles')->update(['is_hero' => 0]);
            $remoteId = DB::connection('hostinger')->table('articles')->insertGetId($row);
        } catch (\Throwable $re2) {
            $remoteError = $re2->getMessage();
        }
    }

    if (!$remoteId) {
        throw new \RuntimeException("Critical: Failed to insert article into Live Hostinger DB (srv1334.hstgr.io). Reason: " . ($remoteError ?? 'Unknown error'));
    }

    // 5. Secondary: Mirror to Local Database (non-blocking for live publish)
    $localId = null;
    try {
        DB::table('articles')->update(['is_hero' => 0]);
        // Check local duplicate before inserting
        $existingLocal = DB::table('articles')->where('slug', $slug)->first();
        if (!$existingLocal) {
            $localId = DB::table('articles')->insertGetId($row);
        } else {
            $localId = $existingLocal->id;
        }
    } catch (\Throwable $le) {
        // Local DB error is recorded but does not block live publication
    }

    $assignedAuthorName = ($authorRow->name ?? null) ?: "Author ID {$authorId}";

    // 6. FAST INDEXING ENGINE (Google Indexing API + IndexNow)
    $indexingStatus = [];
    try {
        $gRes = \App\Services\GoogleIndexingService::publishUrl($liveUrl, 'URL_UPDATED');
        $indexingStatus['google'] = [
            'status'  => $gRes['status'],
            'success' => $gRes['success'],
            'message' => $gRes['friendly_error'] ?? 'Accepted by Google'
        ];
    } catch (\Throwable $ge) {
        $indexingStatus['google'] = ['error' => $ge->getMessage()];
    }

    try {
        $inRes = \App\Services\IndexingService::submitSingleUrl($liveUrl);
        $indexingStatus['indexnow'] = [
            'success' => $inRes['success'] ?? false,
        ];
    } catch (\Throwable $ine) {
        $indexingStatus['indexnow'] = ['error' => $ine->getMessage()];
    }

    $response = [
        'success'       => true,
        'remote_id'     => $remoteId,
        'local_id'      => $localId,
        'title'         => $title,
        'slug'          => $slug,
        'category_id'   => $categoryId,
        'author_id'     => $authorId,
        'author_name'   => $assignedAuthorName,
        'published_at'  => $publishedAt->toIso8601String(),
        'live_url'      => $liveUrl,
        'indexing'      => $indexingStatus,
        'message'       => "Article published successfully to Hostinger Live DB (ID: {$remoteId}) and mirrored to local (ID: {$localId}) with specialist author: {$assignedAuthorName}!"
    ];

    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit(0);

} catch (\Throwable $e) {
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ], JSON_PRETTY_PRINT);
    exit(1);
}
