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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('slug')->unique()->nullable();

            $table->string('status')->default('Draft');
            $table->longText('post_body')->nullable();
            $table->string('keyword')->nullable();
            $table->string('seo_title')->nullable();

            $table->LongText('blog_meta_desc')->nullable();
            $table->LongText('summary')->nullable();
            $table->LongText('reading_time')->nullable();

            $table->string('thumnail_image')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('image_caption')->nullable();

            $table->unsignedBigInteger('nav_bar_id')->nullable();
            $table->foreign('nav_bar_id')->references('id')->on('navigations');

            $table->string('publish_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
