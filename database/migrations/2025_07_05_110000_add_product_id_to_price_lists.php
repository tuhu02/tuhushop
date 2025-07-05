<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('id');
        });
        // Copy data dari game_id ke product_id
        \DB::statement('UPDATE price_lists SET product_id = game_id');
        // Hapus kolom game_id
        Schema::table('price_lists', function (Blueprint $table) {
            $table->dropColumn('game_id');
        });
    }

    public function down(): void
    {
        Schema::table('price_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->nullable()->after('id');
        });
        // Copy data dari product_id ke game_id
        \DB::statement('UPDATE price_lists SET game_id = product_id');
        // Hapus kolom product_id
        Schema::table('price_lists', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }
}; 