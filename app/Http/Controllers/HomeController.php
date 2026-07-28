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
        $heroArticle = Article::with(['category', 'author'])
            ->published()
            ->where('is_hero', true)
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

        // 5. Categorized Topic Desks (Coding, AI Tools, Business, Research, Open Source)
        $codingCategory = Category::where('slug', 'coding-architectures')->first();
        $codingArticles = $codingCategory ? Article::with(['category', 'author'])->published()->where('category_id', $codingCategory->id)->latest('published_at')->take(4)->get() : collect();

        $toolsCategory = Category::where('slug', 'ai-tools')->first();
        $aiToolsArticles = $toolsCategory ? Article::with(['category', 'author'])->published()->where('category_id', $toolsCategory->id)->latest('published_at')->take(4)->get() : collect();

        $businessCategory = Category::where('slug', 'business-saas')->first();
        $businessArticles = $businessCategory ? Article::with(['category', 'author'])->published()->where('category_id', $businessCategory->id)->latest('published_at')->take(4)->get() : collect();

        $researchCategory = Category::where('slug', 'research-papers')->first();
        $researchArticles = $researchCategory ? Article::with(['category', 'author'])->published()->where('category_id', $researchCategory->id)->latest('published_at')->take(4)->get() : collect();

        $openSourceCategory = Category::where('slug', 'open-source')->first();
        $openSourceArticles = $openSourceCategory ? Article::with(['category', 'author'])->published()->where('category_id', $openSourceCategory->id)->latest('published_at')->take(4)->get() : collect();

        // 6. Popular Stories (Highest view count)
        $popularArticles = Article::with(['category', 'author'])
            ->published()
            ->orderBy('view_count', 'desc')
            ->take(4)
            ->get();

        // 7. Latest Articles Feed with Pagination
        $latestArticles = Article::with(['category', 'author'])
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('home', compact(
            'marketIndices',
            'heroArticle',
            'latestNews',
            'trendingArticles',
            'editorsPicks',
            'codingArticles',
            'aiToolsArticles',
            'businessArticles',
            'researchArticles',
            'openSourceArticles',
            'popularArticles',
            'latestArticles'
        ));
    }
}
