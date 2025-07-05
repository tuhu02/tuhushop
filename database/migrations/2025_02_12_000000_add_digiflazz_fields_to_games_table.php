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
        Schema::table('games', function (Blueprint $table) {
            $table->string('digiflazz_id')->nullable()->after('is_active');
            $table->string('category')->nullable()->after('digiflazz_id');
            $table->decimal('price', 10, 2)->nullable()->after('category');
            $table->string('brand')->nullable()->after('price');
            $table->text('description')->nullable()->after('brand');
            $table->string('icon_url')->nullable()->after('description');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('icon_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn([
                'digiflazz_id',
                'category',
                'price',
                'brand',
                'description',
                'icon_url',
                'status'
            ]);
        });
    }
}; 