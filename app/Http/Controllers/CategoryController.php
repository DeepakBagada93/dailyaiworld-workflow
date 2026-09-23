<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, string $slug)
    {
        // 301 redirect duplicate taxonomy categories to their primary canonical directory hubs
        // (resolves Google Search Console "Duplicate, Google chose different canonical than user")
        if (in_array($slug, ['ai-workflows', 'workflows'])) {
            return redirect()->route('workflows.index', [], 301);
        }
        if (in_array($slug, ['ai-tools', 'mcp-tools', 'mcp'])) {
            return redirect()->route('mcp.index', [], 301);
        }
        if (in_array($slug, ['ai-news', 'news'])) {
            return redirect()->route('news.index', [], 301);
        }

        $category = Category::where('slug', $slug)->firstOrFail();

        $articles = $category->articles()
            ->with(['author', 'category'])
            ->published()
            ->latest('published_at')
            ->paginate(12);

        if ($articles->total() === 0) {
            return redirect()->route('workflows.index', [], 301);
        }

        $featuredArticle = $category->articles()
            ->with(['author', 'category'])
            ->published()
            ->where('is_featured', true)
            ->first();

        return view('categories.show', compact('category', 'articles', 'featuredArticle'));
    }
}
