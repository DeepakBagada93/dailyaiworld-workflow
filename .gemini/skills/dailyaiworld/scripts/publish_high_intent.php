<?php
/**
 * Daily AI World — High-Intent Content Publishing Script
 * Usage: Run via CLI after generating dispatches JSON or array data.
 */

require __DIR__ . '/../../../../../personal/Daily AI world/vendor/autoload.php';
$app = require_once __DIR__ . '/../../../../../personal/Daily AI world/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Str;

echo "🚀 Daily AI World Content Publisher Skill Activated...\n";

// Helper to safely publish dispatches array
function publishDailyAiWorldDispatches(array $dispatches) {
    $author = Author::firstOrCreate(
        ['name' => 'Deepak Bagada'],
        ['title' => 'CEO, SaaSNext', 'bio' => 'AI Engineer & SaaS Builder specializing in agentic systems and compute optimization.']
    );

    $publishedCount = 0;
    foreach ($dispatches as $data) {
        $article = Article::where('slug', $data['slug'])->first() ?? new Article();
        $article->title = $data['title'];
        $article->slug = $data['slug'];
        $article->deck = $data['deck'] ?? $data['excerpt'];
        $article->excerpt = $data['excerpt'];
        $article->content = $data['content'];
        $article->category_id = $data['category_id'];
        $article->author_id = $author->id;
        $article->tier = 'Deep Dive';
        $article->status = 'published';
        $article->published_at = now();
        $article->reading_time = max(4, ceil(str_word_count(strip_tags($data['content'])) / 200));
        $article->save();

        $publishedCount++;
        echo "  ✅ Published: {$article->title} (" . str_word_count(strip_tags($article->content)) . " words)\n";
    }

    Artisan::call('view:clear');
    echo "✨ Successfully published {$publishedCount} dispatches to database!\n";
}
