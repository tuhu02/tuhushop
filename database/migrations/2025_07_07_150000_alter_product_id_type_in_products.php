<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // 1. Drop foreign key di bundles
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
        });

        // 2. Ubah tipe kolom product_id di products
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
        });

        // 3. Ubah tipe kolom game_id di bundles
        Schema::table('bundles', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->change();
        });

        // 4. Tambahkan kembali foreign key
        Schema::table('bundles', function (Blueprint $table) {
            $table->foreign('game_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }
    public function down()
    {
        // 1. Drop foreign key baru
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
        });

        // 2. Kembalikan tipe kolom game_id di bundles (misal integer)
        Schema::table('bundles', function (Blueprint $table) {
            $table->integer('game_id')->change();
        });

        // 3. Kembalikan tipe kolom product_id di products (misal bigInteger)
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('product_id')->change(); // sesuaikan tipe sebelumnya
        });

        // 4. Tambahkan kembali foreign key lama jika perlu
        // (opsional, tergantung kebutuhan)
    }
}; 