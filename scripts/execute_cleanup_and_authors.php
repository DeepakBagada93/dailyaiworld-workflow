<?php

/**
 * Daily AI World — Database Cleanup, Deduplication & Multi-Author Seeding
 * Runs against Hostinger Remote DB and Local DB.
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    // 1. Seed Authors & Users
    echo "\n--- 1. SEEDING MULTI-AUTHOR PROFILES ---\n";
    
    // Update Deepak Bagada author record
    $conn->table('authors')->where('id', 1)->update([
        'title' => 'Founder & Editor-in-Chief',
        'bio' => 'Deepak Bagada is the founder of Daily AI World and CEO of SaaSNext. He covers enterprise AI architecture, high-concurrency agent workflows, and AI systems engineering.',
        'updated_at' => now(),
    ]);
    echo "  Updated Author 1: Deepak Bagada (Founder & Editor-in-Chief)\n";

    $authorData = [
        [
            'user' => [
                'name' => 'Dr. Aris Thorne',
                'email' => 'aris@dailyaiworld.com',
                'role' => 'editor',
                'password' => Hash::make('ArisDailyAI2026!'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'author' => [
                'name' => 'Dr. Aris Thorne',
                'slug' => 'dr-aris-thorne',
                'title' => 'Lead AI Research Fellow',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=256&q=80',
                'bio' => 'Dr. Aris Thorne specializes in LLM reasoning benchmarks, mixture-of-experts (MoE) architectures, token economics, and neural scaling laws.',
                'twitter' => '@aris_thorne',
                'linkedin' => 'https://linkedin.com/in/aris-thorne',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'target_id' => 2,
        ],
        [
            'user' => [
                'name' => 'Elena Rostova',
                'email' => 'elena@dailyaiworld.com',
                'role' => 'editor',
                'password' => Hash::make('ElenaDailyAI2026!'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'author' => [
                'name' => 'Elena Rostova',
                'slug' => 'elena-rostova',
                'title' => 'Principal Distributed Systems Architect',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=256&q=80',
                'bio' => 'Elena Rostova leads coverage on high-concurrency multi-agent frameworks, LangGraph orchestration, event-driven pipelines, and self-healing systems.',
                'twitter' => '@elena_rostova',
                'linkedin' => 'https://linkedin.com/in/elena-rostova',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'target_id' => 3,
        ],
        [
            'user' => [
                'name' => 'Marcus Vance',
                'email' => 'marcus@dailyaiworld.com',
                'role' => 'editor',
                'password' => Hash::make('MarcusDailyAI2026!'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'author' => [
                'name' => 'Marcus Vance',
                'slug' => 'marcus-vance',
                'title' => 'Head of Protocol Engineering',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=256&q=80',
                'bio' => 'Marcus Vance specializes in the Model Context Protocol (MCP), FastMCP tooling, Claude Desktop integrations, and secure agent RPC transports.',
                'twitter' => '@marcus_vance',
                'linkedin' => 'https://linkedin.com/in/marcus-vance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'target_id' => 4,
        ],
        [
            'user' => [
                'name' => 'Daily AI World Editorial Bureau',
                'email' => 'bureau@dailyaiworld.com',
                'role' => 'editor',
                'password' => Hash::make('BureauDailyAI2026!'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'author' => [
                'name' => 'Daily AI World Editorial Bureau',
                'slug' => 'daily-ai-world-editorial-bureau',
                'title' => 'Staff Intelligence Desk',
                'avatar' => 'https://dailyaiworld.com/images/logo.png',
                'bio' => 'The central investigative and editorial research team at Daily AI World, covering breaking AI releases, regulation, industry acquisitions, and funding news.',
                'twitter' => '@dailyaiworld',
                'linkedin' => 'https://linkedin.com/company/dailyaiworld',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            'target_id' => 5,
        ],
    ];

    foreach ($authorData as $item) {
        $existingUser = $conn->table('users')->where('email', $item['user']['email'])->first();
        if (!$existingUser) {
            $userId = $conn->table('users')->insertGetId($item['user']);
        } else {
            $userId = $existingUser->id;
        }

        $existingAuthor = $conn->table('authors')->where('slug', $item['author']['slug'])->first();
        if (!$existingAuthor) {
            $authorRecord = $item['author'];
            $authorRecord['user_id'] = $userId;
            $conn->table('authors')->insert($authorRecord);
            echo "  Created Author: {$item['author']['name']} (Slug: {$item['author']['slug']})\n";
        } else {
            echo "  Author already exists: {$item['author']['name']}\n";
        }
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

    // 3. Redistribute Articles Across Diverse Authors based on Category
    echo "\n--- 3. REDISTRIBUTING ARTICLES TO SPECIALIST AUTHORS ---\n";
    // Author 1: Deepak Bagada (Founder & Editor-in-Chief) - Business, Startups, general
    // Author 2: Dr. Aris Thorne (Lead AI Research Fellow) - Category 3 (Coding), 10 (LLMs)
    // Author 3: Elena Rostova (Principal Distributed Systems Architect) - Category 1 (AI Workflows), 2 (Agentic AI), 4 (Automation)
    // Author 4: Marcus Vance (Head of Protocol Engineering) - Category 5 (AI Tools/MCP), 6 (Open Source)
    // Author 5: Daily AI World Editorial Bureau - Category 11 (AI News)

    $authorMapping = [
        1 => 3, // AI Workflows -> Elena Rostova
        2 => 3, // Agentic AI -> Elena Rostova
        3 => 2, // Coding -> Dr. Aris Thorne
        4 => 3, // Automation -> Elena Rostova
        5 => 4, // AI Tools / MCP -> Marcus Vance
        6 => 4, // Open Source -> Marcus Vance
        7 => 1, // Business -> Deepak Bagada
        8 => 1, // Startups -> Deepak Bagada
        9 => 1, // Productivity -> Deepak Bagada
        10 => 2, // LLMs -> Dr. Aris Thorne
        11 => 5, // AI News -> Daily AI World Editorial Bureau
        12 => 2, // Tutorials -> Dr. Aris Thorne
    ];

    // Fetch actual author IDs from DB for safety
    $authorIdMap = [];
    $authorsInDb = $conn->table('authors')->get();
    foreach ($authorsInDb as $a) {
        $authorIdMap[$a->slug] = $a->id;
    }

    $slugToId = [
        1 => $authorIdMap['deepak-bagada'] ?? 1,
        2 => $authorIdMap['dr-aris-thorne'] ?? 1,
        3 => $authorIdMap['elena-rostova'] ?? 1,
        4 => $authorIdMap['marcus-vance'] ?? 1,
        5 => $authorIdMap['daily-ai-world-editorial-bureau'] ?? 1,
    ];

    foreach ($authorMapping as $catId => $logicalAuthorId) {
        $actualAuthorId = $slugToId[$logicalAuthorId] ?? 1;
        $updatedCount = $conn->table('articles')
            ->where('category_id', $catId)
            ->where('author_id', 1) // only reassign if currently author 1
            ->when($logicalAuthorId === 1, fn($q) => $q->whereRaw('0=1')) // don't update if already intended for author 1
            ->update(['author_id' => $actualAuthorId]);

        echo "  Category {$catId} -> Author ID {$actualAuthorId}: {$updatedCount} articles updated.\n";
    }

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

echo "🎉 All database cleanup, deduplication, and author seeding operations completed!\n";
