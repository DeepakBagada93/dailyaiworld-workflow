<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('q', ''));
        $category = $request->get('category');

        $articles = Article::with(['category', 'author'])
            ->published();

        if ($query !== '') {
            $articles->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('deck', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            });
        }

        if ($category) {
            $articles->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $results = $articles->latest('published_at')->paginate(12);

        if ($request->wantsJson()) {
            return response()->json([
                'results' => $results->items(),
                'total' => $results->total(),
            ]);
        }

        return view('search.index', compact('results', 'query'));
    }
}
