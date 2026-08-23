<?php

use App\Http\Controllers\AdminCMSController;
use App\Http\Controllers\AdvertiseController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DesignSystemController;
use App\Http\Controllers\EditorialDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\McpDirectoryController;
use App\Http\Controllers\WorkflowDirectoryController;
use App\Http\Controllers\NewsDirectoryController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// SEO, AEO & GEO Optimization Engine Endpoints
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/feed.xml', [SeoController::class, 'feed'])->name('feed');
Route::get('/rss', [SeoController::class, 'feed']);
Route::get('/llms.txt', [SeoController::class, 'llmsTxt'])->name('llms.txt');
Route::get('/llms-full.txt', [SeoController::class, 'llmsFullTxt'])->name('llms.full');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/8f3b2e7a1c9d40e5b6a7f8e9d0c1b2a3.txt', function () {
    return response('8f3b2e7a1c9d40e5b6a7f8e9d0c1b2a3', 200, ['Content-Type' => 'text/plain; charset=utf-8']);
});
Route::get('/api/v1/llm-context', [SeoController::class, 'llmContextApi'])->name('api.llm-context');

// Directory Hubs (AEO & GEO High Priority Index Pages)
Route::get('/mcp-directory', [McpDirectoryController::class, 'index'])->name('mcp.index');
Route::get('/workflows', [WorkflowDirectoryController::class, 'index'])->name('workflows.index');
Route::get('/latest-ai-news', [NewsDirectoryController::class, 'index'])->name('news.index');

// Public Editorial Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Legacy SEO 301 Redirects & 410 Removal (Fix Google Search Console 404 Not Found errors)
Route::get('/article/{slug}', function (string $slug) {
    $cleanSlug = rtrim($slug, '*&$');
    $article = \App\Models\Article::where('slug', $cleanSlug)->published()->first();
    return $article ? redirect($article->url, 301) : redirect('/', 301);
});

Route::get('/post/{slug}', function (string $slug) {
    $cleanSlug = rtrim($slug, '*&$');
    $article = \App\Models\Article::where('slug', $cleanSlug)->published()->first();
    return $article ? redirect($article->url, 301) : response('Content permanently removed', 410);
});

Route::get('/workflows/{slug}', function (string $slug) {
    $cleanSlug = rtrim($slug, '*&$');
    $article = \App\Models\Article::where('slug', $cleanSlug)->published()->first();
    return $article ? redirect($article->url, 301) : redirect('/workflows', 301);
});

Route::get('/blog/{slug}', function (string $slug) {
    $cleanSlug = rtrim($slug, '*&$');
    $article = \App\Models\Article::where('slug', $cleanSlug)->published()->first();
    return $article ? redirect($article->url, 301) : redirect('/latest-ai-news', 301);
});

Route::get('/latest-ai-news/{slug}', function (string $slug) {
    $cleanSlug = rtrim($slug, '*&$');
    $article = \App\Models\Article::where('slug', $cleanSlug)->published()->first();
    return $article ? redirect($article->url, 301) : redirect('/latest-ai-news', 301);
});

Route::get('/reports/{slug}', function (string $slug) {
    $cleanSlug = rtrim($slug, '*&$');
    $article = \App\Models\Article::where('slug', $cleanSlug)->published()->first();
    return $article ? redirect($article->url, 301) : redirect('/', 301);
});

Route::post('/article/{article}/comments', [ArticleController::class, 'storeComment'])->name('articles.comments.store');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Revenue & Monetization Public Routes
Route::get('/advertise', [AdvertiseController::class, 'index'])->name('advertise');
Route::post('/advertise/lead', [AdvertiseController::class, 'submitLead'])->name('advertise.lead');

Route::get('/subscribe', [SubscribeController::class, 'index'])->name('subscribe');
Route::post('/subscribe/checkout', [SubscribeController::class, 'checkout'])->name('subscribe.checkout');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

// Reading List / Bookmarks
Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
Route::post('/bookmarks/{article}/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Company, Legal & Compliance Trust Routes (AdSense & Regulatory Compliance)
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');

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

    // Revenue Architecture CMS Routes
    Route::get('/monetization', [AdminCMSController::class, 'monetization'])->name('monetization');
    Route::get('/sponsors', [AdminCMSController::class, 'sponsors'])->name('sponsors');
    Route::post('/sponsors/create', [AdminCMSController::class, 'createSponsor'])->name('sponsors.create');
    Route::get('/subscriptions', [AdminCMSController::class, 'subscriptions'])->name('subscriptions');
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

// Category-prefixed Article Routes (must be last — matches /workflow/, /blogs/, /mcp-directory/, and /mcp/)
Route::get('/{categorySlug}/{slug}', [ArticleController::class, 'show'])
    ->name('articles.show')
    ->where('categorySlug', 'workflow|blogs|mcp-directory|mcp');

require __DIR__.'/auth.php';
