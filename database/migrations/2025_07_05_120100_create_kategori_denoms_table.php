<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kategori_denoms', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama kategori, misal: Diamond, Weekly, Promo
            $table->string('slug')->unique(); // slug: diamond, weekly, promo
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('kategori_denoms');
    }
}; 