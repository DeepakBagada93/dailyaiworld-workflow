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
$dispatches = json_decode(file_get_contents($payloadFile), true);
$total = count($dispatches);

$baseStartTime = \Carbon\Carbon::tomorrow()->setHour(3)->setMinute(0)->setSecond(0);
$count = 0;

echo "========================================\n";
echo "INSERTING $total AUDITED DISPATCHES TO DUAL DB\n";
echo "========================================\n";

foreach ($dispatches as $index => $data) {
    $num = $index + 1;
    $slug = Article::generateSeoSlug($data['title']);
    $slug = Article::ensureUniqueSlug($slug);

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

    $articlePublishedAt = (clone $baseStartTime)->addMinutes($index * 90);

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
        'published_at'   => $articlePublishedAt->toDateTimeString(),
        'updated_date'   => $articlePublishedAt->toDateTimeString(),
        'view_count'     => 0,
        'trending_score' => 85.0,
        'created_at'     => now(),
        'updated_at'     => now(),
    ];

    try {
        $localId = DB::table('articles')->insertGetId($row);
        DB::connection('hostinger')->table('articles')->insert($row);
        $count++;
        echo "[$num/$total] Inserted: {$data['title']}\n";
        echo "   -> Slug: $slug | Scheduled at: {$articlePublishedAt->toDateTimeString()}\n";
    } catch (\Exception $e) {
        echo "[$num/$total] ERROR: {$e->getMessage()}\n";
    }
}

echo "========================================\n";
echo "SUCCESSFULLY SCHEDULED $count / $total DISPATCHES IN DUAL DB\n";
echo "========================================\n";
