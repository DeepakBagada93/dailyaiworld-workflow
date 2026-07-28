<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->articles()
            ->with(['author', 'category'])
            ->published()
            ->latest('published_at')
            ->paginate(12);

        $featuredArticle = $category->articles()
            ->with(['author', 'category'])
            ->published()
            ->where('is_featured', true)
            ->first();

        return view('categories.show', compact('category', 'articles', 'featuredArticle'));
    }
}
