<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // 1. Drop foreign key di bundles
        Schema::table('bundles', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
        });

        // 2. Ubah kolom product_id menjadi BIGINT UNSIGNED AUTO_INCREMENT
        DB::statement('ALTER TABLE products MODIFY product_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;');

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

        // 3. Kembalikan ke INT jika perlu (tanpa unsigned)
        DB::statement('ALTER TABLE products MODIFY product_id INT NOT NULL AUTO_INCREMENT;');

        // 4. Tambahkan kembali foreign key lama jika perlu
        // (opsional, tergantung kebutuhan)
    }
}; 