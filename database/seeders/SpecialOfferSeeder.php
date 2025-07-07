<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialOfferSeeder extends Seeder
{
    public function run()
    {
        // Contoh: asumsikan product_id 1 = Mobile Legends, 2 = PUBG
        DB::table('special_offers')->insert([
            [
                'product_id' => 1,
                'type' => 'promo',
                'title' => 'Promo Hari Ini',
                'icon' => 'fas fa-bolt',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'type' => 'first_topup',
                'title' => 'Top Up Pertama (Double Diamonds)',
                'icon' => 'fas fa-gift',
                'active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'type' => 'weekly',
                'title' => 'Weekly Pass',
                'icon' => 'fas fa-calendar-week',
                'active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'type' => 'promo',
                'title' => 'Promo Hari Ini',
                'icon' => 'fas fa-bolt',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'type' => 'first_topup',
                'title' => 'Top Up Pertama',
                'icon' => 'fas fa-gift',
                'active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 