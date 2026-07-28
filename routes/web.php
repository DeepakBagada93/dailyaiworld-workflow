<?php

use App\Http\Controllers\AdminCMSController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DesignSystemController;
use App\Http\Controllers\EditorialDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Public Editorial Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::post('/article/{article}/comments', [ArticleController::class, 'storeComment'])->name('articles.comments.store');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Reading List / Bookmarks
Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
Route::post('/bookmarks/{article}/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Design System Showcase
Route::get('/design-system', [DesignSystemController::class, 'index'])->name('design-system');

// Editorial Dashboard
Route::get('/editorial-dashboard', [EditorialDashboardController::class, 'index'])->name('editorial.dashboard');

// Linear / Vercel / Notion Style Enterprise Admin CMS Portal
Route::prefix('cms')->name('cms.')->group(function () {
    Route::get('/', [AdminCMSController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts', [AdminCMSController::class, 'posts'])->name('posts');
    Route::get('/posts/create', [AdminCMSController::class, 'createPost'])->name('posts.create');
    Route::get('/drafts', [AdminCMSController::class, 'drafts'])->name('drafts');
    Route::get('/scheduled', [AdminCMSController::class, 'scheduled'])->name('scheduled');
    Route::get('/categories', [AdminCMSController::class, 'categories'])->name('categories');
    Route::get('/authors', [AdminCMSController::class, 'authors'])->name('authors');
    Route::get('/media', [AdminCMSController::class, 'media'])->name('media');
    Route::get('/seo', [AdminCMSController::class, 'seo'])->name('seo');
    Route::get('/analytics', [AdminCMSController::class, 'analytics'])->name('analytics');
    Route::get('/ai-studio', [AdminCMSController::class, 'aiStudio'])->name('ai-studio');
    Route::get('/research-queue', [AdminCMSController::class, 'researchQueue'])->name('research-queue');
    Route::get('/internal-linking', [AdminCMSController::class, 'internalLinking'])->name('internal-linking');
    Route::get('/deployment', [AdminCMSController::class, 'deployment'])->name('deployment');
    Route::get('/settings', [AdminCMSController::class, 'settings'])->name('settings');
});

// Auth Dashboard (Breeze Integration)
Route::get('/dashboard', function () {
    return redirect()->route('cms.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
