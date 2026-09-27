<?php

/**
 * Daily AI World — Day-Wise Indexing Reminder & Live Inspection Radar
 *
 * 1. FIRST: Checks whether today's / latest published URLs are indexed via Google Search Console Inspection API.
 * 2. SECOND: Checks today's Google Indexing API quota usage (200 URLs/day).
 * 3. THIRD: Displays today's scheduled rotation task & next actionable steps.
 *
 * Usage:
 *   php scripts/daily_indexing_reminder.php               # Full check (Inspection + Quota + Task)
 *   php scripts/daily_indexing_reminder.php --quick       # Skip URL inspection, quota & task only
 *   php scripts/daily_indexing_reminder.php --run-today   # Execute today's scheduled batch
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GoogleIndexingService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

$options = getopt('', ['quick', 'run-today', 'limit:']);
$today = Carbon::now('Asia/Calcutta');
$todayDateStr = $today->format('Y-m-d');
$todayDayName = $today->format('l');

echo "\n======================================================================\n";
echo " 🔔 DAILY AI WORLD — GOOGLE INDEXING & TRAFFIC RADAR\n";
echo "======================================================================\n";
echo " 📅 Date: {$todayDateStr} ({$todayDayName})\n\n";

// =====================================================================
// STEP 1: CHECK TODAY'S URLS LIVE INDEXING STATUS VIA GSC INSPECTION API
// =====================================================================
if (!isset($options['quick'])) {
    echo "🔍 STEP 1: CHECKING TODAY'S URLS IN GOOGLE SEARCH CONSOLE...\n";
    echo "----------------------------------------------------------------------\n";

    try {
        // Fetch 4 latest published articles from Hostinger Live DB
        $latestArticles = DB::connection('hostinger')->table('articles')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->select('id', 'title', 'slug', 'category_id', 'published_at')
            ->get();

        // Get Google OAuth token for Webmasters scope
        $credPath = GoogleIndexingService::getCredentialsPath();
        if ($credPath && file_exists($credPath)) {
            $creds = json_decode(file_get_contents($credPath), true);
            $now = time();
            $header = ['alg' => 'RS256', 'typ' => 'JWT'];
            $claims = [
                'iss'   => $creds['client_email'],
                'scope' => 'https://www.googleapis.com/auth/webmasters.readonly',
                'aud'   => 'https://oauth2.googleapis.com/token',
                'exp'   => $now + 3600,
                'iat'   => $now,
            ];
            $b64Header = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
            $b64Claims = rtrim(strtr(base64_encode(json_encode($claims)), '+/', '-_'), '=');
            $sigInput = $b64Header . '.' . $b64Claims;
            $privateKey = openssl_pkey_get_private($creds['private_key']);
            openssl_sign($sigInput, $sig, $privateKey, OPENSSL_ALGO_SHA256);
            $jwt = $sigInput . '.' . rtrim(strtr(base64_encode($sig), '+/', '-_'), '=');

            $tokenRes = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt,
            ]);
            $gscToken = $tokenRes->json()['access_token'] ?? null;
        } else {
            $gscToken = null;
        }

        if ($gscToken && $latestArticles->isNotEmpty()) {
            foreach ($latestArticles as $art) {
                $prefix = match((int)$art->category_id) {
                    1 => 'workflow',
                    5 => 'mcp-directory',
                    default => 'blogs'
                };
                $fullUrl = "https://dailyaiworld.com/{$prefix}/{$art->slug}";

                $inspectRes = Http::withToken($gscToken)->timeout(10)->post('https://searchconsole.googleapis.com/v1/urlInspection/index:inspect', [
                    'inspectionUrl' => $fullUrl,
                    'siteUrl' => 'https://dailyaiworld.com/',
                ]);

                if ($inspectRes->successful()) {
                    $idx = $inspectRes->json()['inspectionResult']['indexStatusResult'] ?? [];
                    $verdict = $idx['verdict'] ?? 'UNKNOWN';
                    $coverage = $idx['coverageState'] ?? 'UNKNOWN';
                    $lastCrawl = !empty($idx['lastCrawlTime']) ? substr($idx['lastCrawlTime'], 0, 10) : 'Never';

                    if ($verdict === 'PASS' || str_contains(strtolower($coverage), 'indexed')) {
                        $badge = "✅ [INDEXED]";
                    } elseif (str_contains(strtolower($coverage), 'crawled')) {
                        $badge = "⏳ [CRAWLED - PENDING INDEX]";
                    } else {
                        $badge = "⚡ [IN BOT QUEUE]";
                    }

                    echo sprintf(" %-30s | %s\n", $badge, substr($art->title, 0, 48));
                    echo sprintf("   URL:     %s\n", $fullUrl);
                    echo sprintf("   Status:  Verdict=%s | Coverage=%s | Last Crawled=%s\n\n", $verdict, $coverage, $lastCrawl);
                } else {
                    echo " ⚠️  Could not inspect {$fullUrl}: HTTP {$inspectRes->status()}\n";
                }
            }
        } else {
            echo " ⚠️  GSC Inspection token unavailable or no articles found.\n\n";
        }
    } catch (\Throwable $e) {
        echo " ⚠️  Live inspection check skipped: " . $e->getMessage() . "\n\n";
    }
}

// =====================================================================
// STEP 2: CHECK TODAY'S GOOGLE INDEXING API QUOTA
// =====================================================================
echo "📊 STEP 2: CHECKING GOOGLE INDEXING API QUOTA USAGE...\n";
echo "----------------------------------------------------------------------\n";

$submittedToday = GoogleIndexingService::getSubmittedTodayCount();
$remainingQuota = max(0, 200 - $submittedToday);

echo " Submitted Today:   {$submittedToday} / 200 URLs (Google daily quota)\n";
echo " Remaining Slots:   {$remainingQuota} URLs available today\n\n";

// =====================================================================
// STEP 3: SCHEDULED ROTATION TASK & ACTION REMINDER
// =====================================================================
echo "🎯 STEP 3: TODAY'S SCHEDULED TASK & NEXT ACTION...\n";
echo "----------------------------------------------------------------------\n";

// 7-Day Master Rotation Schedule Map
$schedule = [
    '2026-09-27' => [
        'day' => 'Day 1 (Sunday, Sep 27)',
        'target' => 'Top September 2026 Dispatches & Core Hubs (200 URLs)',
        'command' => 'php scripts/fast_google_index.php --month=09 --force --limit=200',
        'secondary' => 'Submit all 1,198+ URLs to Bing/IndexNow & Fix /public/ .htaccess',
    ],
    '2026-09-28' => [
        'day' => 'Day 2 (Monday, Sep 28)',
        'target' => '173 Discovered Backlog URLs (Table 24 sept.csv)',
        'command' => 'php scripts/resubmit_discovered_urls.php',
        'secondary' => 'Verify GSC coverage transition from Discovered to Crawled',
    ],
    '2026-09-29' => [
        'day' => 'Day 3 (Tuesday, Sep 29)',
        'target' => 'August 2026 Workflows Batch (200 URLs)',
        'command' => 'php scripts/fast_google_index.php --month=08 --limit=200',
        'secondary' => 'Submit IndexNow batch for recent workflows',
    ],
    '2026-09-30' => [
        'day' => 'Day 4 (Wednesday, Sep 30)',
        'target' => 'August 2026 MCP Directory Servers Batch (200 URLs)',
        'command' => 'php scripts/fast_google_index.php --month=08 --limit=200',
        'secondary' => 'Verify /mcp-directory canonical recrawl status in GSC',
    ],
    '2026-10-01' => [
        'day' => 'Day 5 (Thursday, Oct 01)',
        'target' => 'August 2026 AI Blogs Batch (200 URLs)',
        'command' => 'php scripts/fast_google_index.php --month=08 --limit=200',
        'secondary' => 'Submit IndexNow batch for blogs',
    ],
    '2026-10-02' => [
        'day' => 'Day 6 (Friday, Oct 02)',
        'target' => 'Core Hubs, High-Intent Keywords & Missing Slugs (200 URLs)',
        'command' => 'php scripts/fast_google_index.php --all --limit=200',
        'secondary' => 'Re-index evergreen pillar articles',
    ],
    '2026-10-03' => [
        'day' => 'Day 7 (Saturday, Oct 03)',
        'target' => 'Full Google Search Console & GA4 Indexing Verification Audit',
        'command' => 'php scripts/fast_google_index.php --status',
        'secondary' => 'Check GSC Inspection API & run updated traffic report',
    ],
];

$currentTask = $schedule[$todayDateStr] ?? [
    'day' => "Ongoing Daily Routine ({$todayDayName}, {$todayDateStr})",
    'target' => "Daily Dispatches + Unindexed Hostinger Backlog (200 URLs)",
    'command' => 'php scripts/fast_google_index.php --month=' . $today->format('m') . ' --limit=200',
    'secondary' => 'Queue newly published articles to Google Indexing API + IndexNow',
];

echo " Task Assigned:     {$currentTask['day']}\n";
echo " Batch Target:      {$currentTask['target']}\n";
echo " Secondary Task:    {$currentTask['secondary']}\n\n";

if ($submittedToday >= 200) {
    echo " ✅ STATUS: Today's Google quota (200/200) has already been SUBMITTED!\n";
    echo " ℹ️  All 200 target URLs are currently in Googlebot's active priority crawl queue.\n";
    echo " ➡️  YOU MAY NOW PROCEED TO PUBLISH TODAY'S DISPATCHES OR WORK ON SITE FEATURES.\n";
} else {
    echo " ⚠️  ACTION REQUIRED: Today's batch has not been fully submitted yet.\n";
    echo " Run this command now to submit today's 200 batch:\n\n";
    echo "   \033[1;32m{$currentTask['command']}\033[0m\n\n";
    echo " Once submitted, proceed to search & write new dispatches in sequence.\n";
}

echo "======================================================================\n\n";

// Execute automatically if --run-today is specified
if (isset($options['run-today'])) {
    if ($remainingQuota <= 0) {
        echo "⚠️ Quota already exhausted. Skipping execution.\n";
        exit(0);
    }
    echo "🚀 Running today's command: {$currentTask['command']} ...\n";
    passthru($currentTask['command']);
}
