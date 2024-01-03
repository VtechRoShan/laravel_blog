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

            $table->unsignedBigInteger('shared_attributes_id')->nullable();
            $table->foreign('shared_attributes_id')->references('id')->on('shared_attributes');

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
