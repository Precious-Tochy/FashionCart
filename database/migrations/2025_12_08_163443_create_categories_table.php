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
            $table->string('name');              // Category name
            $table->string('slug')->unique();    // For SEO-friendly URLs
            $table->foreignId('parent_id')       // Parent category
                  ->nullable()
                  ->constrained('categories')
                  ->onDelete('cascade');
            $table->boolean('status')->default(1); // Active/inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
