<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\IndexingService;
use Illuminate\Console\Command;

class FastIndexCommand extends Command
{
    protected $signature = 'seo:fast-index {--limit=50 : Number of recent articles to submit} {--all : Submit all published articles}';
    protected $description = 'Submit published articles immediately to IndexNow (Bing/Yandex) and ping Google & Bing sitemaps';

    public function handle(): int
    {
        $this->info('Starting Fast Indexing submission for Daily AI World...');

        $query = Article::published()->latest('published_at');
        
        if (!$this->option('all')) {
            $limit = (int) $this->option('limit');
            $query->take($limit);
        }

        $articles = $query->get();
        $this->info("Found {$articles->count()} published articles to index.");

        if ($articles->isEmpty()) {
            $this->warn('No published articles found.');
            return 0;
        }

        // Build list of URLs including homepage and hub directories
        $urls = [
            'https://dailyaiworld.com/',
            'https://dailyaiworld.com/workflows',
            'https://dailyaiworld.com/mcp-directory',
            'https://dailyaiworld.com/latest-ai-news',
            'https://dailyaiworld.com/sitemap.xml',
            'https://dailyaiworld.com/feed.xml',
            'https://dailyaiworld.com/llms.txt',
        ];

        foreach ($articles as $art) {
            $urls[] = $art->url;
        }

        $this->info("Submitting " . count($urls) . " total URLs to IndexNow...");
        $result = IndexingService::submitToIndexNow($urls);

        $this->table(
            ['Endpoint', 'Status', 'Success'],
            collect($result['endpoints'])->map(function ($ep, $name) {
                return [
                    'Endpoint' => $name,
                    'Status' => $ep['status'] ?? ($ep['error'] ?? 'N/A'),
                    'Success' => (!empty($ep['success'])) ? 'YES' : 'NO',
                ];
            })->toArray()
        );

        $this->info('Pinging Google and Bing sitemaps...');
        $pingResults = IndexingService::pingSitemaps();
        $this->info('Ping results: ' . json_encode($pingResults));

        $this->info('Fast indexing submission completed successfully!');
        return 0;
    }
}
