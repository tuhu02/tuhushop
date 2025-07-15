<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produk;
use App\Models\PriceList;
use App\Services\DigiflazzService;
use Illuminate\Support\Facades\DB;

class ResetDigiflazzProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digiflazz:reset-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bersihkan semua produk dan denom, lalu isi ulang hanya dengan produk dari Digiflazz';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Menghapus semua produk dan denom...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PriceList::truncate();
        Produk::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Mengambil data produk dari Digiflazz...');
        $digiflazz = new DigiflazzService();
        $priceList = $digiflazz->getPriceList();
        $produkCount = 0;
        $denomCount = 0;
        $produkMap = [];

        foreach ($priceList as $item) {
            // Cek apakah produk sudah ada di map (berdasarkan nama)
            $productName = ucwords(strtolower($item['brand'] ?? $item['name']));
            if (!isset($produkMap[$productName])) {
                $produk = Produk::create([
                    'product_name' => $productName,
                    'brand' => $item['brand'] ?? null,
                    'description' => $item['desc'] ?? null,
                    'thumbnail_url' => $item['icon_url'] ?? null,
                    'is_active' => 1,
                    'digiflazz_id' => $item['buyer_sku_code'] ?? null,
                    'category' => $item['category'] ?? null,
                    'kode_digiflazz' => $item['buyer_sku_code'] ?? null,
                ]);
                $produkMap[$productName] = $produk->product_id;
                $produkCount++;
            }
            // Tambahkan denom ke produk terkait
            PriceList::create([
                'product_id' => $produkMap[$productName],
                'nama_produk' => $item['product_name'] ?? $item['name'] ?? $item['brand'] ?? $item['buyer_sku_code'] ?? 'Unknown',
                'harga_beli' => $item['price'] ?? 0,
                'harga_jual' => ($item['price'] ?? 0) + 1000, // markup 1000
                'denom' => $item['desc'] ?? null,
                'provider' => 'Digiflazz',
                'kode_digiflazz' => $item['buyer_sku_code'] ?? null,
                'kode_produk' => $item['buyer_sku_code'] ?? null,
            ]);
            $denomCount++;
        }
        $this->info("Selesai! Produk: $produkCount, Denom: $denomCount diimport dari Digiflazz.");
    }
}
