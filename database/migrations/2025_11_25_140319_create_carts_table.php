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
    Schema::create('carts', function (Blueprint $table) {
        $table->id();
        $table->string('session_id')->nullable(); // for guest users
        $table->unsignedBigInteger('user_id')->nullable(); // for logged-in users
        $table->unsignedBigInteger('product_id');
        $table->string('product_name');
        $table->string('product_image')->nullable();
        $table->string('size')->nullable();
        $table->string('color')->nullable();
        $table->decimal('price', 10, 2);
        $table->integer('quantity')->default(1);
        $table->timestamps();

        // Optional indexes for faster queries
        $table->index('session_id');
        $table->index('user_id');
        $table->index(['product_id', 'user_id', 'session_id']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
