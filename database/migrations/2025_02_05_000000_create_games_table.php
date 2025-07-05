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
        Schema::create('games', function (Blueprint $table) {
            $table->integer('game_id')->autoIncrement()->primary();
            $table->string('game_name', 100);
            $table->string('developer', 50)->nullable();
            $table->date('release_date')->nullable();
            $table->string('thumbnail_url', 255)->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('digiflazz_id', 255)->nullable();
            $table->string('category', 255)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('brand', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('icon_url', 255)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
}; 