<?php

/**
 * Daily AI World — Day-Wise Indexing Reminder & Status Monitor
 *
 * Checks Google Indexing API daily quota (200 URLs/day), identifies the scheduled
 * batch for today according to the 7-day rotation plan, and prints actionable commands.
 *
 * Usage:
 *   php scripts/daily_indexing_reminder.php
 *   php scripts/daily_indexing_reminder.php --run-today
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GoogleIndexingService;
use Illuminate\Support\Carbon;

$today = Carbon::now('Asia/Calcutta');
$todayDateStr = $today->format('Y-m-d');
$todayDayName = $today->format('l');

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

// Fallback for ongoing days beyond Day 7 (Ongoing daily routine)
$currentTask = $schedule[$todayDateStr] ?? [
    'day' => "Ongoing Daily Routine ({$todayDayName}, {$todayDateStr})",
    'target' => "Daily Dispatches + Unindexed Hostinger Backlog (200 URLs)",
    'command' => 'php scripts/fast_google_index.php --month=' . $today->format('m') . ' --limit=200',
    'secondary' => 'Queue newly published articles to Google Indexing API + IndexNow',
];

$submittedToday = GoogleIndexingService::getSubmittedTodayCount();
$remainingQuota = max(0, 200 - $submittedToday);

echo "\n======================================================================\n";
echo " 🔔 DAILY AI WORLD — GOOGLE INDEXING & TRAFFIC RADAR\n";
echo "======================================================================\n";
echo " 📅 Date:           {$todayDateStr} ({$todayDayName})\n";
echo " 📊 Google Quota:   {$submittedToday} / 200 URLs Submitted Today\n";
echo " ⚡ Available Slots: {$remainingQuota} URLs remaining\n";
echo "----------------------------------------------------------------------\n";
echo " 🎯 Scheduled Task: {$currentTask['day']}\n";
echo " 📌 Target:         {$currentTask['target']}\n";
echo " 💡 Secondary Goal: {$currentTask['secondary']}\n";
echo "----------------------------------------------------------------------\n";

if ($submittedToday >= 200) {
    echo " ✅ Daily Google quota (200/200) is MAXED for today! Good job.\n";
    echo " ℹ️ Next batch unlocks at midnight Google Cloud PST.\n";
} else {
    echo " ⚠️ ACTION REQUIRED TODAY:\n";
    echo " Run this command now to submit today's scheduled 200 batch:\n\n";
    echo "   \033[1;32m{$currentTask['command']}\033[0m\n\n";
}
echo "======================================================================\n\n";

// Execute automatically if --run-today is specified
$options = getopt('', ['run-today']);
if (isset($options['run-today'])) {
    if ($remainingQuota <= 0) {
        echo "⚠️ Quota already exhausted. Skipping execution.\n";
        exit(0);
    }
    echo "🚀 Running today's command: {$currentTask['command']} ...\n";
    passthru($currentTask['command']);
}
