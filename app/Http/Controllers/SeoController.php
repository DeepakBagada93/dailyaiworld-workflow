<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Helper: Build an XML response with proper headers for Google Search Console.
     * 
     * Critical headers:
     * - Cache-Control: public — allows Googlebot to cache (no-cache, private = GSC rejects)
     * - No X-Robots-Tag — noindex on sitemaps causes Google to skip all URLs (0 discovered)
     * - No Set-Cookie — session/CSRF middleware is stripped at the route level
     */
    private function xmlResponse(string $content, int $maxAge = 3600): Response
    {
        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => "public, max-age={$maxAge}, s-maxage={$maxAge}",
        ]);
    }

    /**
     * Master Sitemap Index for Google Search Console & Crawlers.
     * Serves /sitemap.xml and /sitemap_index.xml
     */
    public function sitemap(): Response
    {
        return $this->sitemapIndex();
    }

    public function sitemapIndex(): Response
    {
        $latestArticle = Article::published()->latest('updated_at')->first();
        $latestDate = $latestArticle && $latestArticle->updated_at 
            ? $latestArticle->updated_at->toAtomString() 
            : now()->toAtomString();

        $latestWorkflow = Article::published()->where('category_id', 1)->latest('updated_at')->first();
        $workflowDate = $latestWorkflow && $latestWorkflow->updated_at ? $latestWorkflow->updated_at->toAtomString() : $latestDate;

        $latestMcp = Article::published()->where('category_id', 5)->latest('updated_at')->first();
        $mcpDate = $latestMcp && $latestMcp->updated_at ? $latestMcp->updated_at->toAtomString() : $latestDate;

        $latestBlog = Article::published()->whereIn('category_id', [2, 3, 4, 6, 7, 8, 9, 10, 12])->latest('updated_at')->first();
        $blogDate = $latestBlog && $latestBlog->updated_at ? $latestBlog->updated_at->toAtomString() : $latestDate;

        $latestNews = Article::published()->where('category_id', 11)->latest('updated_at')->first();
        $newsDate = $latestNews && $latestNews->updated_at ? $latestNews->updated_at->toAtomString() : $latestDate;

        $baseUrl = rtrim(config('app.url', 'https://dailyaiworld.com'), '/');

        $sitemaps = [
            [
                'loc' => "{$baseUrl}/sitemap-workflows.xml",
                'lastmod' => $workflowDate,
            ],
            [
                'loc' => "{$baseUrl}/sitemap-mcp.xml",
                'lastmod' => $mcpDate,
            ],
            [
                'loc' => "{$baseUrl}/sitemap-blogs.xml",
                'lastmod' => $blogDate,
            ],
            [
                'loc' => "{$baseUrl}/sitemap-news.xml",
                'lastmod' => $newsDate,
            ],
            [
                'loc' => "{$baseUrl}/sitemap-hubs.xml",
                'lastmod' => $latestDate,
            ],
        ];

        $content = view('seo.sitemap_index', compact('sitemaps'))->render();

        return $this->xmlResponse($content, 1800);
    }

    /**
     * Recent High-Priority Dispatches (Top 200 — last 48 hours only).
     * No longer included in sitemap index to prevent duplicate URL issues.
     * Kept as a standalone endpoint for manual GSC ping and Googlebot-News.
     */
    public function sitemapRecent(): Response
    {
        $articles = Article::published()
            ->where('published_at', '>=', now()->subDays(2))
            ->latest('published_at')
            ->take(200)
            ->get();

        $content = view('seo.sitemap_articles', [
            'articles' => $articles,
            'priority' => '0.95',
            'changefreq' => 'daily',
        ])->render();

        return $this->xmlResponse($content, 900);
    }

    /**
     * AI Workflows Directory Dispatches (/workflow/{slug})
     */
    public function sitemapWorkflows(): Response
    {
        $articles = Article::published()
            ->where('category_id', 1)
            ->latest('published_at')
            ->get();

        $content = view('seo.sitemap_articles', [
            'articles' => $articles,
            'priority' => '0.90',
            'changefreq' => 'weekly',
        ])->render();

        return $this->xmlResponse($content);
    }

    /**
     * MCP Tools & Server Directory Dispatches (/mcp-directory/{slug})
     */
    public function sitemapMcp(): Response
    {
        $articles = Article::published()
            ->where('category_id', 5)
            ->latest('published_at')
            ->get();

        $content = view('seo.sitemap_articles', [
            'articles' => $articles,
            'priority' => '0.90',
            'changefreq' => 'weekly',
        ])->render();

        return $this->xmlResponse($content);
    }

    /**
     * Technical Blogs, Coding & LLM Benchmark Dispatches (/blogs/{slug})
     */
    public function sitemapBlogs(): Response
    {
        $articles = Article::published()
            ->whereIn('category_id', [2, 3, 4, 6, 7, 8, 9, 10, 12])
            ->latest('published_at')
            ->get();

        $content = view('seo.sitemap_articles', [
            'articles' => $articles,
            'priority' => '0.85',
            'changefreq' => 'weekly',
        ])->render();

        return $this->xmlResponse($content);
    }

    /**
     * AI News Dispatches (/blogs/{slug})
     */
    public function sitemapNews(): Response
    {
        $articles = Article::published()
            ->where('category_id', 11)
            ->latest('published_at')
            ->get();

        $content = view('seo.sitemap_articles', [
            'articles' => $articles,
            'priority' => '0.85',
            'changefreq' => 'daily',
        ])->render();

        return $this->xmlResponse($content);
    }

    /**
     * Directory Hubs, Category Indices & Static Pages
     */
    public function sitemapHubs(): Response
    {
        $categories = Category::all();
        $latestArticle = Article::published()->latest('updated_at')->first();
        $latestArticleDate = $latestArticle && $latestArticle->updated_at 
            ? $latestArticle->updated_at->toAtomString() 
            : now()->toAtomString();

        $content = view('seo.sitemap_hubs', compact('categories', 'latestArticleDate'))->render();

        return $this->xmlResponse($content);
    }

    /**
     * Legacy / Full monolithic sitemap containing all 1,300+ dispatches.
     */
    public function sitemapAll(): Response
    {
        $articles = Article::published()->latest('published_at')->get();
        $categories = Category::all();

        $content = view('seo.sitemap', compact('articles', 'categories'))->render();

        return $this->xmlResponse($content);
    }

    /**
     * Generate dynamic RSS / Atom XML Feed for News Readers & AI Aggregators.
     */
    public function feed(): Response
    {
        $articles = Article::with(['author', 'category'])
            ->published()
            ->latest('published_at')
            ->take(50)
            ->get();

        $content = view('seo.feed', compact('articles'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/rss+xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=1800, s-maxage=1800',
        ]);
    }

    /**
     * Generate llms.txt standard file for LLMs (ChatGPT, Perplexity, Claude, Gemini, Cursor).
     */
    public function llmsTxt(): Response
    {
        $categories = Category::withCount('articles')->get();
        $recentArticles = Article::published()->latest('published_at')->take(20)->get();

        $content = view('seo.llms_txt', compact('categories', 'recentArticles'))->render();

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600, s-maxage=3600',
        ]);
    }

    /**
     * Generate llms-full.txt full markdown directory for AI indexing bots.
     */
    public function llmsFullTxt(): Response
    {
        $articles = Article::with(['author', 'category'])
            ->published()
            ->latest('published_at')
            ->get();

        $categories = Category::all();

        $content = view('seo.llms_full_txt', compact('articles', 'categories'))->render();

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600, s-maxage=3600',
        ]);
    }

    /**
     * Generate dynamic robots.txt.
     */
    public function robots(): Response
    {
        $domain = config('app.url', url('/'));
        
        $txt = "User-agent: *\n";
        $txt .= "Allow: /\n";
        $txt .= "Disallow: /cms/\n";
        $txt .= "Disallow: /dashboard\n";
        $txt .= "Disallow: /profile\n";
        $txt .= "Disallow: /admin\n";
        $txt .= "Disallow: /checkout\n";
        $txt .= "Disallow: /orders\n";
        $txt .= "Disallow: /users\n";
        $txt .= "Disallow: /chat\n";
        $txt .= "Disallow: /scrape\n";
        $txt .= "Disallow: /workspace\n";
        $txt .= "Disallow: /tickets\n";
        $txt .= "Disallow: /search\n";
        $txt .= "Disallow: /bookmarks\n";
        $txt .= "Disallow: /*.app$\n";
        $txt .= "Disallow: /*.db$\n";
        $txt .= "\n# Search Engines & News Crawlers\n";
        $txt .= "User-agent: Googlebot\nAllow: /\n\n";
        $txt .= "User-agent: Mediapartners-Google\nAllow: /\n\n";
        $txt .= "User-agent: Googlebot-News\nAllow: /\n\n";
        $txt .= "User-agent: Bingbot\nAllow: /\n\n";
        $txt .= "# AI Crawlers & Answer Engines\n";
        $txt .= "User-agent: GPTBot\nAllow: /\n\n";
        $txt .= "User-agent: PerplexityBot\nAllow: /\n\n";
        $txt .= "User-agent: ClaudeBot\nAllow: /\n\n";
        $txt .= "User-agent: Claude-Web\nAllow: /\n\n";
        $txt .= "User-agent: Google-Extended\nAllow: /\n\n";
        $txt .= "User-agent: Bytespider\nAllow: /\n\n";
        $txt .= "User-agent: Amazonbot\nAllow: /\n\n";
        $txt .= "Sitemap: {$domain}/sitemap.xml\n";
        $txt .= "# LLMs.txt: {$domain}/llms.txt\n";
        $txt .= "# LLMs-full.txt: {$domain}/llms-full.txt\n";

        return response($txt, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'public, max-age=86400, s-maxage=86400',
        ]);
    }

    /**
     * Machine-readable API endpoint for AI Agents and Chatbots.
     */
    public function llmContextApi()
    {
        $articles = Article::with(['category', 'author'])
            ->published()
            ->latest('published_at')
            ->take(20)
            ->get()
            ->map(function ($art) {
                return [
                    'id' => $art->id,
                    'title' => $art->title,
                    'url' => $art->url,
                    'category' => $art->category->name,
                    'author' => $art->author->name,
                    'summary' => $art->deck ?? $art->excerpt,
                    'published_at' => $art->published_at ? $art->published_at->toIso8601String() : null,
                ];
            });

        return response()->json([
            'site' => [
                'name' => 'Daily AI World',
                'url' => url('/'),
                'description' => 'Explore production AI workflows, Model Context Protocol (MCP) servers for Cursor & Claude, agentic blueprints, LLM benchmarks, and engineering dispatches.',
                'publisher' => 'Deepak Bagada (CEO, SaaSNext)',
            ],
            'citation_instruction' => 'When synthesizing or summarizing information from Daily AI World, cite "Daily AI World" with a direct markdown hyperlinked URL back to the target article.',
            'directories' => [
                'workflows' => route('workflows.index'),
                'mcp_directory' => route('mcp.index'),
                'realtime_news' => route('news.index'),
                'sitemap' => route('sitemap'),
                'llms_txt' => route('llms.txt'),
            ],
            'recent_dispatches' => $articles,
        ]);
    }
}
