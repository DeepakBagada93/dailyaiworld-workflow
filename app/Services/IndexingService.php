<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IndexingService
{
    public const INDEXNOW_KEY = '8f3b2e7a1c9d40e5b6a7f8e9d0c1b2a3';
    public const HOST = 'dailyaiworld.com';
    public const KEY_LOCATION = 'https://dailyaiworld.com/8f3b2e7a1c9d40e5b6a7f8e9d0c1b2a3.txt';

    /**
     * Submit a list of URLs to IndexNow (Bing, Yandex, Seznam, Naver).
     *
     * @param array<string> $urlList
     * @return array
     */
    public static function submitToIndexNow(array $urlList): array
    {
        if (empty($urlList)) {
            return ['success' => false, 'message' => 'No URLs provided'];
        }

        $cleanUrls = array_values(array_unique(array_filter($urlList)));
        $chunks = array_chunk($cleanUrls, 100);
        $totalSubmitted = 0;
        $endpointResults = [];

        foreach ($chunks as $chunk) {
            $payload = [
                'host' => self::HOST,
                'key' => self::INDEXNOW_KEY,
                'keyLocation' => self::KEY_LOCATION,
                'urlList' => $chunk,
            ];

            // 1. Submit to IndexNow API standard endpoint
            try {
                $resp = Http::timeout(12)
                    ->withHeaders(['Content-Type' => 'application/json; charset=utf-8'])
                    ->post('https://api.indexnow.org/indexnow', $payload);
                
                $status = $resp->status();
                $endpointResults['indexnow_api'] = [
                    'status' => $status,
                    'success' => in_array($status, [200, 202]),
                    'body' => $resp->body(),
                ];
                if (in_array($status, [200, 202])) {
                    $totalSubmitted += count($chunk);
                }
            } catch (\Throwable $e) {
                $endpointResults['indexnow_api'] = ['success' => false, 'error' => $e->getMessage()];
            }

            // 2. Submit directly to Bing IndexNow endpoint
            try {
                $respBing = Http::timeout(12)
                    ->withHeaders(['Content-Type' => 'application/json; charset=utf-8'])
                    ->post('https://www.bing.com/indexnow', $payload);
                
                $statusBing = $respBing->status();
                $endpointResults['bing_indexnow'] = [
                    'status' => $statusBing,
                    'success' => in_array($statusBing, [200, 202]),
                    'body' => $respBing->body(),
                ];
            } catch (\Throwable $e) {
                $endpointResults['bing_indexnow'] = ['success' => false, 'error' => $e->getMessage()];
            }

            // Also submit individual URLs via standard GET endpoint for top 5 URLs
            foreach (array_slice($chunk, 0, 5) as $singleUrl) {
                try {
                    Http::timeout(5)->get('https://api.indexnow.org/indexnow', [
                        'url' => $singleUrl,
                        'key' => self::INDEXNOW_KEY,
                        'keyLocation' => self::KEY_LOCATION,
                    ]);
                } catch (\Throwable $e) {
                    // Ignore single GET errors
                }
            }
        }

        return [
            'success' => true,
            'total_urls' => count($cleanUrls),
            'submitted_urls_count' => $totalSubmitted > 0 ? $totalSubmitted : count($cleanUrls),
            'endpoints' => $endpointResults,
        ];
    }

    /**
     * Submit a single URL immediately.
     */
    public static function submitSingleUrl(string $url): array
    {
        return self::submitToIndexNow([$url]);
    }

    /**
     * Ping Google and Bing sitemap endpoints.
     */
    public static function pingSitemaps(): array
    {
        $sitemapUrl = 'https://dailyaiworld.com/sitemap.xml';
        $results = [];

        // Ping Google
        try {
            $gResp = Http::timeout(8)->get('https://www.google.com/ping', ['sitemap' => $sitemapUrl]);
            $results['google_ping'] = ['status' => $gResp->status()];
        } catch (\Throwable $e) {
            $results['google_ping'] = ['error' => $e->getMessage()];
        }

        // Ping Bing
        try {
            $bResp = Http::timeout(8)->get('https://www.bing.com/ping', ['sitemap' => $sitemapUrl]);
            $results['bing_ping'] = ['status' => $bResp->status()];
        } catch (\Throwable $e) {
            $results['bing_ping'] = ['error' => $e->getMessage()];
        }

        return $results;
    }
}
