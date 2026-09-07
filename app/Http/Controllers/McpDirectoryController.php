<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class McpDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $mcpCategory = Category::where('slug', 'ai-tools')->orWhere('id', 5)->first();
        
        $mcpArticles = Article::with(['author', 'category'])
            ->published()
            ->where('category_id', 5)
            ->latest('published_at')
            ->paginate(12);

        return view('mcp.index', compact('mcpArticles', 'mcpCategory'));
    }
}
