<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class McpDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $mcpCategory = Category::where('slug', 'ai-tools')->orWhere('slug', 'mcp-directory')->first();
        
        $mcpArticles = Article::with(['author', 'category'])
            ->published()
            ->where(function($query) {
                $query->where('title', 'like', '%MCP%')
                      ->orWhere('title', 'like', '%Model Context Protocol%')
                      ->orWhere('content', 'like', '%Model Context Protocol%')
                      ->orWhere('content', 'like', '%MCP%');
            })
            ->latest('published_at')
            ->paginate(12);

        if ($mcpArticles->total() === 0) {
            $mcpArticles = Article::with(['author', 'category'])
                ->published()
                ->latest('published_at')
                ->paginate(12);
        }

        return view('mcp.index', compact('mcpArticles', 'mcpCategory'));
    }
}
