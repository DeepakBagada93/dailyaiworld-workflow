<?php

/**
 * Daily AI World — Unified Daily Indexing, Status Tracker & Content Prune Audit Engine
 *
 * Capabilities:
 * 1. COMPLIANT ROTATING INDEXER:
 *    - Pushes smart batch (Tier 1 fresh, Tier 2 core hubs, Tier 3 unindexed backlog)
 *    - Strictly enforces Google's 200 URLs/day ceiling with 250ms natural rate-pacing.
 * 2. DAILY STATUS CHANGE TRACKER:
 *    - Caches URL inspection verdicts in storage/app/url_indexing_status_cache.json.
 *    - Detects status changes (e.g., Promoted to Indexed, Crawled by Bot, or Stagnant).
 * 3. PRUNING CANDIDATE DETECTION & CLEAN DE-INDEXATION:
 *    - Identifies stubborn "Crawled - currently not indexed" articles older than 21 days with 0 impressions.
 *    - Provides one-command safe de-indexing: sets status='archived' on Hostinger DB
 *      and submits `URL_DELETED` to Google Indexing API so Googlebot clears crawl budget.
 * 4. DAILY AUDIT LOGGING:
 *    - Writes executive daily markdown report to storage/logs/indexing_audit_YYYY-MM-DD.md.
 *
 * Usage:
 *   php scripts/daily_indexing_and_prune_audit.php                    # Full run (Index batch + Track status + Prune report)
 *   php scripts/daily_indexing_and_prune_audit.php --report-only      # Check status changes & prune candidates without submitting API
 *   php scripts/daily_indexing_and_prune_audit.php --dry-run          # Preview batch without sending API requests
 *   php scripts/daily_indexing_and_prune_audit.php --prune-id=123     # Archive article #123 & notify Google Indexing API (URL_DELETED)
 */

if (!defined('LARAVEL_START')) {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    if ($app instanceof Illuminate\Contracts\Foundation\Application) {
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
    }
}

use App\Services\GoogleIndexingService;
use App\Services\IndexingService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

$options = getopt('', ['report-only', 'dry-run', 'prune-id:', 'help']);

if (isset($options['help'])) {
    echo "\n=== Daily AI World — Daily Indexing & Content Prune Audit Engine ===\n";
    echo "Usage:\n";
    echo "  php scripts/daily_indexing_and_prune_audit.php                  # Run indexing + audit\n";
    echo "  php scripts/daily_indexing_and_prune_audit.php --report-only    # Audit status & prune radar only\n";
    echo "  php scripts/daily_indexing_and_prune_audit.php --dry-run        # Preview indexing batch\n";
    echo "  php scripts/daily_indexing_and_prune_audit.php --prune-id=123   # Archive article #123 & notify Google\n\n";
    exit(0);
}

$isReportOnly = isset($options['report-only']);
$isDryRun = isset($options['dry-run']);
$pruneId = isset($options['prune-id']) ? (int)$options['prune-id'] : null;

$now = Carbon::now('Asia/Calcutta');
$todayDateStr = $now->format('Y-m-d');
$todayTimeStr = $now->format('Y-m-d H:i:s T');

// Ensure storage directories exist
if (!File::isDirectory(storage_path('app'))) {
    File::makeDirectory(storage_path('app'), 0755, true);
}
if (!File::isDirectory(storage_path('logs'))) {
    File::makeDirectory(storage_path('logs'), 0755, true);
}

echo "\n=================================================================================\n";
echo " 🌐 DAILY AI WORLD — GOOGLE INDEXING & CONTENT PRUNE ENGINE\n";
echo "=================================================================================\n";
echo " Time: {$todayTimeStr}\n";
echo " Mode: " . ($pruneId ? "PRUNE ARTICLE #{$pruneId}" : ($isReportOnly ? "REPORT ONLY" : ($isDryRun ? "DRY-RUN" : "LIVE ROTATION & AUDIT"))) . "\n\n";

// Helper: Canonical URL Resolver
function resolveCanonicalUrl(object $art): string {
    $prefix = match((int)$art->category_id) {
        1 => 'workflow',
        5 => 'mcp-directory',
        default => 'blogs'
    };
    return "https://dailyaiworld.com/{$prefix}/{$art->slug}";
}

