<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriDenomSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_denoms')->insert([
            ['nama' => 'Diamond', 'slug' => 'diamond'],
            ['nama' => 'Weekly', 'slug' => 'weekly'],
            ['nama' => 'Promo', 'slug' => 'promo'],
            ['nama' => 'Non Diamond', 'slug' => 'nondiamond'],
        ]);
    }
} 