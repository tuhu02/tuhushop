<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Ubah kolom product_id menjadi BIGINT UNSIGNED AUTO_INCREMENT
        DB::statement('ALTER TABLE products MODIFY product_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;');
    }
    public function down()
    {
        // Kembalikan ke INT jika perlu (tanpa unsigned)
        DB::statement('ALTER TABLE products MODIFY product_id INT NOT NULL AUTO_INCREMENT;');
    }
}; 