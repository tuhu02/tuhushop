<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\KategoriDenom;

class KategoriDenomSeeder extends Seeder
{
    public function run(): void
    {
        // Get Mobile Legends product
        $mobileLegends = Produk::where('product_name', 'LIKE', '%Mobile Legends%')->first();
        
        // Check if Cek Username category already exists
        $cekUsernameExists = KategoriDenom::where('slug', 'cek-username')->exists();
        
        if (!$cekUsernameExists && $mobileLegends) {
            DB::table('kategori_denoms')->insert([
                ['nama' => 'Cek Username', 'slug' => 'cek-username', 'product_id' => $mobileLegends->product_id],
            ]);
        }
    }
} 