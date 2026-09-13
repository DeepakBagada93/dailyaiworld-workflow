<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleIndexingService
{
    public const INDEXING_ENDPOINT = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
    public const STATUS_ENDPOINT   = 'https://indexing.googleapis.com/v3/urlNotifications/metadata';
    public const TOKEN_ENDPOINT    = 'https://oauth2.googleapis.com/token';
    public const OAUTH_SCOPE       = 'https://www.googleapis.com/auth/indexing';

    protected static ?string $cachedToken = null;
    protected static int $tokenExpiry = 0;

    /**
     * Resolve credentials JSON path.
     */
    public static function getCredentialsPath(): ?string
    {
        $envPath = env('GOOGLE_APPLICATION_CREDENTIALS');
        if (!empty($envPath)) {
            $path = str_starts_with($envPath, '/') ? $envPath : base_path($envPath);
            if (file_exists($path)) {
                return $path;
            }
        }

        // Fallbacks
        $fallbacks = [
            base_path('storage/credentials/google-indexing-service-account.json'),
            base_path('storage/credentials/service-account.json'),
        ];

        foreach ($fallbacks as $candidate) {
            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    /**
     * Get or refresh Google OAuth2 Access Token via JWT RS256 signature.
     */
    public static function getAccessToken(): string
    {
        if (self::$cachedToken && time() < (self::$tokenExpiry - 60)) {
            return self::$cachedToken;
        }

        $credPath = self::getCredentialsPath();
        if (!$credPath || !file_exists($credPath)) {
            throw new \RuntimeException("Google credentials file not found. Set GOOGLE_APPLICATION_CREDENTIALS in .env");
        }

        $creds = json_decode(file_get_contents($credPath), true);
        if (!$creds || empty($creds['client_email']) || empty($creds['private_key'])) {
            throw new \RuntimeException("Invalid service account credentials in $credPath");
        }

        $now = time();
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $claims = [
            'iss'   => $creds['client_email'],
            'scope' => self::OAUTH_SCOPE,
            'aud'   => self::TOKEN_ENDPOINT,
            'exp'   => $now + 3600,
            'iat'   => $now,
        ];

        $b64Header = self::base64UrlEncode(json_encode($header));
        $b64Claims = self::base64UrlEncode(json_encode($claims));
        $signatureInput = $b64Header . '.' . $b64Claims;

        $privateKey = openssl_pkey_get_private($creds['private_key']);
        if (!$privateKey) {
            throw new \RuntimeException("Failed to load private key from Google credentials");
        }

        $signature = '';
        if (!openssl_sign($signatureInput, $signature, $privateKey, OPENSSL_ALGO_SHA256)) {
            throw new \RuntimeException("Failed to sign JWT with RSA private key");
        }

        $jwt = $signatureInput . '.' . self::base64UrlEncode($signature);

        $response = Http::asForm()->timeout(15)->post(self::TOKEN_ENDPOINT, [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion'  => $jwt,
        ]);

        if (!$response->successful()) {
            throw new \RuntimeException("OAuth2 token exchange failed: " . $response->body());
        }

        $tokenData = $response->json();
        if (empty($tokenData['access_token'])) {
            throw new \RuntimeException("No access_token returned by Google OAuth: " . json_encode($tokenData));
        }

        self::$cachedToken = $tokenData['access_token'];
        self::$tokenExpiry = $now + ($tokenData['expires_in'] ?? 3600);

        return self::$cachedToken;
    }

    /**
     * Submit a single URL to Google Indexing API.
     *
     * @param string $url The canonical URL to publish
     * @param string $type 'URL_UPDATED' or 'URL_DELETED'
     * @return array Result array with status, response body, and friendly error if any
     */
    public static function publishUrl(string $url, string $type = 'URL_UPDATED'): array
    {
        try {
            $token = self::getAccessToken();
            $response = Http::withToken($token)
                ->timeout(12)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post(self::INDEXING_ENDPOINT, [
                    'url'  => $url,
                    'type' => $type,
                ]);

            $status = $response->status();
            $body = $response->json() ?? ['raw' => $response->body()];

            $success = ($status === 200);

            $result = [
                'url'        => $url,
                'status'     => $status,
                'success'    => $success,
                'type'       => $type,
                'timestamp'  => date('c'),
                'response'   => $body,
            ];

            if ($success) {
                self::recordSubmission($url, $type, $status);
            } else {
                $result['friendly_error'] = self::formatFriendlyError($status, $body);
            }

            return $result;

        } catch (\Throwable $e) {
            return [
                'url'            => $url,
                'status'         => 0,
                'success'        => false,
                'type'           => $type,
                'timestamp'      => date('c'),
                'error'          => $e->getMessage(),
                'friendly_error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check metadata/status of a URL in Google Indexing API.
     */
    public static function getUrlStatus(string $url): array
    {
        try {
            $token = self::getAccessToken();
            $response = Http::withToken($token)
                ->timeout(10)
                ->get(self::STATUS_ENDPOINT, ['url' => $url]);

            return [
                'url'     => $url,
                'status'  => $response->status(),
                'success' => $response->successful(),
                'data'    => $response->json(),
            ];
        } catch (\Throwable $e) {
            return [
                'url'     => $url,
                'status'  => 0,
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Submit a batch of URLs sequentially with pacing.
     *
     * @param array<string> $urls
     * @param string $type
     * @param int $delayMs Milliseconds to sleep between requests
     * @param callable|null $progressCallback Optional callback fn($index, $total, $result)
     * @return array
     */
    public static function publishBatch(array $urls, string $type = 'URL_UPDATED', int $delayMs = 200, ?callable $progressCallback = null): array
    {
        $urls = array_values(array_unique(array_filter($urls)));
        $total = count($urls);
        $results = [];
        $successful = 0;
        $failed = 0;

        foreach ($urls as $index => $url) {
            $result = self::publishUrl($url, $type);
            $results[] = $result;

            if ($result['success']) {
                $successful++;
            } else {
                $failed++;
            }

            if ($progressCallback) {
                $progressCallback($index + 1, $total, $result);
            }

            // If API disabled or permission denied, stop early to avoid hammering
            if (isset($result['status']) && in_array($result['status'], [401, 403])) {
                $errorReason = $result['response']['error']['status'] ?? '';
                if ($errorReason === 'PERMISSION_DENIED') {
                    // Check if disabled
                    $reason = $result['response']['error']['details'][0]['reason'] ?? '';
                    if ($reason === 'SERVICE_DISABLED') {
                        break;
                    }
                }
            }

            if ($delayMs > 0 && $index < ($total - 1)) {
                usleep($delayMs * 1000);
            }
        }

        return [
            'total'      => $total,
            'successful' => $successful,
            'failed'     => $failed,
            'results'    => $results,
        ];
    }

    /**
     * Formats Google API error responses into actionable guidance.
     */
    protected static function formatFriendlyError(int $status, array $body): string
    {
        $message = $body['error']['message'] ?? 'Unknown error';
        $reason = $body['error']['details'][0]['reason'] ?? '';

        if ($reason === 'SERVICE_DISABLED' || str_contains($message, 'Web Search Indexing API has not been used') || str_contains($message, 'is disabled')) {
            return "Web Search Indexing API is NOT enabled in Google Cloud Console. Enable it here: https://console.developers.google.com/apis/api/indexing.googleapis.com/overview?project=" . (env('GOOGLE_PROJECT_ID') ?: '287612459497');
        }

        if ($status === 403 && str_contains($message, 'Permission denied')) {
            return "Permission Denied. The service account (" . env('GA_SERVICE_ACCOUNT_EMAIL') . ") must be added as an OWNER in Google Search Console for property https://dailyaiworld.com/";
        }

        if ($status === 429 || str_contains($message, 'Quota exceeded')) {
            return "Google Indexing API Daily Quota Exceeded (Max 200 URLs per day). Try again tomorrow or request higher quota.";
        }

        return "HTTP $status: $message";
    }

    /**
     * Record submission in history JSON file.
     */
    protected static function recordSubmission(string $url, string $type, int $status): void
    {
        try {
            $historyPath = storage_path('app/google_indexing_history.json');
            $dir = dirname($historyPath);
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            $history = [];
            if (File::exists($historyPath)) {
                $history = json_decode(File::get($historyPath), true) ?? [];
            }

            $today = date('Y-m-d');
            $history[$url] = [
                'type'         => $type,
                'status'       => $status,
                'submitted_at' => date('c'),
                'date'         => $today,
            ];

            File::put($historyPath, json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            Log::warning("Failed to record Google indexing history: " . $e->getMessage());
        }
    }

    /**
     * Get list of URLs already submitted today.
     */
    public static function getSubmittedTodayCount(): int
    {
        try {
            $historyPath = storage_path('app/google_indexing_history.json');
            if (!File::exists($historyPath)) {
                return 0;
            }
            $history = json_decode(File::get($historyPath), true) ?? [];
            $today = date('Y-m-d');
            $count = 0;
            foreach ($history as $item) {
                if (($item['date'] ?? '') === $today && ($item['status'] ?? 0) === 200) {
                    $count++;
                }
            }
            return $count;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Check if a URL has already been submitted.
     */
    public static function isAlreadySubmitted(string $url): bool
    {
        try {
            $historyPath = storage_path('app/google_indexing_history.json');
            if (!File::exists($historyPath)) {
                return false;
            }
            $history = json_decode(File::get($historyPath), true) ?? [];
            return isset($history[$url]) && ($history[$url]['status'] ?? 0) === 200;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected static function base64UrlEncode(string $data): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }
}
