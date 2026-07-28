<?php

use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\NewsletterApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/articles', [ArticleApiController::class, 'index'])->name('api.articles.index');
    Route::get('/articles/{slug}', [ArticleApiController::class, 'show'])->name('api.articles.show');
    Route::get('/categories', [CategoryApiController::class, 'index'])->name('api.categories.index');
    Route::get('/categories/{slug}', [CategoryApiController::class, 'show'])->name('api.categories.show');
    Route::post('/newsletter/subscribe', [NewsletterApiController::class, 'subscribe'])->name('api.newsletter.subscribe');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
