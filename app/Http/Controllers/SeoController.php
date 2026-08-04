<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Generate dynamic XML Sitemap for Search Engines (Google, Bing, Yahoo).
     */
    public function sitemap(): Response
    {
        $articles = Article::published()->latest('published_at')->get();
        $categories = Category::all();

        $content = view('seo.sitemap', compact('articles', 'categories'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'X-Robots-Tag' => 'noindex',
        ]);
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
        $txt .= "Disallow: /profile\n\n";
        $txt .= "Sitemap: {$domain}/sitemap.xml\n";
        $txt .= "LLMs-Txt: {$domain}/llms.txt\n";

        return response($txt, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }
}
