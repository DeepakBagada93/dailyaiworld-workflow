<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('accent_color')->default('#6D28D9');
            $table->string('icon')->default('sparkles');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('title')->default('Senior AI Analyst');
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->timestamps();
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('deck')->nullable(); // Subtitle / editorial deck
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->integer('reading_time')->default(5); // in minutes
            $table->string('audio_url')->nullable();
            $table->json('key_takeaways')->nullable();
            $table->enum('tier', ['Breaking', 'Deep Dive', 'Founder Story', 'Research Breakdown', 'Briefing'])->default('Deep Dive');
            $table->boolean('is_hero')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->float('trending_score')->default(0);
            $table->timestamps();
        });

        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('session_id')->nullable();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('edition')->default('Daily Executive Briefing');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('market_indices', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('name');
            $table->string('value');
            $table->string('change_pct');
            $table->enum('direction', ['up', 'down', 'flat'])->default('up');
            $table->string('type')->default('benchmark'); // benchmark, gpu, index, sentiment
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_indices');
        Schema::dropIfExists('newsletter_subscribers');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('categories');
    }
};
