<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Sponsors Table
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->string('website_url');
            $table->string('contact_email');
            $table->enum('status', ['active', 'inactive', 'prospect'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Sponsorships Table
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->onDelete('cascade');
            $table->enum('placement_type', ['newsletter', 'dispatch', 'category_rail', 'header_banner', 'partner_spotlight']);
            $table->foreignId('article_id')->nullable()->constrained('articles')->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('price_paid', 10, 2)->default(0.00);
            $table->unsignedInteger('impressions')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->enum('status', ['active', 'scheduled', 'expired', 'cancelled'])->default('active');
            $table->text('custom_copy')->nullable();
            $table->timestamps();
        });

        // 3. Subscriptions Table
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->enum('plan', ['monthly', 'annual', 'enterprise'])->default('monthly');
            $table->decimal('amount', 8, 2)->default(19.00);
            $table->enum('status', ['active', 'past_due', 'canceled', 'incomplete'])->default('active');
            $table->string('stripe_subscription_id')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamps();
        });

        // 4. Affiliate Links Table
        Schema::create('affiliate_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
            $table->string('label');
            $table->string('url');
            $table->string('disclosure_text')->default('Sponsored link — Daily AI World may earn an affiliate commission.');
            $table->unsignedInteger('click_count')->default(0);
            $table->decimal('revenue_earned', 8, 2)->default(0.00);
            $table->timestamps();
        });

        // 5. Sponsor Reports Table
        Schema::create('sponsor_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_id')->constrained('sponsors')->onDelete('cascade');
            $table->string('report_month'); // e.g. "2026-07"
            $table->unsignedInteger('total_impressions')->default(0);
            $table->unsignedInteger('total_clicks')->default(0);
            $table->decimal('ctr', 5, 2)->default(0.00);
            $table->decimal('total_spend', 10, 2)->default(0.00);
            $table->json('summary_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_reports');
        Schema::dropIfExists('affiliate_links');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('sponsorships');
        Schema::dropIfExists('sponsors');
    }
};
