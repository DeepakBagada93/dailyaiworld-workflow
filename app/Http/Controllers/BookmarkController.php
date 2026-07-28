<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check()) {
            $bookmarks = Bookmark::where('user_id', auth()->id())
                ->with('article.category', 'article.author')
                ->latest()
                ->get();
            $articles = $bookmarks->pluck('article')->filter();
        } else {
            $ids = session()->get('bookmarks', []);
            $articles = Article::with('category', 'author')
                ->whereIn('id', $ids)
                ->get();
        }

        return view('bookmarks.index', compact('articles'));
    }

    public function toggle(Request $request, Article $article)
    {
        if (auth()->check()) {
            $existing = Bookmark::where('user_id', auth()->id())
                ->where('article_id', $article->id)
                ->first();

            if ($existing) {
                $existing->delete();
                $status = 'removed';
            } else {
                Bookmark::create([
                    'user_id' => auth()->id(),
                    'article_id' => $article->id,
                ]);
                $status = 'added';
            }
        } else {
            $bookmarks = session()->get('bookmarks', []);
            if (in_array($article->id, $bookmarks)) {
                $bookmarks = array_values(array_diff($bookmarks, [$article->id]));
                $status = 'removed';
            } else {
                $bookmarks[] = $article->id;
                $status = 'added';
            }
            session()->put('bookmarks', $bookmarks);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => $status,
                'count' => auth()->check() 
                    ? Bookmark::where('user_id', auth()->id())->count()
                    : count(session()->get('bookmarks', [])),
            ]);
        }

        return back()->with('success', $status === 'added' ? 'Article saved to reading list.' : 'Article removed from reading list.');
    }
}
