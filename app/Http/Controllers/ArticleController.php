<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Comment;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $article = Article::with(['category', 'author', 'comments', 'sponsorships.sponsor', 'affiliateLinks'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $article->increment('view_count');

        // Check if user has active subscription
        $isSubscribed = auth()->check() ? auth()->user()->isSubscribed() : false;

        // Previous and Next Article Navigation
        $prevArticle = Article::published()
            ->where('published_at', '<', $article->published_at)
            ->latest('published_at')
            ->first();

        $nextArticle = Article::published()
            ->where('published_at', '>', $article->published_at)
            ->oldest('published_at')
            ->first();

        $relatedArticles = Article::with(['category', 'author'])
            ->published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $extra = Article::with(['category', 'author'])
                ->published()
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->take(3 - $relatedArticles->count())
                ->get();
            $relatedArticles = $relatedArticles->merge($extra);
        }

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = Bookmark::where('user_id', auth()->id())
                ->where('article_id', $article->id)
                ->exists();
        } else {
            $bookmarkedIds = session()->get('bookmarks', []);
            $isBookmarked = in_array($article->id, $bookmarkedIds);
        }

        return view('articles.show', compact(
            'article',
            'relatedArticles',
            'prevArticle',
            'nextArticle',
            'isBookmarked',
            'isSubscribed'
        ));
    }

    public function storeComment(Request $request, Article $article)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'content' => 'required|string|max:2000',
        ]);

        $comment = Comment::create([
            'article_id' => $article->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'content' => $validated['content'],
            'is_approved' => true,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'name' => $comment->name,
                    'content' => $comment->content,
                    'date' => $comment->formatted_date,
                ],
            ]);
        }

        return back()->with('success', 'Your commentary has been published to the thread.');
    }
}
