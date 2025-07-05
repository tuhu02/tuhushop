<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('favorits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedInteger('game_id')->nullable();
            $table->timestamps();
    
            // Foreign key (optional, jika ada relasi user/game)
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('game_id')->references('game_id')->on('games')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('favorits');
    }
};
