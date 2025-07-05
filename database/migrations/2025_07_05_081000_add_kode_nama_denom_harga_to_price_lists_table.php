<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_lists', function (Blueprint $table) {
            $table->string('kode_produk')->nullable()->after('game_id');
            $table->string('nama_produk')->nullable()->after('kode_produk');
            $table->string('denom')->nullable()->after('nama_produk');
            $table->decimal('harga', 12, 2)->nullable()->after('denom');
        });
    }

    public function down(): void
    {
        Schema::table('price_lists', function (Blueprint $table) {
            $table->dropColumn(['kode_produk', 'nama_produk', 'denom', 'harga']);
        });
    }
}; 