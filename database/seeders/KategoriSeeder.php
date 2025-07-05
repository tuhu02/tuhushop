<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriProduk;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Game',
            'Voucher',
            'Pulsa',
            'E-Money',
            'Paket Data',
            'Token Listrik',
            'Voucher Game',
            'Top Up',
        ];

        foreach ($kategoris as $nama) {
            KategoriProduk::firstOrCreate(['nama' => $nama]);
        }
    }
} 