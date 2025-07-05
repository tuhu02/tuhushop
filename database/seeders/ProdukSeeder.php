<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\KategoriProduk;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Get categories
        $mobileGames = KategoriProduk::where('nama', 'Mobile Games')->first();
        $pcGames = KategoriProduk::where('nama', 'PC Games')->first();
        $voucher = KategoriProduk::where('nama', 'Voucher')->first();
        $pulsa = KategoriProduk::where('nama', 'Pulsa')->first();

        // Mobile Games
        if ($mobileGames) {
            Produk::create([
                'product_name' => 'Mobile Legends: Bang Bang',
                'description' => 'Top up Diamond Mobile Legends dengan harga termurah dan proses instan',
                'developer' => 'Moonton',
                'kategori_id' => $mobileGames->id,
                'is_active' => 1,
                'is_popular' => 1,
            ]);

            Produk::create([
                'product_name' => 'PUBG Mobile',
                'description' => 'Top up UC PUBG Mobile dengan harga termurah dan proses instan',
                'developer' => 'PUBG Corporation',
                'kategori_id' => $mobileGames->id,
                'is_active' => 1,
                'is_popular' => 1,
            ]);

            Produk::create([
                'product_name' => 'Free Fire',
                'description' => 'Top up Diamond Free Fire dengan harga termurah dan proses instan',
                'developer' => 'Garena',
                'kategori_id' => $mobileGames->id,
                'is_active' => 1,
                'is_popular' => 0,
            ]);

            Produk::create([
                'product_name' => 'Genshin Impact',
                'description' => 'Top up Genesis Crystal Genshin Impact dengan harga termurah',
                'developer' => 'miHoYo',
                'kategori_id' => $mobileGames->id,
                'is_active' => 1,
                'is_popular' => 1,
            ]);
        }

        // PC Games
        if ($pcGames) {
            Produk::create([
                'product_name' => 'Steam Wallet',
                'description' => 'Top up Steam Wallet dengan harga termurah dan proses instan',
                'developer' => 'Valve',
                'kategori_id' => $pcGames->id,
                'is_active' => 1,
                'is_popular' => 1,
            ]);

            Produk::create([
                'product_name' => 'Dota 2',
                'description' => 'Top up Dota 2 dengan harga termurah dan proses instan',
                'developer' => 'Valve',
                'kategori_id' => $pcGames->id,
                'is_active' => 1,
                'is_popular' => 0,
            ]);
        }

        // Voucher
        if ($voucher) {
            Produk::create([
                'product_name' => 'Google Play Gift Card',
                'description' => 'Voucher Google Play dengan harga termurah dan proses instan',
                'developer' => 'Google',
                'kategori_id' => $voucher->id,
                'is_active' => 1,
                'is_popular' => 1,
            ]);

            Produk::create([
                'product_name' => 'Apple App Store Gift Card',
                'description' => 'Voucher Apple App Store dengan harga termurah',
                'developer' => 'Apple',
                'kategori_id' => $voucher->id,
                'is_active' => 1,
                'is_popular' => 0,
            ]);
        }

        // Pulsa
        if ($pulsa) {
            Produk::create([
                'product_name' => 'Telkomsel',
                'description' => 'Pulsa Telkomsel dengan harga termurah dan proses instan',
                'developer' => 'Telkomsel',
                'kategori_id' => $pulsa->id,
                'is_active' => 1,
                'is_popular' => 1,
            ]);

            Produk::create([
                'product_name' => 'XL',
                'description' => 'Pulsa XL dengan harga termurah dan proses instan',
                'developer' => 'XL Axiata',
                'kategori_id' => $pulsa->id,
                'is_active' => 1,
                'is_popular' => 0,
            ]);
        }
    }
} 