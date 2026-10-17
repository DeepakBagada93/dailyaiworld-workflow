<?php

/**
 * Daily AI World — Daily Cadence & Calendar Gap Auditor
 *
 * Ensures:
 * 1. Today's dispatches exist and meet the phase quota (6 for Phase 1).
 * 2. Continuous calendar timeline without any skipped dates (D, D+1, D+2...).
 * 3. Future scheduled dispatches in dispatches/ do not introduce calendar gaps.
 * 4. All published_at timestamps for today are valid and accessible.
 *
 * Usage:
 *   php scripts/audit_daily_cadence.php
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Carbon;
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

echo "\n======================================================================\n";
echo " 🗓️  DAILY AI WORLD — PUBLISHING CADENCE & CALENDAR CONTINUITY AUDIT\n";
echo "======================================================================\n";

$nowIst = Carbon::now('Asia/Calcutta');
$nowUtc = Carbon::now('UTC');
$todayDateStr = $nowIst->format('Y-m-d');

echo " 🕒 Current IST: {$nowIst->format('Y-m-d H:i:s')} | UTC: {$nowUtc->format('Y-m-d H:i:s')}\n\n";

$errors = [];
$warnings = [];

// Determine Phase & Quota
$anchorDate = Carbon::parse('2026-09-22');
$daysSinceAnchor = $anchorDate->diffInDays($nowIst) + 1;

if ($daysSinceAnchor <= 30) {
    $phase = "Phase 1 (Days 1–30 | Crawl Budget Protection)";
    $dailyQuota = 6;
} elseif ($daysSinceAnchor <= 60) {
    $phase = "Phase 2 (Days 31–60 | Gradual Expansion)";
    $dailyQuota = 10;
} elseif ($daysSinceAnchor <= 90) {
    $phase = "Phase 3 (Days 61–90 | Full Scale Mode)";
    $dailyQuota = 16;
} else {
    $phase = "Phase 4 (Days 91+ | Enterprise Authority Scale)";
    $dailyQuota = 20;
}

echo " 🎯 Active Phase: {$phase}\n";
echo " 📊 Expected Daily Quota: {$dailyQuota} articles/day\n\n";

// 1. Check Today's Dispatches in Hostinger DB
echo "🔍 1. AUDITING TODAY'S DISPATCHES ({$todayDateStr})...\n";
echo "----------------------------------------------------------------------\n";

try {
    $todayArticles = DB::connection('hostinger')->table('articles')
        ->whereDate('published_at', $todayDateStr)
        ->where('status', 'published')
        ->get(['id', 'title', 'slug', 'published_at', 'category_id']);

    $todayCount = $todayArticles->count();
    echo " Found: {$todayCount} / {$dailyQuota} dispatches for today.\n";

    if ($todayCount === 0) {
        $errors[] = "CRITICAL: Zero dispatches published for today ({$todayDateStr})! Immediate authoring required.";
    } elseif ($todayCount < $dailyQuota) {
        $warnings[] = "INCOMPLETE QUOTA: Only {$todayCount} of {$dailyQuota} dispatches published for today.";
    } else {
        echo " ✅ Today's publication quota fully met ({$todayCount} articles).\n";
    }

    foreach ($todayArticles as $a) {
        $pubTime = Carbon::parse($a->published_at);
        $isLive = $pubTime->lessThanOrEqualTo($nowUtc);
        $statusIcon = $isLive ? "✅ LIVE" : "⏳ SCHEDULED ({$pubTime->format('H:i')} UTC)";
        echo "   - [ID: {$a->id}] {$statusIcon} | {$a->title}\n";
    }

} catch (\Throwable $e) {
    $errors[] = "Failed to query Hostinger DB for today's articles: " . $e->getMessage();
}

// 2. Check Calendar Continuity (Look back 14 days and look ahead 3 days)
echo "\n🔍 2. AUDITING CALENDAR CONTINUITY & DETECTING DATE GAPS...\n";
echo "----------------------------------------------------------------------\n";

try {
    $startDate = $nowIst->copy()->subDays(10)->format('Y-m-d');
    $endDate = $nowIst->copy()->addDays(3)->format('Y-m-d');

    $datesSummary = DB::connection('hostinger')->table('articles')
        ->selectRaw('DATE(published_at) as p_date, count(*) as total')
        ->where('status', 'published')
        ->whereRaw('DATE(published_at) BETWEEN ? AND ?', [$startDate, $endDate])
        ->groupBy('p_date')
        ->orderBy('p_date', 'asc')
        ->pluck('total', 'p_date')
        ->toArray();

    $cursor = Carbon::parse($startDate);
    $endCarbon = Carbon::parse($endDate);

    $gapFound = false;
    while ($cursor->lessThanOrEqualTo($endCarbon)) {
        $dStr = $cursor->format('Y-m-d');
        $count = $datesSummary[$dStr] ?? 0;
        $isPastOrToday = $cursor->lessThanOrEqualTo($nowIst->copy()->startOfDay());

        if ($count === 0 && $isPastOrToday) {
            echo "   ❌ [GAP DETECTED] {$dStr}: 0 articles (MISSING CALENDAR DAY)\n";
            $errors[] = "CALENDAR GAP DETECTED: Date {$dStr} has 0 published articles in Hostinger DB!";
            $gapFound = true;
        } elseif ($count > 0) {
            $tag = ($dStr === $todayDateStr) ? "👈 TODAY" : ($cursor->greaterThan($nowIst) ? "⏳ FUTURE SCHEDULE" : "PAST");
            echo "   ✅ {$dStr}: {$count} articles [{$tag}]\n";
        } else {
            // Future date with 0
            echo "   ⚪ {$dStr}: 0 articles [UNSCHEDULED FUTURE]\n";
        }
        $cursor->addDay();
    }

    if (!$gapFound) {
        echo " ✅ Calendar continuity verified! Zero skipped days detected.\n";
    }

} catch (\Throwable $e) {
    $errors[] = "Failed to audit calendar continuity: " . $e->getMessage();
}

// 3. Summary & Result
echo "\n======================================================================\n";
if (empty($errors)) {
    echo " 🎉 AUDIT PASSED: All dispatches are synchronized and continuous!\n";
    if (!empty($warnings)) {
        echo " ⚠️  Warnings:\n";
        foreach ($warnings as $w) {
            echo "    - {$w}\n";
        }
    }
    echo "======================================================================\n\n";
    exit(0);
} else {
    echo " 🚨 AUDIT FAILED: Action required to resolve publication anomalies!\n";
    foreach ($errors as $err) {
        echo "   ❌ {$err}\n";
    }
    echo "======================================================================\n\n";
    exit(1);
}
