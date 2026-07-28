<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class EditorialDashboardController extends Controller
{
    public function index()
    {
        $totalArticles = Article::count();
        $publishedArticles = Article::published()->count();
        $totalSubscribers = NewsletterSubscriber::count();
        $totalViews = Article::sum('view_count');

        $recentArticles = Article::with('category', 'author')
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::withCount('articles')->get();
        $authors = Author::withCount('articles')->get();

        return view('dashboard.editorial', compact(
            'totalArticles',
            'publishedArticles',
            'totalSubscribers',
            'totalViews',
            'recentArticles',
            'categories',
            'authors'
        ));
    }
}
