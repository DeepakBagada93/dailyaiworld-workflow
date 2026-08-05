<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use Illuminate\Support\Str;
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

$rawJson = file_get_contents(__DIR__ . '/dispatches_payload.json');
$dispatches = json_decode($rawJson, true);

echo "Processing " . count($dispatches) . " subagent dispatches...\n";

foreach ($dispatches as $index => $data) {
    $num = $index + 1;
    $wordCount = str_word_count(strip_tags($data['content'] ?? ''));
    echo "[$num/8] Title: {$data['title']} ($wordCount words)\n";

    // Auto-generate clean slug
    $slug = Article::generateSeoSlug($data['title']);
    $slug = Article::ensureUniqueSlug($slug);

    $row = [
        'category_id'    => $data['category_id'],
        'author_id'      => $data['author_id'] ?? 1,
        'title'          => $data['title'],
        'slug'           => $slug,
        'deck'           => $data['deck'],
        'ai_summary'     => $data['ai_summary'] ?? $data['deck'],
        'content'        => $data['content'],
        'excerpt'        => $data['excerpt'] ?? $data['deck'],
        'featured_image' => $data['featured_image'] ?? 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1200&q=80',
        'reading_time'   => $data['reading_time'] ?? 8,
        'audio_url'      => null,
        'key_takeaways'  => is_array($data['key_takeaways']) ? json_encode($data['key_takeaways']) : $data['key_takeaways'],
        'faqs'           => is_array($data['faqs']) ? json_encode($data['faqs']) : $data['faqs'],
        'tier'           => $data['tier'] ?? 'free',
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

    // 1. Local Insert/Update
    $localExists = DB::table('articles')->where('slug', $slug)->exists();
    if ($localExists) {
        DB::table('articles')->where('slug', $slug)->update($row);
        echo "  -> Local DB: Updated existing article! (Slug: $slug)\n";
    } else {
        $localId = DB::table('articles')->insertGetId($row);
        echo "  -> Local DB: Inserted ID $localId! (Slug: $slug)\n";
    }

    // 2. Remote Hostinger Insert/Update
    $remoteExists = DB::connection('hostinger')->table('articles')->where('slug', $slug)->exists();
    if ($remoteExists) {
        DB::connection('hostinger')->table('articles')->where('slug', $slug)->update($row);
        echo "  -> Hostinger Live DB: Updated existing article!\n";
    } else {
        DB::connection('hostinger')->table('articles')->insert($row);
        echo "  -> Hostinger Live DB: Inserted successfully!\n";
    }
}

echo "\nDone publishing subagent articles!\n";
