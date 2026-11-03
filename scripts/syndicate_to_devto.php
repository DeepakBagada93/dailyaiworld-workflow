<?php

/**
 * Daily AI World — Automated Dev.to Syndication & Backlink Engine
 *
 * Programmatically publishes an article from the Hostinger DB to Dev.to via the Forem REST API,
 * embedding the official canonical_url and high-authority contextual backlinks back to Daily AI World.
 *
 * Usage:
 *   php scripts/syndicate_to_devto.php --article-id=2644   # Publish specific article
 *   php scripts/syndicate_to_devto.php                     # Publish latest article
 *   php scripts/syndicate_to_devto.php --dry-run           # Preview without publishing
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

$options = getopt('', ['article-id:', 'dry-run', 'draft']);
$articleId = isset($options['article-id']) ? (int)$options['article-id'] : null;
$isDryRun = isset($options['dry-run']);
$isDraft = isset($options['draft']);

echo "\n========================================================================\n";
echo " 🚀 DAILY AI WORLD — DEV.TO AUTOMATED SYNDICATION & BACKLINK ENGINE\n";
echo "========================================================================\n\n";

// 1. Retrieve API Key
$apiKey = env('DEVTO_API_KEY');
if (empty($apiKey)) {
    echo "❌ DEVTO_API_KEY not found in .env\n";
    exit(1);
}

// 2. Fetch Article from Hostinger DB
$query = DB::connection('hostinger')->table('articles')
    ->where('status', 'published');

if ($articleId) {
    $article = $query->where('id', $articleId)->first();
} else {
    $article = $query->orderBy('published_at', 'desc')->first();
}

if (!$article) {
    echo "❌ Article not found in Hostinger Live DB.\n";
    exit(1);
}

$prefix = match((int)$article->category_id) {
    1 => 'workflow',
    5 => 'mcp-directory',
    default => 'blogs'
};

$canonicalUrl = "https://dailyaiworld.com/{$prefix}/{$article->slug}";
echo "📄 Target Article ID: {$article->id}\n";
echo "📌 Title:             {$article->title}\n";
echo "🔗 Canonical URL:     {$canonicalUrl}\n\n";

// 3. Verify User Profile on Dev.to
$userRes = Http::withHeaders(['api-key' => $apiKey])->get('https://dev.to/api/users/me');
if (!$userRes->successful()) {
    echo "❌ Dev.to Authentication Failed: HTTP {$userRes->status()}\n";
    echo $userRes->body() . "\n";
    exit(1);
}
$user = $userRes->json();
echo "👤 Authenticated User: {$user['name']} (@{$user['username']})\n\n";

// 4. Format Tags (Max 4, alphanumeric only)
$tagCandidates = ['ai', 'python', 'machinelearning', 'programming', 'opensource', 'webdev'];
$tags = array_slice($tagCandidates, 0, 4);

// 5. Build Rich Markdown with Canonical Backlink Bridge
$bodyMarkdown = $article->content;

// Add author and canonical bridge
$bridgeFooter = "\n\n---\n\n" .
    "> 🌐 **Original Source Attribution:**\n" .
    "> This comprehensive engineering breakdown was originally published on **[Daily AI World]({$canonicalUrl})** by **[Deepak Bagada](https://dailyaiworld.com)**.\n" .
    ">\n" .
    "> *Explore the full **[Daily AI World Workflow Directory](https://dailyaiworld.com/workflows)** for enterprise-grade autonomous swarms, MCP servers, and LLM orchestration blueprints.*";

$fullMarkdown = $bodyMarkdown . $bridgeFooter;

$payload = [
    'article' => [
        'title' => $article->title,
        'published' => !$isDraft,
        'body_markdown' => $fullMarkdown,
        'tags' => $tags,
        'canonical_url' => $canonicalUrl,
        'description' => $article->excerpt ?? substr(strip_tags($article->content), 0, 150),
    ],
];

if ($isDryRun) {
    echo "🔍 [DRY RUN] Payload prepared successfully:\n";
    echo "Title: " . $payload['article']['title'] . "\n";
    echo "Tags: " . implode(', ', $payload['article']['tags']) . "\n";
    echo "Canonical URL: " . $payload['article']['canonical_url'] . "\n";
    echo "Body length: " . strlen($payload['article']['body_markdown']) . " bytes\n\n";
    exit(0);
}

// 6. Push to Dev.to
echo "📡 Pushing article to Dev.to API...\n";
$postRes = Http::withHeaders([
    'api-key' => $apiKey,
    'Content-Type' => 'application/json',
])->timeout(20)->post('https://dev.to/api/articles', $payload);

if ($postRes->successful()) {
    $publishedData = $postRes->json();
    $devtoUrl = $publishedData['url'] ?? 'N/A';
    $devtoId = $publishedData['id'] ?? 'N/A';

    echo "✅ SUCCESS! Article Published on Dev.to!\n";
    echo "------------------------------------------------------------------------\n";
    echo " Dev.to Post URL:  {$devtoUrl}\n";
    echo " Dev.to Post ID:   {$devtoId}\n";
    echo " Canonical URL:    {$canonicalUrl}\n";
    echo " Status:           " . ($isDraft ? 'Draft' : 'Live / Published') . "\n";
    echo "------------------------------------------------------------------------\n\n";

    // 7. Save to tracking log
    $historyFile = storage_path('app/devto_syndicated.json');
    $history = file_exists($historyFile) ? json_decode(file_get_contents($historyFile), true) : [];
    $history[] = [
        'article_id' => $article->id,
        'title' => $article->title,
        'canonical_url' => $canonicalUrl,
        'devto_id' => $devtoId,
        'devto_url' => $devtoUrl,
        'published_at' => date('c'),
    ];
    file_put_contents($historyFile, json_encode($history, JSON_PRETTY_PRINT));
    echo "Logged publication in: storage/app/devto_syndicated.json\n\n";

} else {
    echo "❌ Dev.to Publication Failed: HTTP {$postRes->status()}\n";
    echo "Response: " . $postRes->body() . "\n\n";
    exit(1);
}
