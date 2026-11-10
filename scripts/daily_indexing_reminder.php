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
// STEP 0: AUDIT TODAY'S PUBLISHING CADENCE & CALENDAR CONTINUITY
// =====================================================================
echo "📋 STEP 0: AUDITING TODAY'S DISPATCH CADENCE & CALENDAR CONTINUITY...\n";
echo "----------------------------------------------------------------------\n";
passthru(PHP_BINARY . ' ' . escapeshellarg(__DIR__ . '/audit_daily_cadence.php'));

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
echo "🎯 STEP 3: 10-DAY EMERGENCY INDEXING RECOVERY TASKBOARD\n";
echo "----------------------------------------------------------------------\n";

// 10-Day Emergency Recovery Protocol Schedule (Anchor: 2026-11-09)
$recoverySchedule = [
    '2026-11-09' => [
        'day' => 'Day 1 (Mon, Nov 9)',
        'target' => '404 Purge & HTTP 410 Setup (Kill 783 GSC 404s)',
        'status' => 'COMPLETED / VALIDATION RUNNING',
        'action' => 'HTTP 410 deployed, 15 GSC prefixes removed, and GSC Validation officially started.',
    ],
    '2026-11-10' => [
        'day' => 'Day 2 (Tue, Nov 10)',
        'target' => 'Sitemap Quarantine (Trim 1,693 URLs down to top 100–150 pillar guides)',
        'status' => 'COMPLETED',
        'action' => 'Sitemaps trimmed to 153 curated URLs and re-submitted to GSC API (HTTP 204 OK).',
    ],
    '2026-11-11' => [
        'day' => 'Day 3 (Wed, Nov 11)',
        'target' => 'Thin Directory Stub Protection (Inject noindex, follow on shallow stubs)',
        'status' => 'COMPLETED (AHEAD OF SCHEDULE)',
        'action' => 'Dynamic noindex injected on articles < 600 words, paginated loops, and search pages.',
    ],
    '2026-11-12' => [
        'day' => 'Day 4 (Thu, Nov 12)',
        'target' => 'Pillar Guide Consolidation (Merge overlapping short stubs into 2k+ blueprints)',
        'status' => 'UPCOMING',
        'action' => 'Identify 5 cannibalized articles, consolidate into master guide, 301 redirect legacy slugs.',
    ],
    '2026-11-13' => [
        'day' => 'Day 5 (Fri, Nov 13)',
        'target' => 'Flagship Dev.to Backlink Blast (DA 92 Authority Building)',
        'status' => 'UPCOMING',
        'action' => 'Syndicate top 3 dispatches to Dev.to using php scripts/syndicate_to_devto.php with verified canonical.',
    ],
    '2026-11-14' => [
        'day' => 'Day 6 (Sat, Nov 14)',
        'target' => 'Internal Link Recirculation Overhaul',
        'status' => 'UPCOMING',
        'action' => 'Inject deep links inside the 18 currently indexed pages pointing to unindexed priority guides.',
    ],
    '2026-11-15' => [
        'day' => 'Day 7 (Sun, Nov 15)',
        'target' => 'Wikipedia & High-Trust Authority Discovery',
        'status' => 'UPCOMING',
        'action' => 'Run dailyai-wiki-backlinks to discover and match empirical benchmarks to citations needed.',
    ],
    '2026-11-16' => [
        'day' => 'Day 8 (Mon, Nov 16)',
        'target' => 'Server Performance & Crawl Efficiency Audit',
        'status' => 'UPCOMING',
        'action' => 'Audit TTFB (< 250ms), HTTP/2 caching, Core Web Vitals to maximize crawl throughput.',
    ],
    '2026-11-17' => [
        'day' => 'Day 9 (Tue, Nov 17)',
        'target' => 'GitHub & Multi-Platform Referral Push',
        'status' => 'UPCOMING',
        'action' => 'Submit MCP servers to GitHub awesome-lists; syndicate 2nd flagship to Dev.to/Hashnode.',
    ],
    '2026-11-18' => [
        'day' => 'Day 10 (Wed, Nov 18)',
        'target' => 'GSC Validation & Trajectory Audit',
        'status' => 'UPCOMING',
        'action' => 'Re-extract GSC coverage charts, verify 404 elimination and unindexed backlog promotion.',
    ],
];