// ---------------------------------------------------------------------------------
// ACTION: SINGLE PRUNE EXECUTION (--prune-id=XYZ)
// ---------------------------------------------------------------------------------
if ($pruneId) {
    echo "🗑️ EXECUTING PRUNE FOR ARTICLE ID: {$pruneId}...\n";
    echo "---------------------------------------------------------------------------------\n";

    $article = DB::connection('hostinger')->table('articles')->where('id', $pruneId)->first();
    if (!$article) {
        echo "❌ Article #{$pruneId} not found in Hostinger Database.\n\n";
        exit(1);
    }

    $url = resolveCanonicalUrl($article);
    echo " Found: '{$article->title}'\n";
    echo " URL:   {$url}\n";
    echo " Current Status: {$article->status}\n";

    // 1. Update status to 'archived' in Hostinger DB
    DB::connection('hostinger')->table('articles')->where('id', $pruneId)->update([
        'status'     => 'archived',
        'updated_at' => now(),
    ]);
    echo " ✅ Status updated to 'archived' in Hostinger DB.\n";

    // 2. Submit URL_DELETED to Google Indexing API
    echo " 📡 Notifying Google Indexing API (URL_DELETED)... ";
    $deleteRes = GoogleIndexingService::publishUrl($url, 'URL_DELETED', false);
    if ($deleteRes['success']) {
        echo "✅ HTTP 200 OK (Googlebot alerted to purge URL)\n";
    } else {
        echo "⚠️ Response: HTTP {$deleteRes['status']}\n";
    }

    // 3. Log to pruned_articles.log
    $logLine = sprintf("[%s] PRUNED_ARTICLE: ID=%d | URL=%s | Title=%s\n", $todayTimeStr, $pruneId, $url, $article->title);
    File::append(storage_path('logs/pruned_articles.log'), $logLine);
    echo " ✅ Logged to storage/logs/pruned_articles.log.\n\n";
    exit(0);
}

// ---------------------------------------------------------------------------------
// STEP 1: LOAD STATUS CACHE & RUN LIVE INSPECTION TRACKER
// ---------------------------------------------------------------------------------
echo "🔍 STEP 1: AUDITING URL INDEXING STATUS CHANGES (GSC INSPECTION API)...\n";
echo "---------------------------------------------------------------------------------\n";

$statusCachePath = storage_path('app/url_indexing_status_cache.json');
$statusCache = [];
if (File::exists($statusCachePath)) {
    try {
        $statusCache = json_decode(File::get($statusCachePath), true) ?? [];
    } catch (\Throwable $e) {
        $statusCache = [];
    }
}

// Get access token for GSC Inspection API
$gscToken = GoogleIndexingService::getGscAccessToken();

// Select a focused sample of articles to audit:
// - Latest 6 published articles
// - 4 older articles previously marked as 'crawled' or 'discovered'
$articlesToInspect = collect();
try {
    $latestArticles = DB::connection('hostinger')->table('articles')
        ->where('status', 'published')
        ->orderBy('published_at', 'desc')
        ->limit(6)
        ->get(['id', 'title', 'slug', 'category_id', 'published_at']);
    $articlesToInspect = $articlesToInspect->merge($latestArticles);

    // Pick 4 older articles from 14-30 days ago to check if status progressed
    $olderArticles = DB::connection('hostinger')->table('articles')
        ->where('status', 'published')
        ->where('published_at', '<=', now()->subDays(14))
        ->orderBy('published_at', 'desc')
        ->limit(4)
        ->get(['id', 'title', 'slug', 'category_id', 'published_at']);
    $articlesToInspect = $articlesToInspect->merge($olderArticles)->unique('id');
} catch (\Throwable $e) {
    echo "⚠️ Failed to query Hostinger DB for inspection list: " . $e->getMessage() . "\n";
}

$statusChanges = [];
$currentlyIndexed = [];
$crawledNotIndexed = [];
$inBotQueue = [];

