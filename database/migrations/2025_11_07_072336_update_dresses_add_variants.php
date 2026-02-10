<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dresses', function (Blueprint $table) {
            // drop 1 by 1 (MYSQL hates multiple drop in array)
            $table->dropColumn('color');
            $table->dropColumn('size');
            $table->dropColumn('stock');

            // add new JSON column
            $table->json('variants')->nullable()->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('dresses', function (Blueprint $table) {
            $table->string('color')->nullable();
            $table->json('size')->nullable();
            $table->longText('stock')->nullable();
            $table->dropColumn('variants');
        });
    }
};

