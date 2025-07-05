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
            // Check if columns exist before adding them
            if (!Schema::hasColumn('games', 'digiflazz_id')) {
                $table->string('digiflazz_id')->nullable()->after('is_active');
            }
            
            if (!Schema::hasColumn('games', 'category')) {
                $table->string('category')->nullable()->after('digiflazz_id');
            }
            
            if (!Schema::hasColumn('games', 'price')) {
                $table->decimal('price', 10, 2)->nullable()->after('category');
            }
            
            if (!Schema::hasColumn('games', 'brand')) {
                $table->string('brand')->nullable()->after('price');
            }
            
            if (!Schema::hasColumn('games', 'description')) {
                $table->text('description')->nullable()->after('brand');
            }
            
            if (!Schema::hasColumn('games', 'icon_url')) {
                $table->string('icon_url')->nullable()->after('description');
            }
            
            if (!Schema::hasColumn('games', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('icon_url');
            }
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