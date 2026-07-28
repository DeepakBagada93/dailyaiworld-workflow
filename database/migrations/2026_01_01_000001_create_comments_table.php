<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('ai_summary')->nullable()->after('deck');
            $table->json('faqs')->nullable()->after('key_takeaways');
            $table->timestamp('updated_date')->nullable()->after('published_at');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->text('content');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['ai_summary', 'faqs', 'updated_date']);
        });
    }
};
