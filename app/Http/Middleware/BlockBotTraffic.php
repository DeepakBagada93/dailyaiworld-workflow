<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockBotTraffic
{
    /**
     * Known search engine & AI assistant bots that MUST always be allowed.
     */
    protected array $allowedBots = [
        'googlebot',
        'mediapartners-google',
        'feedfetcher-google',
        'bingbot',
        'gptbot',
        'chatgpt-user',
        'perplexitybot',
        'claudebot',
        'claude-web',
        'applebot',
        'amazonbot',
        'cohere-ai',
        'twitterbot',
        'facebookexternalhit',
        'linkedinbot',
        'slackbot',
        'telegrambot',
        'whatsapp',
    ];

    /**
     * Known referral spam domains to block immediately.
     */
    protected array $blockedReferrers = [
        'aocr.org',
        '114.114.114.114',
        'semalt.com',
        'buttons-for-website.com',
        'traffic2money.com',
        'darodar.com',
        'ilovevitaly.com',
        'econom.co',
        'best-seo-offer.com',
        'keywords-monitoring-your-success.com',
        'rank-checker.online',
        'scanner.top',
        'site-auditor.online',
    ];

    /**
     * Aggressive scrapers, automated exploit scanners, and non-compliant bots to drop.
     */
    protected array $blockedUserAgents = [
        'bytespider',
        'petalsearch',
        'petalbot',
        'zoominfobot',
        'ahrefsbot',
        'semrushbot',
        'dotbot',
        'megaindex',
        'mj12bot',
        'serpstatbot',
        'blexbot',
        'coccocbot',
        'sqlmap',
        'nikto',
        'zgrab',
        'masscan',
        'dirbuster',
        'acunetix',
        'havij',
        'nessus',
        'morfeus',
        'scrapy',
    ];

    /**
     * Automated CLI scripting libraries (blocked from HTML routes, allowed for API / feeds).
     */
    protected array $blockedLibraries = [
        'python-requests',
        'aiohttp',
        'httpx',
        'go-http-client',
        'node-fetch',
        'urllib',
        'libwww-perl',
        'java/',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = strtolower($request->header('User-Agent', ''));
        $referrer = strtolower($request->header('Referer', ''));

        // 1. Check if it's an explicitly allowed legitimate crawler/engine
        foreach ($this->allowedBots as $bot) {
            if (str_contains($userAgent, $bot)) {
                return $next($request);
            }
        }

        // 2. Block Referral Spam (e.g., aocr.org, 114.114.114.114)
        if (!empty($referrer)) {
            foreach ($this->blockedReferrers as $spam) {
                if (str_contains($referrer, $spam)) {
                    return response('Access Denied: Spam Referrer Blocked.', 403);
                }
            }
        }

        // 3. Block Aggressive Scrapers & Exploit Scanners
        foreach ($this->blockedUserAgents as $blocked) {
            if (str_contains($userAgent, $blocked)) {
                return response('Access Denied: Automated Scraping Forbidden.', 403);
            }
        }

        // 4. Block generic script user-agents on public web HTML routes (skip sitemaps/rss/api)
        $path = $request->path();
        $isApiOrFeed = str_starts_with($path, 'api/') || 
                       str_ends_with($path, '.xml') || 
                       str_ends_with($path, '.txt') ||
                       str_ends_with($path, '.json');

        if (!$isApiOrFeed) {
            foreach ($this->blockedLibraries as $lib) {
                if (str_contains($userAgent, $lib)) {
                    return response('Access Denied: Automated Scraping Forbidden.', 403);
                }
            }
        }

        return $next($request);
    }
}
