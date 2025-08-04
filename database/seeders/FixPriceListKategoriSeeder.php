<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PriceList;
use App\Models\KategoriDenom;

class FixPriceListKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Fixing price lists with empty kategori_id..." . PHP_EOL;
        
        // Ambil kategori Diamond (ID: 6)
        $diamondKategori = KategoriDenom::find(6);
        
        if (!$diamondKategori) {
            echo "Diamond kategori not found!" . PHP_EOL;
            return;
        }
        
        // Update price lists yang memiliki kategori_id kosong atau null
        $priceLists = PriceList::where('product_id', 11)
            ->where(function($query) {
                $query->whereNull('kategori_id')
                      ->orWhere('kategori_id', '')
                      ->orWhere('kategori_id', 0);
            })
            ->get();
        
        echo "Found {$priceLists->count()} price lists with empty kategori_id" . PHP_EOL;
        
        foreach ($priceLists as $pl) {
            $pl->update(['kategori_id' => $diamondKategori->id]);
            echo "Updated price list ID {$pl->id} ({$pl->nama_produk}) to kategori {$diamondKategori->nama}" . PHP_EOL;
        }
        
        echo "Successfully updated all price lists!" . PHP_EOL;
    }
}
