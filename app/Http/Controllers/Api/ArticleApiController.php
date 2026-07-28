<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleApiController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::with(['category', 'author'])
            ->published()
            ->latest('published_at')
            ->paginate(10);

        return ArticleResource::collection($articles);
    }

    public function show(string $slug)
    {
        $article = Article::with(['category', 'author'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $article->increment('view_count');

        return new ArticleResource($article);
    }
}
