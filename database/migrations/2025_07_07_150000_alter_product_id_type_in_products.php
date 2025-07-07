<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
        });
    }
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('product_id')->change(); // aslinya apa, sesuaikan jika perlu
        });
    }
}; 