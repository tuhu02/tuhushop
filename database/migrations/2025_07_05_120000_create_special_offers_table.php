<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('special_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('type'); // promo, first_topup, weekly, dll
            $table->string('title');
            $table->string('icon')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('special_offers');
    }
}; 