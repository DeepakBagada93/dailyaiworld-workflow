<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class NewsDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $latestNews = Article::with(['author', 'category'])
            ->published()
            ->latest('published_at')
            ->paginate(15);

        return view('news.index', compact('latestNews'));
    }
}
