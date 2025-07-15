<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Produk;
use App\Models\PriceList;

class SyncDigiflazzProducts extends Command
{
    protected $signature = 'digiflazz:sync-products';
    protected $description = 'Sync product list from Digiflazz API to products and price_lists table, dan rapikan duplikat produk utama.';

    public function handle()
    {
        $this->info('Mengambil data produk dari Digiflazz...');
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        $baseUrl = config('services.digiflazz.base_url');
        $sign = md5($username . $apiKey . 'pricelist');

        $response = Http::post($baseUrl . '/price-list', [
            'cmd' => 'prepaid',
            'username' => $username,
            'sign' => $sign,
        ]);

        $data = $response->json('data');
        if (!$data) {
            $this->error('Gagal mengambil data dari Digiflazz.');
            return 1;
        }

        $produkCount = 0;
        $denomCount = 0;
        $produkMap = [];
        $brandToMainProductId = [];

        // 1. Temukan produk utama existing (case-insensitive) untuk setiap brand
        $allProducts = Produk::all();
        foreach ($allProducts as $prod) {
            $brandKey = strtolower(trim($prod->brand));
            if (!isset($brandToMainProductId[$brandKey])) {
                $brandToMainProductId[$brandKey] = $prod->product_id;
            }
        }

        foreach ($data as $item) {
            $brand = $item['brand'] ?? 'Unknown';
            $category = $item['category'] ?? 'Unknown';
            $brandKey = strtolower(trim($brand));
            $productName = ucwords(strtolower($brand));

            // 2. Pakai produk utama existing jika ada, jika tidak buat baru
            if (isset($brandToMainProductId[$brandKey])) {
                $mainProduct = Produk::find($brandToMainProductId[$brandKey]);
            } else {
                $mainProduct = Produk::create([
                    'product_name' => $productName,
                    'brand' => $brand,
                    'category' => $category,
                    'is_active' => 1,
                    'status' => 'active',
                    'description' => $brand,
                ]);
                $brandToMainProductId[$brandKey] = $mainProduct->product_id;
            }
            $produkMap[$brand] = $mainProduct->product_id;
            $produkCount++;

            // 3. Insert/update denom ke price_lists
            PriceList::updateOrCreate(
                [
                    'kode_digiflazz' => $item['buyer_sku_code'] ?? null,
                ],
                [
                    'product_id' => $mainProduct->product_id,
                    'kode_produk' => $item['buyer_sku_code'] ?? null,
                    'nama_produk' => $item['product_name'] ?? '',
                    'denom' => $item['desc'] ?? '',
                    'harga_beli' => $item['price'] ?? 0,
                    'harga_jual' => ($item['price'] ?? 0) + 1000, // markup contoh
                    'provider' => 'Digiflazz',
                ]
            );
            $denomCount++;
        }

        // 4. Hapus produk utama duplikat (case-insensitive, simpan satu saja per brand)
        foreach ($brandToMainProductId as $brandKey => $mainProductId) {
            $dupes = Produk::whereRaw('LOWER(brand) = ?', [$brandKey])
                ->where('product_id', '!=', $mainProductId)
                ->get();
            foreach ($dupes as $dupe) {
                // Update semua price_lists yang mengacu ke dupe ke mainProductId
                PriceList::where('product_id', $dupe->product_id)->update(['product_id' => $mainProductId]);
                $dupe->delete();
            }
        }

        $this->info("Berhasil sync {$produkCount} produk utama dan {$denomCount} denom dari Digiflazz. Duplikat produk utama sudah dirapikan.");
        return 0;
    }
}
