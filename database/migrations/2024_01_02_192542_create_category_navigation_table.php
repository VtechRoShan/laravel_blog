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
        Schema::create('category_navigation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('navigation_id');
            $table->unsignedBigInteger('category_id');
            $table->integer('count')->default(1);
            $table->timestamps();
        
            // Define foreign key constraints
            $table->foreign('navigation_id')->references('id')->on('navigations')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_navigation');
    }
};
