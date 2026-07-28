<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->get();
        return CategoryResource::collection($categories);
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return new CategoryResource($category);
    }
}