$activePlan = $recoverySchedule[$todayDateStr] ?? [
    'day' => "Day 10+ Post-Quarantine Monitoring ({$todayDateStr})",
    'target' => 'Audit GSC indexing transition (>50% target) and plan gradual sitemap unquarantine',
    'status' => 'ONGOING',
    'action' => 'Inspect indexation curve and gradually add 25 upgraded articles per week into sitemap.',
];

echo " 🚨 QUARANTINE STATUS: ACTIVE (Mass publishing halted | Max 1 Flagship/day)\n";
echo " 📅 Recovery Phase:   {$activePlan['day']}\n";
echo " 🎯 Today's Target:   {$activePlan['target']}\n";
echo " ⚡ Action Required:  {$activePlan['action']}\n\n";

echo " 📋 10-DAY ROADMAP OVERVIEW:\n";
foreach ($recoverySchedule as $dateKey => $plan) {
    $marker = ($dateKey === $todayDateStr) ? "👉 [TODAY]" : ($dateKey < $todayDateStr ? "✅ [DONE] " : "⏳ [PLAN] ");
    echo "  {$marker} {$plan['day']}: {$plan['target']}\n";
}
echo "\n";

$prevMonth = date('m', strtotime('-1 month'));
$currMonth = $today->format('m');
$targetMonths = ($prevMonth === $currMonth) ? $currMonth : "{$prevMonth},{$currMonth}";
$defaultCommand = "php scripts/daily_indexing_and_prune_audit.php";

echo " Task Assigned:     {$activePlan['day']}\n";
echo " Batch Target:      {$activePlan['target']}\n";
echo " Action Step:       {$activePlan['action']}\n\n";

if ($submittedToday >= 200) {
    echo " ✅ STATUS: Today's Google quota (200/200) has already been SUBMITTED!\n";
    echo " ℹ️  All 200 target URLs are currently in Googlebot's active priority crawl queue.\n";
    echo " ➡️  Cadence is fully satisfied for today.\n";
} else {
    echo " ⚠️  ACTION REQUIRED: Today's quota has {$remainingQuota} slots available.\n";
    echo " Run this command now (or use --run-today) to submit the batch:\n\n";
    echo "   \033[1;32m{$defaultCommand}\033[0m\n\n";
    echo " Or run via Artisan: \033[1;36mphp artisan indexing:radar --run-today\033[0m\n";
}

echo "======================================================================\n\n";

// Execute automatically if --run-today is specified
if (isset($options['run-today'])) {
    if ($remainingQuota <= 0) {
        echo "⚠️ Quota already exhausted. Skipping execution.\n";
        exit(0);
    }
    
    echo "🌐 Step 3A: Ensuring Core Directory Hubs are fresh in Google Index...\n";
    $hubs = [
        'https://dailyaiworld.com/',
        'https://dailyaiworld.com/workflows',
        'https://dailyaiworld.com/mcp-directory',
        'https://dailyaiworld.com/latest-ai-news',
    ];
    foreach ($hubs as $hub) {
        $res = GoogleIndexingService::publishUrl($hub, 'URL_UPDATED');
        echo "   -> {$hub} : " . ($res['success'] ? '✅ OK (200)' : "⚠️ HTTP {$res['status']}") . "\n";
    }
    
    $remainingAfterHubs = max(0, 200 - GoogleIndexingService::getSubmittedTodayCount());
    if ($remainingAfterHubs > 0) {
        $execCommand = "php scripts/fast_google_index.php --month={$targetMonths} --force --limit={$remainingAfterHubs} --submit-indexnow";
        echo "\n🚀 Step 3B: Running batch command: {$execCommand} ...\n";
        passthru($execCommand);
    }
}
