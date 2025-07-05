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
                // Check if game already exists
                $existingGame = \App\Models\Game::where('game_name', $item['name'])->first();
                
                if (!$existingGame) {
                    \App\Models\Game::create([
                        'game_name' => $item['name'],
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
} 