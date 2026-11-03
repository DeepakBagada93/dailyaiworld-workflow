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

