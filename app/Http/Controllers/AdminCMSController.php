<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Comment;
use App\Models\MarketIndex;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class AdminCMSController extends Controller
{
    public function dashboard()
    {
        $publishedCount = Article::published()->count();
        $draftsCount = Article::where('status', 'draft')->count();
        $totalViews = Article::sum('view_count');
        $subscribersCount = NewsletterSubscriber::count();
        
        $recentArticles = Article::with(['category', 'author'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::withCount('articles')->get();

        return view('cms.dashboard', compact(
            'publishedCount',
            'draftsCount',
            'totalViews',
            'subscribersCount',
            'recentArticles',
            'categories'
        ));
    }

    public function posts(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Article::with(['category', 'author']);

        if ($status === 'published') {
            $query->where('status', 'published');
        } elseif ($status === 'draft') {
            $query->where('status', 'draft');
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $posts = $query->latest()->paginate(15);

        return view('cms.posts', compact('posts', 'status'));
    }

    public function createPost()
    {
        $categories = Category::all();
        $authors = Author::all();

        return view('cms.post-editor', compact('categories', 'authors'));
    }

    public function drafts()
    {
        $drafts = Article::with(['category', 'author'])
            ->where('status', 'draft')
            ->latest()
            ->paginate(15);

        return view('cms.drafts', compact('drafts'));
    }

    public function scheduled()
    {
        $scheduled = Article::with(['category', 'author'])
            ->where('status', 'published')
            ->where('published_at', '>', now())
            ->latest()
            ->paginate(15);

        return view('cms.scheduled', compact('scheduled'));
    }

    public function categories()
    {
        $categories = Category::withCount('articles')->get();
        return view('cms.categories', compact('categories'));
    }

    public function authors()
    {
        $authors = Author::withCount('articles')->get();
        return view('cms.authors', compact('authors'));
    }

    public function media()
    {
        $articlesWithImages = Article::whereNotNull('featured_image')->get();
        return view('cms.media', compact('articlesWithImages'));
    }

    public function seo()
    {
        $articles = Article::with('category')->latest()->take(10)->get();
        return view('cms.seo', compact('articles'));
    }

    public function analytics()
    {
        $topArticles = Article::orderBy('view_count', 'desc')->take(10)->get();
        $indices = MarketIndex::all();
        return view('cms.analytics', compact('topArticles', 'indices'));
    }

    public function aiStudio()
    {
        return view('cms.ai-studio');
    }

    public function researchQueue()
    {
        return view('cms.research-queue');
    }

    public function internalLinking()
    {
        $articles = Article::select('id', 'title', 'slug', 'category_id')->with('category')->get();
        return view('cms.internal-linking', compact('articles'));
    }

    public function deployment()
    {
        return view('cms.deployment');
    }

    public function settings()
    {
        return view('cms.settings');
    }
}
