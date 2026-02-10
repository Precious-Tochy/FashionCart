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
        Schema::create('dresses', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->string('brand');
            $table->string('category');
             
            $table->string('color');
            $table->string('price');
            $table->json('size')->nullable();
            $table->longText('stock')->nullable();



            $table->string('material');
            $table->longText('description');
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dresses');
    }
};
