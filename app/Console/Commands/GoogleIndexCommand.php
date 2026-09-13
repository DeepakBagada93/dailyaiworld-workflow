<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\GoogleIndexingService;
use App\Services\IndexingService;
use Illuminate\Console\Command;

class GoogleIndexCommand extends Command
{
    protected $signature = 'seo:google-index 
                            {--month=08,09 : Comma-separated months to index (e.g. 08,09)}
                            {--year=2026 : Target publication year}
                            {--limit=200 : Maximum URLs to submit (Google daily quota is 200)}
                            {--all : Submit all matching URLs without limit}
                            {--force : Force re-submission of previously submitted URLs}
                            {--test : Test API credentials and connectivity with 1 URL}
                            {--status : Show today\'s quota usage and history}
                            {--dry-run : Preview URLs without submitting}
                            {--indexnow : Also submit to IndexNow (Bing/Yandex)}';

    protected $description = 'Submit published articles directly to the Google Indexing API (URL_UPDATED)';

    public function handle(): int
    {
        $this->info("=========================================================");
        $this->info(" 🚀 Daily AI World — Google Fast Indexing Engine");
        $this->info("=========================================================");

        if ($this->option('status')) {
            $todayCount = GoogleIndexingService::getSubmittedTodayCount();
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Submitted Today (200 limit)', "{$todayCount} / 200"],
                    ['Service Account', env('GA_SERVICE_ACCOUNT_EMAIL', 'N/A')],
                    ['Project ID', env('GOOGLE_PROJECT_ID', 'N/A')],
                    ['Credentials File', GoogleIndexingService::getCredentialsPath() ?: 'NOT FOUND'],
                ]
            );
            return 0;
        }

        if ($this->option('test')) {
            $testUrl = 'https://dailyaiworld.com/';
            $this->info("Testing Google Indexing API with {$testUrl}...");
            $res = GoogleIndexingService::publishUrl($testUrl);

            if ($res['success']) {
                $this->info("✅ SUCCESS! Google Indexing API accepted request (HTTP 200).");
                return 0;
            }

            $this->error("❌ Google Indexing API Error (HTTP {$res['status']})");
            if (!empty($res['friendly_error'])) {
                $this->warn($res['friendly_error']);
            }
            return 1;
        }

        $year = (string) $this->option('year');
        $months = array_map('trim', explode(',', (string) $this->option('month')));
        $limit = $this->option('all') ? null : (int) $this->option('limit');
        $isDryRun = (bool) $this->option('dry-run');
        $isForce = (bool) $this->option('force');

        $this->info("Year: " . $year . " | Months: " . implode(', ', $months) . " | Limit: " . ($limit ?? 'ALL'));

        $query = Article::published()->whereNotNull('published_at');
        $query->where(function ($q) use ($year, $months) {
            foreach ($months as $i => $m) {
                $monthFormatted = str_pad($m, 2, '0', STR_PAD_LEFT);
                $start = "{$year}-{$monthFormatted}-01 00:00:00";
                $end = date("Y-m-t 23:59:59", strtotime($start));
                if ($i === 0) {
                    $q->whereBetween('published_at', [$start, $end]);
                } else {
                    $q->orWhereBetween('published_at', [$start, $end]);
                }
            }
        })->latest('published_at');

        $articles = $query->get();
        $this->info("Found {$articles->count()} articles published in specified timeframe.");

        $candidates = [];
        foreach ($articles as $art) {
            $url = $art->url;
            if (!$isForce && GoogleIndexingService::isAlreadySubmitted($url)) {
                continue;
            }
            $candidates[] = [
                'title' => $art->title,
                'url'   => $url,
                'date'  => $art->published_at ? $art->published_at->format('Y-m-d H:i') : 'N/A',
            ];
            if ($limit && count($candidates) >= $limit) {
                break;
            }
        }

        $this->info("Selected " . count($candidates) . " candidate URLs.");

        if (empty($candidates)) {
            $this->warn("No pending URLs to submit. Use --force to re-submit.");
            return 0;
        }

        if ($isDryRun) {
            $this->table(
                ['Date', 'Title', 'URL'],
                array_map(fn($c) => [$c['date'], substr($c['title'], 0, 40) . '...', $c['url']], array_slice($candidates, 0, 15))
            );
            $this->info("Dry run complete. Run without --dry-run to submit to Google.");
            return 0;
        }

        $bar = $this->output->createProgressBar(count($candidates));
        $bar->start();

        $success = 0;
        $failed = 0;
        $urlsList = [];

        foreach ($candidates as $cand) {
            $urlsList[] = $cand['url'];
            $res = GoogleIndexingService::publishUrl($cand['url'], 'URL_UPDATED');
            if ($res['success']) {
                $success++;
            } else {
                $failed++;
                if (in_array($res['status'], [401, 403])) {
                    $bar->finish();
                    $this->newLine(2);
                    $this->error("Stopped: " . ($res['friendly_error'] ?? "Auth/Permission error"));
                    return 1;
                }
            }
            $bar->advance();
            usleep(150000);
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Done! Successful: {$success} | Failed: {$failed}");

        if ($this->option('indexnow')) {
            $this->info("Submitting to IndexNow...");
            IndexingService::submitToIndexNow($urlsList);
        }

        return $failed > 0 ? 1 : 0;
    }
}
