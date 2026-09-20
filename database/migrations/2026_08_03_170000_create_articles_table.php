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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->string('category')->default('Teknologi');
            $table->string('author_name')->default('Tim Engineering rbtgtech');
            $table->string('author_role')->default('Lead Systems Architect');
            $table->string('author_avatar')->default('/logo-rbtgtech.png');
            $table->string('image_url')->nullable();
            $table->json('tags')->nullable();
            $table->string('read_time')->default('5 menit');
            $table->enum('status', ['published', 'draft'])->default('published');
            $table->timestamp('published_at')->nullable();
            
            // RankMath SEO fields
            $table->string('focus_keyword')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('canonical_url')->nullable();
            $table->integer('seo_score')->default(85);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
