<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Roles & Permissions
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['role_id', 'user_id']);
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->primary(['permission_id', 'role_id']);
        });

        // 2. Authors
        Schema::create('authors_prod', function (Blueprint $table) {
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
            $table->softDeletes();
        });

        // 3. Tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 4. Posts Table
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('authors_prod')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('status')->default('published'); // draft, published, archived
            $table->boolean('featured')->default(false);
            $table->integer('reading_time')->default(5);
            $table->timestamp('publish_date')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('canonical_url')->nullable();
            $table->json('schema_json')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('likes')->default(0);
            $table->unsignedBigInteger('shares')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'publish_date']);
            $table->index('views');
        });

        // 5. Post Category & Post Tag Pivots
        Schema::create('post_categories', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->primary(['post_id', 'category_id']);
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });

        // 6. Media & Featured Images
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('path');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->string('alt_text')->nullable();
            $table->timestamps();
        });

        Schema::create('featured_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('media_id')->constrained()->cascadeOnDelete();
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        // 7. Polymorphic Reactions
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->string('reactable_type');
            $table->unsignedBigInteger('reactable_id');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('like'); // like, fire, bookmark
            $table->string('ip_address')->nullable();
            $table->timestamps();

            $table->index(['reactable_type', 'reactable_id']);
        });

        // 8. Newsletters
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->longText('content');
            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('subscribers_count')->default(0);
            $table->timestamps();
        });

        // 9. SEO Meta & Redirects & Internal Links
        Schema::create('seo_meta', function (Blueprint $table) {
            $table->id();
            $table->string('seoable_type');
            $table->unsignedBigInteger('seoable_id');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->json('schema_json')->nullable();
            $table->timestamps();

            $table->index(['seoable_type', 'seoable_id']);
        });

        Schema::create('internal_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('target_post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('anchor_text');
            $table->timestamps();
        });

        Schema::create('redirects', function (Blueprint $table) {
            $table->id();
            $table->string('source_path')->unique();
            $table->string('target_path');
            $table->integer('status_code')->default(301);
            $table->timestamps();
        });

        // 10. FAQs & Schemas
        Schema::create('faqs_prod', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('faqable');
            $table->string('question');
            $table->text('answer');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('schemas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->json('schema_json');
            $table->timestamps();
        });

        // 11. Prompts & Prompt Categories & AI Generations
        Schema::create('prompt_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prompt_category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('prompt_text');
            $table->string('model_target')->default('Claude-3.7-Sonnet');
            $table->timestamps();
        });

        Schema::create('ai_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('prompt_id')->nullable()->constrained()->nullOnDelete();
            $table->text('input_prompt');
            $table->longText('output_text');
            $table->integer('tokens_used')->default(0);
            $table->timestamps();
        });

        // 12. Research Queue & Trend Sources & Published Logs & Activity Logs
        Schema::create('research_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('source_url')->nullable();
            $table->string('status')->default('queued'); // queued, in_review, published
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('trend_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('type')->default('rss');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('published_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('action')->default('published');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });

        // 13. System Settings, Menus, Pages, Contacts
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string');
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->unique();
            $table->json('items_json')->nullable();
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('unread');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('published_logs');
        Schema::dropIfExists('trend_sources');
        Schema::dropIfExists('research_topics');
        Schema::dropIfExists('ai_generations');
        Schema::dropIfExists('prompts');
        Schema::dropIfExists('prompt_categories');
        Schema::dropIfExists('schemas');
        Schema::dropIfExists('faqs_prod');
        Schema::dropIfExists('redirects');
        Schema::dropIfExists('internal_links');
        Schema::dropIfExists('seo_meta');
        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('reactions');
        Schema::dropIfExists('featured_images');
        Schema::dropIfExists('media');
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('authors_prod');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
