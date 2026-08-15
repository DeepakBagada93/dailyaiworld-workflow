<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\MarketIndex;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $marketIndices = MarketIndex::all();

        // 1. Hero Featured Story (Primary text-hero)
        // A manually pinned hero (is_hero) is honored only while fresh (last 24h);
        // otherwise the hero always advances to the latest published dispatch so the
        // hero never goes stale behind a pinned story.
        $heroArticle = Article::with(['category', 'author'])
            ->published()
            ->where('is_hero', true)
            ->where('published_at', '>=', now()->subHours(24))
            ->first() ?? Article::with(['category', 'author'])->published()->latest('published_at')->first();

        // 2. Latest News (Fast chronological dispatches feed)
        $latestNews = Article::with(['category', 'author'])
            ->published()
            ->where('id', '!=', $heroArticle?->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        // 3. Trending Stories (Numeric ranking list: 01, 02, 03...)
        $trendingArticles = Article::with(['category', 'author'])
            ->trending()
            ->take(5)
            ->get();

        // 4. Editor's Picks
        $editorsPicks = Article::with(['category', 'author'])
            ->published()
            ->where('is_featured', true)
            ->where('id', '!=', $heroArticle?->id)
            ->take(4)
            ->get();

        // 5. Categorized Primary Content Desks (AI Workflows, MCP Directory, Realtime AI News)
        $workflowArticles = Article::with(['category', 'author'])
            ->published()
            ->where('category_id', 1)
            ->latest('published_at')
            ->take(4)
            ->get();

        $mcpArticles = Article::with(['category', 'author'])
            ->published()
            ->where('category_id', 5)
            ->latest('published_at')
            ->take(4)
            ->get();

        // 5b. Latest AI News & Model Launches (homepage breaking-signal desk)
        // Pull the freshest news-relevant content across the news desks (Agentic AI,
        // Coding, LLMs, AI News) so the section always advances with new dispatches,
        // with a fallback to any latest published article when a desk is quiet.
        $realtimeNewsArticles = Article::with(['category', 'author'])
            ->published()
            ->whereIn('category_id', [2, 3, 10, 11])
            ->latest('published_at')
            ->take(4)
            ->get();

        if ($realtimeNewsArticles->count() < 4) {
            $fallbackNews = Article::with(['category', 'author'])
                ->published()
                ->whereNotIn('id', $realtimeNewsArticles->pluck('id'))
                ->latest('published_at')
                ->take(4 - $realtimeNewsArticles->count())
                ->get();
            $realtimeNewsArticles = $realtimeNewsArticles->merge($fallbackNews);
        }

        // 6. Popular Stories (Highest view count)
        $popularArticles = Article::with(['category', 'author'])
            ->published()
            ->orderBy('view_count', 'desc')
            ->take(4)
            ->get();

        // 7. Latest Articles Feed with Pagination & Fragment Anchor (#archive-section)
        $latestArticles = Article::with(['category', 'author'])
            ->published()
            ->latest('published_at')
            ->paginate(9)
            ->fragment('archive-section');

        return view('home', compact(
            'marketIndices',
            'heroArticle',
            'latestNews',
            'trendingArticles',
            'editorsPicks',
            'workflowArticles',
            'mcpArticles',
            'realtimeNewsArticles',
            'popularArticles',
            'latestArticles'
        ));
    }
}
