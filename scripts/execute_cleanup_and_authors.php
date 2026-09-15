<?php

/**
 * Daily AI World — Database Cleanup, Deduplication & Sole Author Enforcement (Deepak Bagada)
 * Runs against Hostinger Remote DB and Local DB.
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
    echo "========================================\n";
    echo "PROCESSING CONNECTION: {$connName}\n";
    echo "========================================\n";

    try {
        $conn = DB::connection($connName);
        $conn->select('SELECT 1');
    } catch (\Throwable $e) {
        echo "❌ Connection failed for {$connName}: " . $e->getMessage() . "\n";
        continue;
    }

    // 1. Maintain Deepak Bagada Author Profile (ID 1)
    echo "\n--- 1. ENSURING DEEPAK BAGADA PROFILE (AUTHOR ID 1) ---\n";
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
        echo "  Updated Author 1: Deepak Bagada (Founder & Editor-in-Chief)\n";
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
        echo "  Created Author 1: Deepak Bagada\n";
    }

    // 2. Identify and Delete Duplicates
    echo "\n--- 2. IDENTIFYING DUPLICATE ARTICLES ---\n";
    $duplicateGroups = $conn->select("
        SELECT LOWER(TRIM(title)) as norm_title, COUNT(*) as cnt,
               GROUP_CONCAT(id ORDER BY id ASC) as ids,
               GROUP_CONCAT(slug ORDER BY id ASC SEPARATOR ' | ') as slugs
        FROM articles
        GROUP BY LOWER(TRIM(title))
        HAVING cnt > 1
    ");

    $toDelete = [];
    foreach ($duplicateGroups as $group) {
        $ids = explode(',', $group->ids);
        $slugs = explode(' | ', $group->slugs);

        // Keep the one with cleanest slug or earliest id
        $bestIdx = 0;
        foreach ($slugs as $idx => $s) {
            if (!preg_match('/-[0-9]+$/', $s)) {
                $bestIdx = $idx;
                break;
            }
        }

        $keepId = (int) $ids[$bestIdx];
        foreach ($ids as $idx => $id) {
            $idInt = (int) $id;
            if ($idInt !== $keepId) {
                $toDelete[$idInt] = "Duplicate of ID {$keepId}";
            }
        }
    }

    // Corrupted and hallucinated articles
    $badArticles = $conn->select("
        SELECT id, title FROM articles
        WHERE title LIKE '%CEO at SaaSNext%'
           OR title LIKE '%Stripe Buys OpenRouter%'
           OR title LIKE '%Laude Headlong%'
           OR title LIKE '%GPT-6%'
    ");
    foreach ($badArticles as $ba) {
        $toDelete[$ba->id] = "Corrupted/Hallucinated: {$ba->title}";
    }

    echo "Found " . count($toDelete) . " articles to delete on {$connName}.\n";

    if (!empty($toDelete)) {
        $idsList = array_keys($toDelete);

        // Delete child relations
        $conn->table('affiliate_links')->whereIn('article_id', $idsList)->delete();
        $conn->table('bookmarks')->whereIn('article_id', $idsList)->delete();
        $conn->table('sponsorships')->whereIn('article_id', $idsList)->delete();
        $conn->table('comments')->whereIn('article_id', $idsList)->delete();

        // Delete articles
        $deleted = $conn->table('articles')->whereIn('id', $idsList)->delete();
        echo "✅ Successfully deleted {$deleted} duplicate/corrupted articles from {$connName}!\n";
    }

    // 3. Assign 100% of Articles to Deepak Bagada
    echo "\n--- 3. ASSIGNING ALL ARTICLES TO DEEPAK BAGADA (AUTHOR ID 1) ---\n";
    $updatedCount = $conn->table('articles')
        ->where('author_id', '!=', 1)
        ->update(['author_id' => 1]);
    echo "  Updated {$updatedCount} articles to Author ID 1 (Deepak Bagada).\n";

    // 4. Remove all other authors
    echo "\n--- 4. PURGING OTHER AUTHORS ---\n";
    $deletedAuthors = $conn->table('authors')->where('id', '!=', 1)->delete();
    echo "  Deleted {$deletedAuthors} other author records.\n";

    $deletedUsers = $conn->table('users')->whereIn('id', [2, 3, 4, 5])->delete();
    echo "  Deleted {$deletedUsers} persona users.\n";

    // Verify Author Distribution
    $dist = $conn->select("
        SELECT a.name, a.title, COUNT(art.id) as article_count
        FROM authors a
        LEFT JOIN articles art ON art.author_id = a.id
        GROUP BY a.id, a.name, a.title
        ORDER BY article_count DESC
    ");
    echo "\nAuthor Distribution on {$connName}:\n";
    foreach ($dist as $d) {
        echo "  - {$d->name} ({$d->title}): {$d->article_count} articles\n";
    }

    $finalCount = $conn->table('articles')->count();
    echo "\nFinal Articles Count on {$connName}: {$finalCount}\n\n";
}

echo "🎉 All database cleanup, deduplication, and sole author enforcement completed!\n";
