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
        Schema::create('shared_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('Draft');
            $table->longText('post_body')->nullable();
            $table->string('keyword')->nullable();
            $table->string('seo_title')->nullable();
            $table->longText('meta_desc')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('reading_time')->nullable();
            $table->string('model')->nullable();
            $table->timestamps();

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_attributes');
    }
};
