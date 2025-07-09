<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            DB::table('products')->insert([
                [
                    'product_name' => 'Mobile Legends',
                    'developer' => 'Moonton',
                    'description' => 'Beli Top up ML Diamond Mobile Legends dan Weekly Diamond Pass MLBB Harga Termurah Se-Indonesia, Dijamin Aman, Cepat dan Terpercaya hanya ada di Tuhu Shop',
                    'thumbnail_url' => 'mlbbhuhu.jpg',
                    'banner_url' => '1751754368_lunox_nature_s_harmony_skin_mobile_legends_by_k1ng011011_djfdmtz.jpg',
                    'logo' => null,
                    'is_active' => 1,
                    'is_popular' => 1,
                    'kategori_id' => $mobileGames->id,
                    'kode_digiflazz' => 'mlbb',
                    'account_fields' => json_encode([
                        ['label' => 'ID', 'name' => 'user_id', 'type' => 'text'],
                        ['label' => 'Server', 'name' => 'server', 'type' => 'text']
                    ]),
                ],
                [
                    'product_name' => 'Free Fire',
                    'developer' => 'Garena',
                    'description' => 'Top up Free Fire termurah dan tercepat.',
                    'thumbnail_url' => 'freefire.jpg',
                    'banner_url' => '1751860449_fanny_10_blade_of_kibou_by_clpfs21_djnw214.jpg',
                    'logo' => null,
                    'is_active' => 1,
                    'is_popular' => 1,
                    'kategori_id' => $mobileGames->id,
                    'kode_digiflazz' => 'freefire',
                    'account_fields' => json_encode([
                        ['label' => 'User ID', 'name' => 'user_id', 'type' => 'text']
                    ]),
                ],
                [
                    'product_name' => 'PUBG Mobile',
                    'developer' => 'Tencent',
                    'description' => 'Top up UC PUBG Mobile murah dan cepat.',
                    'thumbnail_url' => 'pubgm.jpg',
                    'banner_url' => 'apex.jpg',
                    'logo' => null,
                    'is_active' => 1,
                    'is_popular' => 1,
                    'kategori_id' => $mobileGames->id,
                    'kode_digiflazz' => 'pubgm',
                    'account_fields' => json_encode([
                        ['label' => 'Character ID', 'name' => 'user_id', 'type' => 'text']
                    ]),
                ],
                [
                    'product_name' => 'Genshin Impact',
                    'developer' => 'miHoYo',
                    'description' => 'Top up Genesis Crystal Genshin Impact termurah.',
                    'thumbnail_url' => 'kleeGenshin.jpeg',
                    'banner_url' => 'genshin.jpg',
                    'logo' => null,
                    'is_active' => 1,
                    'is_popular' => 0,
                    'kategori_id' => $mobileGames->id,
                    'kode_digiflazz' => 'genshin',
                    'account_fields' => json_encode([
                        ['label' => 'UID', 'name' => 'uid', 'type' => 'text'],
                        ['label' => 'Server', 'name' => 'server', 'type' => 'text']
                    ]),
                ],
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