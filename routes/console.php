<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('indexing:radar {--quick : Skip URL inspection} {--run-today : Automatically submit remaining quota to Google Indexing API}', function () {
    $script = base_path('scripts/daily_indexing_reminder.php');
    $args = '';
    if ($this->option('quick')) {
        $args .= ' --quick';
    }
    if ($this->option('run-today')) {
        $args .= ' --run-today';
    }
    passthru(PHP_BINARY . ' ' . escapeshellarg($script) . $args);
})->purpose('Audit dispatch cadence, inspect live GSC indexing status, and submit daily quota to Google Indexing API');

// Automated Daily Indexing Routine: Executes at 06:00 IST (00:30 UTC)
Schedule::command('indexing:radar --run-today')
    ->dailyAt('00:30')
    ->timezone('UTC')
    ->name('daily-indexing-radar')
    ->withoutOverlapping();

Artisan::command('indexing:compliant {--dry-run : Simulate submission without sending API requests}', function () {
    if ($this->option('dry-run')) {
        $_SERVER['argv'][] = '--dry-run';
    }
    require base_path('scripts/run_compliant_indexing_cron.php');
})->purpose('100% Google guideline-compliant smart rotating indexing batch (max 200 URLs)');

// Automated Compliant Daily Indexing Routine: Executes at 08:30 IST (03:00 UTC)
Schedule::command('indexing:compliant')
    ->dailyAt('03:00')
    ->timezone('UTC')
    ->name('daily-compliant-indexer')
    ->withoutOverlapping();

