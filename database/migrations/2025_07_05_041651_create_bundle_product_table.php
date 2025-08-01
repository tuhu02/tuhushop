<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bundle_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bundle_id');
            $table->unsignedBigInteger('product_id'); // asumsikan relasi ke price_lists
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('bundle_id')->references('id')->on('bundles')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('price_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundle_product');
    }
};
