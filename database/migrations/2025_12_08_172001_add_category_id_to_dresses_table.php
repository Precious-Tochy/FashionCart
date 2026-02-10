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
    Schema::table('dresses', function (Blueprint $table) {
        // Add category_id column as foreign key
        $table->unsignedBigInteger('category_id')->nullable()->after('brand');
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

        // Remove the old category column
        $table->dropColumn('category');
    });
}

public function down(): void
{
    Schema::table('dresses', function (Blueprint $table) {
        $table->string('category')->after('brand');
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');
    });
}

};
