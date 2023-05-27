<?php

use Domain\Content\Enums\BlogPostStatus;
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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->ulid()->unique();

            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('title');
            $table->string('slug');
            $table->string('author');
            $table->timestamp('date');
            $table->longText('body');
            $table->integer('likes')->default(0);
            $table->string('status')->default(BlogPostStatus::DRAFT()->value);

            $table->timestamps();

            $table->unique('slug');
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
