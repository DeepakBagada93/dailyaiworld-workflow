<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class WorkflowDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $workflowCategory = Category::where('slug', 'ai-workflows')->orWhere('id', 1)->first();

        $workflowArticles = Article::with(['author', 'category'])
            ->published()
            ->where('category_id', 1)
            ->latest('published_at')
            ->paginate(12);

        return view('workflows.index', compact('workflowArticles', 'workflowCategory'));
    }
}
