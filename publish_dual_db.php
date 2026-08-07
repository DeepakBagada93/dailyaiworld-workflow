<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use Illuminate\Support\Facades\DB;

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

$payloadFile = __DIR__ . '/dispatches_payload.json';
if (!file_exists($payloadFile)) {
    die("ERROR: dispatches_payload.json not found!\n");
}

// 1. RUN QUALITY AUDIT GATE
echo "========================================\n";
echo "RUNNING SEO / AEO / HEO QUALITY AUDIT GATE\n";
echo "========================================\n";

$auditOutput = [];
$auditReturnCode = 0;
exec("python3 " . escapeshellarg(__DIR__ . "/audit_dispatches.py") . " " . escapeshellarg($payloadFile), $auditOutput, $auditReturnCode);

echo implode("\n", $auditOutput) . "\n";

if ($auditReturnCode !== 0) {
    echo "========================================\n";
    echo "❌ PUBLISHING ABORTED! DISPATCHES FAILED AUDIT.\n";
    echo "Please rewrite rejected articles before pushing to DB.\n";
    echo "========================================\n";
    exit(1);
}

// 2. PUSH TO LOCAL & REMOTE DB
$dispatches = json_decode(file_get_contents($payloadFile), true);
$total = count($dispatches);

echo "========================================\n";
echo "AUDIT PASSED! PUBLISHING $total DISPATCHES TO DUAL DB\n";
echo "========================================\n";

$publishedCount = 0;

foreach ($dispatches as $index => $data) {
    $num = $index + 1;
    $wordCount = str_word_count(strip_tags($data['content'] ?? ''));
    echo "[$num/$total] {$data['title']} ($wordCount words)\n";

    try {
        $slug = Article::generateSeoSlug($data['title']);
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

        $row = [
            'category_id'    => (int) $data['category_id'],
            'author_id'      => 1,
            'title'          => $data['title'],
            'slug'           => $slug,
            'deck'           => $data['deck'],
            'ai_summary'     => $data['ai_summary'] ?? $data['deck'],
            'content'        => $data['content'],
            'excerpt'        => $data['excerpt'] ?? $data['deck'],
            'featured_image' => $data['featured_image'] ?? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
            'reading_time'   => (int) ($data['reading_time'] ?? 8),
            'audio_url'      => null,
            'key_takeaways'  => json_encode($data['key_takeaways'] ?? []),
            'faqs'           => json_encode($normalizedFaqs),
            'tier'           => 'Deep Dive',
            'is_hero'        => 0,
            'is_featured'    => 0,
            'status'         => 'published',
            'published_at'   => now(),
            'updated_date'   => now(),
            'view_count'     => 0,
            'trending_score' => 85.0,
            'created_at'     => now(),
            'updated_at'     => now(),
        ];

        // Local DB
        $localId = DB::table('articles')->insertGetId($row);
        echo "  [LOCAL DB] Success -> ID: $localId | Slug: $slug\n";

        // Remote Hostinger DB
        DB::connection('hostinger')->table('articles')->insert($row);
        echo "  [HOSTINGER DB] Success -> Remote Push Complete!\n";

        $publishedCount++;
    } catch (\Exception $e) {
        echo "  [ERROR] Failed: {$e->getMessage()}\n";
    }
}

echo "========================================\n";
echo "SUCCESSFULLY PUBLISHED $publishedCount / $total AUDITED DISPATCHES TO DUAL DB\n";
echo "========================================\n";