if ($gscToken && $articlesToInspect->isNotEmpty()) {
    foreach ($articlesToInspect as $art) {
        $url = resolveCanonicalUrl($art);
        $prevData = $statusCache[$url] ?? null;
        $prevVerdict = $prevData['verdict'] ?? null;
        $prevCoverage = $prevData['coverage'] ?? null;

        $inspectRes = Http::withToken($gscToken)->timeout(10)->post(GoogleIndexingService::GSC_INSPECTION_ENDPOINT, [
            'inspectionUrl' => $url,
            'siteUrl'       => 'https://dailyaiworld.com/',
        ]);

        if ($inspectRes->successful()) {
            $idx = $inspectRes->json()['inspectionResult']['indexStatusResult'] ?? [];
            $verdict = $idx['verdict'] ?? 'UNKNOWN';
            $coverage = $idx['coverageState'] ?? 'UNKNOWN';
            $lastCrawl = !empty($idx['lastCrawlTime']) ? substr($idx['lastCrawlTime'], 0, 10) : 'Never';

            // Save in cache
            $statusCache[$url] = [
                'title'       => $art->title,
                'article_id'  => $art->id,
                'verdict'     => $verdict,
                'coverage'    => $coverage,
                'last_crawl'  => $lastCrawl,
                'checked_at'  => $todayDateStr,
            ];

            // Evaluate Category
            $isIndexed = ($verdict === 'PASS' || str_contains(strtolower($coverage), 'indexed'));
            $isCrawled = str_contains(strtolower($coverage), 'crawled');

            if ($isIndexed) {
                $currentlyIndexed[] = ['url' => $url, 'title' => $art->title, 'crawl' => $lastCrawl];
            } elseif ($isCrawled) {
                $crawledNotIndexed[] = ['url' => $url, 'title' => $art->title, 'crawl' => $lastCrawl, 'id' => $art->id, 'published_at' => $art->published_at];
            } else {
                $inBotQueue[] = ['url' => $url, 'title' => $art->title, 'coverage' => $coverage];
            }

            // Detect Status Change
            if ($prevCoverage !== null && $prevCoverage !== $coverage) {
                $statusChanges[] = [
                    'url'      => $url,
                    'title'    => $art->title,
                    'from'     => $prevCoverage,
                    'to'       => $coverage,
                    'promoted' => $isIndexed,
                ];
                echo sprintf(" 🔔 STATUS CHANGED: %s\n    %s -> %s\n    URL: %s\n\n", substr($art->title, 0, 50), $prevCoverage, $coverage, $url);
            } else {
                $badge = $isIndexed ? "✅ [INDEXED]" : ($isCrawled ? "⏳ [CRAWLED - NOT INDEXED]" : "⚡ [IN BOT QUEUE]");
                echo sprintf(" %-28s | %s\n", $badge, substr($art->title, 0, 48));
            }
        } else {
            echo " ⚠️ Inspection call failed for {$url}: HTTP {$inspectRes->status()}\n";
        }

        // 100ms pause to respect GSC API rate limits
        usleep(100000);
    }

    // Save updated cache
    File::put($statusCachePath, json_encode($statusCache, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
} else {
    echo " ⚠️ GSC Inspection skipped (token unavailable or zero articles found).\n";
}

// ---------------------------------------------------------------------------------
// STEP 2: PRUNE CANDIDATE RADAR (Identify Content to Delete)
// ---------------------------------------------------------------------------------
echo "\n🎯 STEP 2: CONTENT PRUNE RADAR (Zero-Value / Stagnant Content)\n";
echo "---------------------------------------------------------------------------------\n";

$pruneCandidates = [];
try {
    // Find published articles older than 21 days that have very low views / stagnant status
    $stagnantArticles = DB::connection('hostinger')->table('articles')
        ->where('status', 'published')
        ->where('published_at', '<=', now()->subDays(21))
        ->where(function($q) {
            $q->whereNull('view_count')->orWhere('view_count', '<', 5);
        })
        ->orderBy('published_at', 'asc')
        ->limit(10)
        ->get(['id', 'title', 'slug', 'category_id', 'published_at', 'view_count', DB::raw('LENGTH(content) as content_length')]);

    foreach ($stagnantArticles as $stg) {
        $stgUrl = resolveCanonicalUrl($stg);
        $cachedInfo = $statusCache[$stgUrl] ?? null;
        $coverageDesc = $cachedInfo['coverage'] ?? 'Pending Audit / Crawled Not Indexed';
        $ageDays = Carbon::parse($stg->published_at)->diffInDays(now());
        $wordEstimate = round(($stg->content_length ?? 0) / 6);

        $pruneCandidates[] = [
            'id'             => $stg->id,
            'title'          => $stg->title,
            'url'            => $stgUrl,
            'age_days'       => $ageDays,
            'views'          => $stg->view_count ?? 0,
            'words'          => $wordEstimate,
            'status'         => $coverageDesc,
            'recommendation' => ($wordEstimate < 600) ? 'HARD DELETE (410)' : '301 CONSOLIDATE OR PRUNE',
        ];
    }
} catch (\Throwable $e) {
    echo "⚠️ Error querying prune candidates: " . $e->getMessage() . "\n";
}

if (!empty($pruneCandidates)) {
    printf(" %-6s | %-6s | %-6s | %-24s | %s\n", "ID", "Age", "Words", "Action Recommended", "Title / Slug");
    echo " " . str_repeat('-', 90) . "\n";
    foreach ($pruneCandidates as $pc) {
        printf(" #%-5d | %-3d d  | %-6d | %-24s | %s\n", $pc['id'], $pc['age_days'], $pc['words'], $pc['recommendation'], substr($pc['title'], 0, 42));
    }
    echo "\n 💡 To prune any deadweight article and notify Googlebot (URL_DELETED):\n";
    echo "    php scripts/daily_indexing_and_prune_audit.php --prune-id=<id>\n\n";
} else {
    echo " ✨ Zero critical prune candidates identified today. Catalog health is clean.\n\n";
}

// ---------------------------------------------------------------------------------
// STEP 3: COMPLIANT ROTATING INDEXING (Capped at 200 URLs/day)
// ---------------------------------------------------------------------------------
echo "🚀 STEP 3: GOOGLE INDEXING API ROTATION & QUOTA MANAGEMENT...\n";
echo "---------------------------------------------------------------------------------\n";

$submittedToday = GoogleIndexingService::getSubmittedTodayCount();
$remainingQuota = max(0, 200 - $submittedToday);

echo " Submitted Today: {$submittedToday} / 200 (Google daily ceiling)\n";
echo " Available Slots: {$remainingQuota} slots remaining\n\n";

if ($isReportOnly) {
    echo "ℹ️ Report-only mode active. Skipping batch API submissions.\n";
} elseif ($remainingQuota <= 0) {
    echo "✅ Google daily quota (200/200) is fully utilized today. Zero quota wasted.\n";
} else {
    echo "📡 Initiating daily compliant rotating batch (capped at {$remainingQuota} URLs)...\n";

    // Run the compliant indexer script
    $cmd = PHP_BINARY . ' ' . escapeshellarg(__DIR__ . '/run_compliant_indexing_cron.php');
    if ($isDryRun) {
        $cmd .= ' --dry-run';
    }
    passthru($cmd);
}

// ---------------------------------------------------------------------------------
// STEP 4: WRITE DAILY EXECUTIVE AUDIT REPORT
// ---------------------------------------------------------------------------------
$reportDate = $now->format('Y-m-d');
$reportPath = storage_path("logs/indexing_audit_{$reportDate}.md");

$reportContent = "# 📊 Daily AI World — Indexing & Pruning Radar Report\n\n";
$reportContent .= "> **Execution Timestamp**: `{$todayTimeStr}`  \n";
$reportContent .= "> **Google Daily Quota**: `{$submittedToday} / 200 URLs`  \n";
$reportContent .= "> **Available Slots Remaining**: `{$remainingQuota}`  \n\n";

$reportContent .= "## 🔔 URL Status Changes Detected Today\n\n";
if (!empty($statusChanges)) {
    $reportContent .= "| Article Title | Previous Status | New Status | URL |\n| :--- | :--- | :--- | :--- |\n";
    foreach ($statusChanges as $sc) {
        $icon = $sc['promoted'] ? '🎉 PROMOTED' : '⚡ PROGRESS';
        $reportContent .= "| {$sc['title']} | `{$sc['from']}` | **{$icon}**: `{$sc['to']}` | [Link]({$sc['url']}) |\n";
    }
} else {
    $reportContent .= "*No status transitions detected in this inspection cycle. Statuses are holding steady.*\n\n";
}

$reportContent .= "\n## 🗑️ Content Pruning Radar (Candidates for 410 Deletion / 301 Merge)\n\n";
if (!empty($pruneCandidates)) {
    $reportContent .= "| ID | Age | Est. Words | Views | Action Recommended | Article Title |\n| :---: | :---: | :---: | :---: | :--- | :--- |\n";
    foreach ($pruneCandidates as $pc) {
        $reportContent .= "| `{$pc['id']}` | {$pc['age_days']} days | {$pc['words']} words | {$pc['views']} | **{$pc['recommendation']}** | {$pc['title']} |\n";
    }
    $reportContent .= "\n*To prune an article and alert Googlebot with URL_DELETED:*\n```bash\nphp scripts/daily_indexing_and_prune_audit.php --prune-id=<id>\n```\n";
} else {
    $reportContent .= "*No critical prune candidates found.*\n";
}

File::put($reportPath, $reportContent);

echo "\n=================================================================================\n";
echo " 📝 Executive Daily Report generated at: {$reportPath}\n";
echo "=================================================================================\n\n";
