<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use Illuminate\Support\Facades\DB;

$payload = json_decode(file_get_contents(__DIR__ . '/dispatches_payload.json'), true);
$data = $payload[0];

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
    'slug'           => Article::generateSeoSlug($data['title']),
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
    'status'         => 'scheduled',
    'published_at'   => '2026-08-09 03:00:00',
    'updated_date'   => '2026-08-09 03:00:00',
    'view_count'     => 0,
    'trending_score' => 85.0,
    'created_at'     => now(),
    'updated_at'     => now(),
];

try {
    $id = DB::table('articles')->insertGetId($row);
    echo "LOCAL TEST INSERT SUCCESS: " . $id . "\n";
} catch (\Exception $e) {
    echo "LOCAL TEST INSERT ERROR: " . $e->getMessage() . "\n";
}
