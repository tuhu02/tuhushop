<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rename table
        Schema::rename('games', 'products');

        // Rename columns
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('game_id', 'product_id');
            $table->renameColumn('game_name', 'product_name');
            // Tambahkan rename kolom lain jika ada
        });
        // NOTE: Update foreign key di tabel lain (price_lists, favorits, bundles, dll) secara manual jika perlu
    }

    public function down(): void
    {
        Schema::rename('products', 'games');
        Schema::table('games', function (Blueprint $table) {
            $table->renameColumn('product_id', 'game_id');
            $table->renameColumn('product_name', 'game_name');
            // Balikkan kolom lain jika ada
        });
        // NOTE: Balikkan foreign key di tabel lain secara manual jika perlu
    }
}; 