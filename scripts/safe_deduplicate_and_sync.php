<?php

/**
 * Safe Deduplication & Slug Optimization Script for Daily AI World
 * Applies to Hostinger Remote DB ('hostinger') and Local MySQL DB ('mysql').
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

// Explicit list of duplicate slugs to delete and their canonical counterpart
$duplicatePairs = [
    'trending-blog-codex-6' => [
        'canonical_slug' => 'nvidia-nemotron-3-ultra-agent-orchestration-2026',
        'reason' => 'Duplicate content of NVIDIA Nemotron article with junk codex slug',
        'copy_content' => false,
    ],
    'deepseek-v4-flash-0731-vs-claude-opus-vs-gpt-56-sol-2' => [
        'canonical_slug' => 'deepseek-v4-flash-0731-vs-claude-opus-vs-gpt-56-sol',
        'reason' => 'Duplicate slug -2; merge comprehensive content into canonical',
        'copy_content' => true,
    ],
    'context-window-vs-context-recall-1m-token-windows-fail' => [
        'canonical_slug' => 'context-length-vs-context-recall-1m-token-context-windows',
        'reason' => 'Duplicate topic/content of 1M token context windows article',
        'copy_content' => false,
    ],
    'amd-bets-5b-anthropic-nvidia-backs-ssi-frontier-chip' => [
        'canonical_slug' => 'amd-bets-5b-anthropic-nvidia-backs-ssi-frontier-chip-race',
        'reason' => 'Duplicate news story of AMD/Nvidia frontier chip article',
        'copy_content' => false,
    ],
    'anthropics-invisible-c2pa-watermarks-claude-outputs-prove-3' => [
        'canonical_slug' => 'anthropics-invisible-c2pa-watermarks-claude-outputs-prove',
        'reason' => 'Duplicate slug -3 of Anthropic C2PA article',
        'copy_content' => false,
    ],
    'anthropics-invisible-c2pa-watermarks-claude-outputs-prove-2' => [
        'canonical_slug' => 'anthropics-invisible-c2pa-watermarks-claude-outputs-prove',
        'reason' => 'Duplicate slug -2 of Anthropic C2PA article',
        'copy_content' => false,
    ],
    'anthropics-multi-agent-turf-war-study-ai-agents-sabotage' => [
        'canonical_slug' => 'anthropics-multi-agent-turf-war-study-claude-agents',
        'reason' => 'Duplicate topic with inferior 2.8k body of Anthropic Turf War article',
        'copy_content' => false,
    ],
    'cursor-2026-agent-mode-google-workspace-plugins-multi-file' => [
        'canonical_slug' => 'cursor-agent-mode-2026-google-workspace-plugins-multi-file',
        'reason' => 'Duplicate article; merge 42k content into canonical slug',
        'copy_content' => true,
    ],
    'openai-assistants-api-sunset-tomorrow-migration-responses' => [
        'canonical_slug' => 'openai-sets-august-26-assistants-api-sunset-migration',
        'reason' => 'Duplicate topic/announcement of Assistants API sunset',
        'copy_content' => false,
    ],
    'okta-launches-agent-sso-ai-agents-now-log-like-employees' => [
        'canonical_slug' => 'okta-launches-agent-sso-ai-agents-login-like-employees',
        'reason' => 'Duplicate article of Okta Agent SSO launch',
        'copy_content' => false,
    ],
    'ship-agent-token-budget-enforcer-prevented-47k-runaway-cost' => [
        'canonical_slug' => 'build-autonomous-agent-token-budget-enforcer-prevented-47k',
        'reason' => 'Duplicate article with altered title of Token Budget Enforcer',
        'copy_content' => false,
    ],
    'swe-bench-verified-96-benchmark-saturation-crisis-2026' => [
        'canonical_slug' => 'swe-bench-verified-hits-96-benchmark-saturation-crisis-2026',
        'reason' => 'Duplicate article of SWE-bench 96% saturation',
        'copy_content' => false,
    ],
    'snowflake-data-warehouse-analytics-query-optimizer-fastmcp-2' => [
        'canonical_slug' => 'dominate-100m-rows-build-snowflake-mcp-server-real-time',
        'reason' => 'Leftover -2 duplicate slug on local database',
        'copy_content' => false,
    ],
];

// Junk, test, or stub slugs to delete outright
$junkSlugs = [
    'autonomous-ai-workflows-api-integration-test' => 'API test artifact (69 bytes)',
    'public-html-standalone-api-hostinger-test' => 'Hostinger API test artifact (99 bytes)',
    'brave-search-web-intelligence-mcp-server-real-time' => 'Truncated stub article (434 bytes)',
];

// Slugs to clean up (remove -2, -3 where the canonical is unoccupied)
$slugRenames = [
    'eu-ai-act-2026-compliance-audit-autonomous-ai-agents-3' => 'eu-ai-act-2026-compliance-audit-autonomous-ai-agents',
    'build-auto-scaling-rag-pipeline-pinecone-serverless-load-2' => 'build-auto-scaling-rag-pipeline-pinecone-serverless-load',
];

foreach ($connections as $connName) {
    echo "\n=======================================================\n";
    echo "PROCESSING DATABASE: {$connName}\n";
    echo "=======================================================\n";

    try {
        $db = DB::connection($connName);
        $db->select('SELECT 1');
    } catch (\Throwable $e) {
        echo "❌ Connection failed for {$connName}: " . $e->getMessage() . "\n";
        continue;
    }

    $initialCount = $db->table('articles')->count();
    echo "Initial article count on {$connName}: {$initialCount}\n";

    // Step 1: Content merging for rich duplicates
    echo "\n--- Step 1: Merging Rich Content into Canonical Articles ---\n";
    foreach ($duplicatePairs as $dupeSlug => $meta) {
        if (!empty($meta['copy_content'])) {
            $dupe = $db->table('articles')->where('slug', $dupeSlug)->first();
            $canonical = $db->table('articles')->where('slug', $meta['canonical_slug'])->first();

            if ($dupe && $canonical) {
                if (strlen($dupe->content) > strlen($canonical->content)) {
                    $db->table('articles')->where('id', $canonical->id)->update([
                        'content' => $dupe->content,
                        'excerpt' => !empty($dupe->excerpt) ? $dupe->excerpt : $canonical->excerpt,
                        'deck' => !empty($dupe->deck) ? $dupe->deck : $canonical->deck,
                        'key_takeaways' => !empty($dupe->key_takeaways) ? $dupe->key_takeaways : $canonical->key_takeaways,
                        'faqs' => !empty($dupe->faqs) ? $dupe->faqs : $canonical->faqs,
                        'reading_time' => !empty($dupe->reading_time) ? $dupe->reading_time : $canonical->reading_time,
                        'updated_at' => now(),
                    ]);
                    echo "  ✅ Merged rich content from [{$dupe->id}] {$dupeSlug} (" . strlen($dupe->content) . "b) into canonical [{$canonical->id}] {$meta['canonical_slug']} (" . strlen($canonical->content) . "b)\n";
                }
            }
        }
    }

    // Step 2: Slug Renaming for standalone articles with -2 / -3
    echo "\n--- Step 2: Renaming Non-Duplicate Standalone Slugs ---\n";
    foreach ($slugRenames as $oldSlug => $newSlug) {
        $article = $db->table('articles')->where('slug', $oldSlug)->first();
        if ($article) {
            $targetExists = $db->table('articles')->where('slug', $newSlug)->first();
            if (!$targetExists) {
                $db->table('articles')->where('id', $article->id)->update([
                    'slug' => $newSlug,
                    'updated_at' => now(),
                ]);
                echo "  ✅ Renamed [{$article->id}]: {$oldSlug} -> {$newSlug}\n";
            } else {
                echo "  ⚠️ Target slug {$newSlug} already exists (id: {$targetExists->id}), cannot rename {$oldSlug}\n";
            }
        } else {
            echo "  ℹ️ Slug {$oldSlug} not found (may already be renamed)\n";
        }
    }

    // Step 3: Delete Duplicate Articles
    echo "\n--- Step 3: Deleting Duplicate & Junk Articles ---\n";
    $slugsToDelete = array_merge(array_keys($duplicatePairs), array_keys($junkSlugs));
    $articlesToDelete = $db->table('articles')->whereIn('slug', $slugsToDelete)->get();

    echo "Found " . $articlesToDelete->count() . " articles matching deletion list on {$connName}.\n";

    if ($articlesToDelete->isNotEmpty()) {
        $deleteIds = $articlesToDelete->pluck('id')->toArray();

        // Foreign keys cleanup
        $afDeleted = $db->table('affiliate_links')->whereIn('article_id', $deleteIds)->delete();
        $bmDeleted = $db->table('bookmarks')->whereIn('article_id', $deleteIds)->delete();
        $spDeleted = $db->table('sponsorships')->whereIn('article_id', $deleteIds)->delete();
        $cmDeleted = $db->table('comments')->whereIn('article_id', $deleteIds)->delete();

        echo "  Cleaned child relations: {$afDeleted} affiliate links, {$bmDeleted} bookmarks, {$spDeleted} sponsorships, {$cmDeleted} comments.\n";

        foreach ($articlesToDelete as $art) {
            $reason = $duplicatePairs[$art->slug]['reason'] ?? ($junkSlugs[$art->slug] ?? 'Duplicate/Junk');
            echo "  🗑️ Deleting [{$art->id}] {$art->slug} — Reason: {$reason}\n";
        }

        $deletedCount = $db->table('articles')->whereIn('id', $deleteIds)->delete();
        echo "  ✅ Successfully deleted {$deletedCount} duplicate/junk articles from {$connName}!\n";
    }

    // Step 4: Verification
    $finalCount = $db->table('articles')->count();
    echo "\nFinal article count on {$connName}: {$finalCount} (net change: " . ($finalCount - $initialCount) . ")\n";

    // Double check: any duplicate normalized titles remaining?
    $remainingDupeTitles = $db->select("
        SELECT LOWER(TRIM(title)) as norm_title, COUNT(*) as cnt, GROUP_CONCAT(id) as ids, GROUP_CONCAT(slug SEPARATOR ' | ') as slugs
        FROM articles
        GROUP BY LOWER(TRIM(title))
        HAVING cnt > 1
    ");
    echo "Remaining duplicate titles on {$connName}: " . count($remainingDupeTitles) . "\n";
    foreach ($remainingDupeTitles as $rdt) {
        echo "  ⚠️ [{$rdt->ids}] {$rdt->norm_title} ({$rdt->slugs})\n";
    }

    // Double check: any duplicate numeric slugs remaining (-2..-9)?
    $remainingNumericSlugs = $db->select("
        SELECT id, slug, title FROM articles WHERE slug REGEXP '-[2-9]$'
    ");
    echo "Remaining numeric duplicate slugs (-2..-9) on {$connName}: " . count($remainingNumericSlugs) . "\n";
    foreach ($remainingNumericSlugs as $rns) {
        echo "  ⚠️ [{$rns->id}] {$rns->slug} | {$rns->title}\n";
    }
}

echo "\n🎉 Safe deduplication process finished across all databases!\n";
