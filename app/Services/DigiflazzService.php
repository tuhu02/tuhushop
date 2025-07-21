<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DigiflazzService
{
    protected $username;
    protected $apiKey;
    protected $baseUrl;
    protected $sign;

    public function __construct()
    {
        $this->username = config('services.digiflazz.username', '');
        $this->apiKey = config('services.digiflazz.api_key', '');
        $this->baseUrl = config('services.digiflazz.base_url', 'https://api.digiflazz.com/v1');
        $this->sign = md5($this->username . $this->apiKey . 'pricelist');
    }

    /**
     * Get price list from Digiflazz
     */
    public function getPriceList()
    {
        try {
            $response = Http::post($this->baseUrl . '/price-list', [
                'cmd' => 'prepaid',
                'username' => $this->username,
                'sign' => $this->sign
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'])) {
                    return $data['data'];
                }
                
                Log::error('Digiflazz API Error: Invalid response structure', $data);
                return [];
            }

            Log::error('Digiflazz API Error: HTTP ' . $response->status(), [
                'response' => $response->body()
            ]);
            return [];

        } catch (\Exception $e) {
            Log::error('Digiflazz API Exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get game categories from Digiflazz
     */
    public function getGameCategories()
    {
        try {
            $response = Http::post($this->baseUrl . '/price-list', [
                'cmd' => 'prepaid',
                'username' => $this->username,
                'sign' => $this->sign
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'])) {
                    // Group by category
                    $categories = [];
                    foreach ($data['data'] as $item) {
                        $category = $item['category'] ?? 'Unknown';
                        if (!isset($categories[$category])) {
                            $categories[$category] = [];
                        }
                        $categories[$category][] = $item;
                    }
                    return $categories;
                }
            }

            return [];

        } catch (\Exception $e) {
            Log::error('Digiflazz Categories Exception: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Check API connection
     */
    public function checkConnection()
    {
        try {
            $response = Http::timeout(10)->post($this->baseUrl . '/price-list', [
                'cmd' => 'prepaid',
                'username' => $this->username,
                'sign' => $this->sign
            ]);

            return [
                'success' => $response->successful(),
                'status_code' => $response->status(),
                'message' => $response->successful() ? 'API Connected' : 'API Connection Failed'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'status_code' => 0,
                'message' => 'Connection Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Sync games from Digiflazz to local database
     */
    public function syncGames()
    {
        $priceList = $this->getPriceList();
        $syncedCount = 0;
        $errors = [];

        foreach ($priceList as $item) {
            try {
                // Check if product already exists
                $existingProduct = \App\Models\Produk::where('product_name', $item['name'])->first();
                
                if (!$existingProduct) {
                    \App\Models\Produk::create([
                        'product_name' => $item['name'],
                        'developer' => $item['brand'] ?? 'Unknown',
                        'description' => $item['desc'] ?? '',
                        'thumbnail_url' => $item['icon_url'] ?? 'default-game.jpg',
                        'is_active' => 1,
                        'digiflazz_id' => $item['buyer_sku_code'] ?? null,
                        'category' => $item['category'] ?? 'Unknown'
                    ]);
                    $syncedCount++;
                }
            } catch (\Exception $e) {
                $errors[] = "Error syncing {$item['name']}: " . $e->getMessage();
            }
        }

        return [
            'synced_count' => $syncedCount,
            'errors' => $errors
        ];
    }

    /**
     * Import denoms from Digiflazz to PriceList
     */
    public function importDenoms($gameName = null)
    {
        $priceList = $this->getPriceList();
        $importedCount = 0;
        $errors = [];

        foreach ($priceList as $item) {
            try {
                // Filter by game name if provided
                if ($gameName && stripos($item['name'], $gameName) === false) {
                    continue;
                }

                // Find or create product
                $product = \App\Models\Produk::where('product_name', $item['name'])->first();
                
                if (!$product) {
                    // Create product if it doesn't exist
                    $product = \App\Models\Produk::create([
                        'product_name' => $item['name'],
                        'product_description' => $item['desc'] ?? '',
                        'product_image' => $item['icon_url'] ?? 'default-game.jpg',
                        'is_active' => 1,
                        'digiflazz_id' => $item['buyer_sku_code'] ?? null,
                    ]);
                }

                // Create or update price list item
                \App\Models\PriceList::updateOrCreate(
                    [
                        'kode_produk' => $item['buyer_sku_code'],
                        'product_id' => $product->product_id,
                    ],
                    [
                        'nama_produk' => $item['name'],
                        'harga_beli' => $item['price'] ?? 0,
                        'harga_jual' => ($item['price'] ?? 0) + 1000, // Add 1000 profit
                        'denom' => $item['desc'] ?? null,
                        'provider' => 'Digiflazz',
                        'is_active' => 1,
                    ]
                );
                
                $importedCount++;
            } catch (\Exception $e) {
                $errors[] = "Error importing {$item['name']}: " . $e->getMessage();
            }
        }

        return [
            'imported_count' => $importedCount,
            'errors' => $errors
        ];
    }

    /**
     * Get denoms for specific game
     */
    public function getGameDenoms($gameName)
    {
        $priceList = $this->getPriceList();
        $gameDenoms = [];

        foreach ($priceList as $item) {
            if (stripos($item['name'], $gameName) !== false) {
                $gameDenoms[] = $item;
            }
        }

        return $gameDenoms;
    }
} 