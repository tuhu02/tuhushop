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
        Schema::table('price_lists', function (Blueprint $table) {
            $table->decimal('harga_jual', 15, 2)->nullable()->after('harga');
        });
    }
    
    public function down()
    {
        Schema::table('price_lists', function (Blueprint $table) {
            $table->dropColumn('harga_jual');
        });
    }
};
