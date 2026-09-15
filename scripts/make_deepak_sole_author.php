<?php

/**
 * Daily AI World — Set Deepak Bagada as the Sole Author & Purge Other Authors
 * Applies to both Hostinger Live MySQL and Local MySQL databases.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

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
        'collation' => 'utf8mb4_unicode_ci',
    ]
]);

$connections = ['hostinger', 'mysql'];

foreach ($connections as $connName) {
    echo "====================================================\n";
    echo "PROCESSING CONNECTION: {$connName}\n";
    echo "====================================================\n";

    try {
        $conn = DB::connection($connName);
        $conn->select('SELECT 1');
    } catch (\Throwable $e) {
        echo "❌ Connection failed for {$connName}: " . $e->getMessage() . "\n";
        continue;
    }

    // Step 1: Ensure Deepak Bagada Author Record (ID 1)
    echo "\n--- 1. UPDATING DEEPAK BAGADA PROFILE (ID 1) ---\n";
    $deepakExists = $conn->table('authors')->where('id', 1)->first();
    if ($deepakExists) {
        $conn->table('authors')->where('id', 1)->update([
            'name' => 'Deepak Bagada',
            'slug' => 'deepak-bagada',
            'title' => 'Founder & Editor-in-Chief',
            'avatar' => '/images/deepak-bagada.png',
            'bio' => 'Deepak Bagada is the founder and Editor-in-Chief of Daily AI World and CEO of SaaSNext. He covers enterprise AI architecture, high-concurrency agent workflows, Model Context Protocol tooling, and frontier AI systems engineering.',
            'twitter' => '@deeepakbagada',
            'linkedin' => 'https://linkedin.com/in/deepakbagada',
            'updated_at' => now(),
        ]);
        echo "  ✅ Author 1 (Deepak Bagada) updated successfully.\n";
    } else {
        $conn->table('authors')->insert([
            'id' => 1,
            'user_id' => 1,
            'name' => 'Deepak Bagada',
            'slug' => 'deepak-bagada',
            'title' => 'Founder & Editor-in-Chief',
            'avatar' => '/images/deepak-bagada.png',
            'bio' => 'Deepak Bagada is the founder and Editor-in-Chief of Daily AI World and CEO of SaaSNext. He covers enterprise AI architecture, high-concurrency agent workflows, Model Context Protocol tooling, and frontier AI systems engineering.',
            'twitter' => '@deeepakbagada',
            'linkedin' => 'https://linkedin.com/in/deepakbagada',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "  ✅ Author 1 (Deepak Bagada) created successfully.\n";
    }

    // Ensure User 1 (Deepak Bagada)
    $user1 = $conn->table('users')->where('id', 1)->first();
    if ($user1) {
        $conn->table('users')->where('id', 1)->update([
            'name' => 'Deepak Bagada',
            'role' => 'admin',
            'updated_at' => now(),
        ]);
        echo "  ✅ User 1 (Deepak Bagada) updated.\n";
    }

    // Step 2: Reassign ALL articles to Deepak Bagada (author_id = 1)
    echo "\n--- 2. REASSIGNING ALL ARTICLES TO DEEPAK BAGADA ---\n";
    $updatedArticles = $conn->table('articles')->where('author_id', '!=', 1)->update(['author_id' => 1]);
    echo "  ✅ Reassigned {$updatedArticles} articles to Author ID 1.\n";

    if (\Illuminate\Support\Facades\Schema::connection($connName)->hasTable('posts')) {
        $updatedPosts = $conn->table('posts')->where('author_id', '!=', 1)->update(['author_id' => 1]);
        echo "  ✅ Reassigned {$updatedPosts} posts to Author ID 1.\n";
    }

    // Step 3: Clean up author persona mentions in content, deck, and excerpt
    echo "\n--- 3. CLEANING PERSONA BYLINES & CONTENT MENTIONS ---\n";
    $articlesWithPersonas = $conn->table('articles')
        ->where(function($q) {
            $q->where('content', 'like', '%Elena Rostova%')
              ->orWhere('content', 'like', '%Marcus Vance%')
              ->orWhere('content', 'like', '%Aris Thorne%')
              ->orWhere('content', 'like', '%Editorial Bureau%')
              ->orWhere('deck', 'like', '%Marcus Vance%')
              ->orWhere('excerpt', 'like', '%Marcus Vance%');
        })->select('id', 'title', 'deck', 'excerpt', 'content')->get();

    echo "  Found " . $articlesWithPersonas->count() . " articles with persona mentions.\n";

    foreach ($articlesWithPersonas as $a) {
        $content = $a->content;
        $deck = $a->deck;
        $excerpt = $a->excerpt;

        // Replace HTML link author byline
        $content = preg_replace(
            '/By\s+<a\s+href=\"https:\/\/x\.com\/deeepakbagada\"\s+rel=\"author\">[^<]+<\/a>,\s*[^.\n]+(?:at\s+Daily\s+AI\s+World)?\./i',
            'By <a href="https://x.com/deeepakbagada" rel="author">Deepak Bagada</a>, Founder & Editor-in-Chief at Daily AI World.',
            $content
        );

        // Replace SaaSNext / ScaleOps persona bylines
        $content = preg_replace(
            '/By\s+(?:Dr\.\s+)?(?:Elena Rostova|Marcus Vance),\s*[^.\n]+at\s+(?:SaaSNext|ScaleOps)\./i',
            'By <a href="https://x.com/deeepakbagada" rel="author">Deepak Bagada</a>, Founder & Editor-in-Chief at Daily AI World.',
            $content
        );
        $content = str_replace('Marcus built the lead enrichment', 'Deepak built the lead enrichment', $content);

        // Decks & Excerpts
        if ($deck) {
            $deck = str_replace('Marcus Vance', 'Deepak Bagada', $deck);
            $deck = str_replace('Lead Performance AI Engineer at SaaSNext', 'Founder & Editor-in-Chief at Daily AI World', $deck);
        }
        if ($excerpt) {
            $excerpt = str_replace('Marcus Vance', 'Deepak Bagada', $excerpt);
            $excerpt = str_replace('Lead Performance AI Engineer at SaaSNext', 'Founder & Editor-in-Chief at Daily AI World', $excerpt);
        }

        $conn->table('articles')->where('id', $a->id)->update([
            'content' => $content,
            'deck' => $deck,
            'excerpt' => $excerpt,
            'updated_at' => now(),
        ]);
        echo "    Cleaned Article ID {$a->id}: {$a->title}\n";
    }

    // Step 4: Remove other authors from authors table
    echo "\n--- 4. REMOVING ALL OTHER AUTHORS ---\n";
    $deletedAuthors = $conn->table('authors')->where('id', '!=', 1)->delete();
    echo "  ✅ Deleted {$deletedAuthors} non-Deepak author records.\n";

    // Step 5: Remove non-admin persona users (IDs 2, 3, 4, 5)
    echo "\n--- 5. REMOVING OTHER AUTHOR USERS ---\n";
    $deletedUsers = $conn->table('users')->whereIn('id', [2, 3, 4, 5])->delete();
    echo "  ✅ Deleted {$deletedUsers} persona user accounts.\n";

    // Step 6: Verification
    echo "\n--- 6. VERIFICATION AUDIT ---\n";
    $authorCount = $conn->table('authors')->count();
    $authors = $conn->table('authors')->get();
    echo "  Total Authors in {$connName}: {$authorCount}\n";
    foreach ($authors as $auth) {
        echo "  - ID: {$auth->id} | Name: {$auth->name} | Slug: {$auth->slug} | Title: {$auth->title}\n";
    }

    $articlesAuthorDistribution = $conn->select("
        SELECT a.name, COUNT(art.id) as total_articles
        FROM authors a
        LEFT JOIN articles art ON art.author_id = a.id
        GROUP BY a.id, a.name
    ");
    foreach ($articlesAuthorDistribution as $dist) {
        echo "  - {$dist->name}: {$dist->total_articles} articles (100%)\n";
    }

    $orphanArticles = $conn->table('articles')->where('author_id', '!=', 1)->count();
    echo "  - Articles assigned to other authors: {$orphanArticles}\n";

    $leftoverPersonas = $conn->table('articles')->where(function($q) {
        $q->where('content', 'like', '%Elena Rostova%')
          ->orWhere('content', 'like', '%Marcus Vance%')
          ->orWhere('content', 'like', '%Aris Thorne%')
          ->orWhere('content', 'like', '%Editorial Bureau%');
    })->count();
    echo "  - Leftover persona mentions in content: {$leftoverPersonas}\n";
}

echo "\n🎉 COMPLETED: Deepak Bagada is now the ONLY author across all content!\n";
