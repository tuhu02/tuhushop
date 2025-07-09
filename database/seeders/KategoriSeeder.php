<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori_produks')->insert([
            [
                'id' => 1,
                'nama' => 'Game',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama' => 'Voucher',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 