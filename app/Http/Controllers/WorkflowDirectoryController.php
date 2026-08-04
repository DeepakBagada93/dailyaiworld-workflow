<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class WorkflowDirectoryController extends Controller
{
    public function index(Request $request)
    {
        $workflowArticles = Article::with(['author', 'category'])
            ->published()
            ->where(function($query) {
                $query->where('title', 'like', '%Workflow%')
                      ->orWhere('title', 'like', '%Pipeline%')
                      ->orWhere('title', 'like', '%Automation%')
                      ->orWhere('content', 'like', '%Workflow%');
            })
            ->latest('published_at')
            ->paginate(12);

        if ($workflowArticles->total() === 0) {
            $workflowArticles = Article::with(['author', 'category'])
                ->published()
                ->latest('published_at')
                ->paginate(12);
        }

        return view('workflows.index', compact('workflowArticles'));
    }
}
