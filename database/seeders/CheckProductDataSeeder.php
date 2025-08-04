<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\PriceList;
use App\Models\KategoriDenom;

class CheckProductDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Checking product 11..." . PHP_EOL;
        
        $product = Produk::where('product_id', 11)->first();
        if ($product) {
            echo "Product found: {$product->product_name}" . PHP_EOL;
        } else {
            echo "Product 11 not found!" . PHP_EOL;
            return;
        }
        
        echo "Checking price lists for product 11..." . PHP_EOL;
        $priceLists = PriceList::where('product_id', 11)->get();
        echo "Found {$priceLists->count()} price lists" . PHP_EOL;
        
        foreach ($priceLists as $pl) {
            echo "ID: {$pl->id}, Kategori ID: {$pl->kategori_id}, Nama: {$pl->nama_produk}" . PHP_EOL;
        }
        
        echo "Checking kategori denoms..." . PHP_EOL;
        $kategoriDenoms = KategoriDenom::all();
        echo "Found {$kategoriDenoms->count()} kategori denoms" . PHP_EOL;
        
        foreach ($kategoriDenoms as $kd) {
            echo "ID: {$kd->id}, Nama: {$kd->nama}, Slug: {$kd->slug}" . PHP_EOL;
        }
        
        echo "Checking kategori denoms with price lists for product 11..." . PHP_EOL;
        $filteredKategoriDenoms = KategoriDenom::whereHas('denoms', function($query) use ($product) {
            $query->where('product_id', $product->product_id);
        })->get();
        
        echo "Found {$filteredKategoriDenoms->count()} kategori denoms with price lists" . PHP_EOL;
        
        foreach ($filteredKategoriDenoms as $kd) {
            echo "ID: {$kd->id}, Nama: {$kd->nama}, Slug: {$kd->slug}" . PHP_EOL;
        }
    }
}
