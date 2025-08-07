<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Produk;
use App\Models\PriceList;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DigiflazzService
{
    protected $username;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        // Mengambil kredensial dari config/services.php. Pastikan file ini sudah di-setup.
        $this->username = config('services.digiflazz.username');
        $this->apiKey = config('services.digiflazz.api_key');
        $this->baseUrl = config('services.digiflazz.base_url', 'https://api.digiflazz.com/v1');
    }

    /**
     * Make top-up request to Digiflazz
     * @param array $data Request data
     * @return array Response with success status
     */
    public function makeTopUpRequest(array $data)
    {
        try {
            Log::info('Making top-up request to Digiflazz', $data);

            $response = Http::post($this->baseUrl . '/transaction', $data);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['data'])) {
                    $status = strtolower($responseData['data']['status'] ?? '');
                    
                    if (in_array($status, ['sukses', 'pending'])) {
                        Log::info('Top-up request successful', [
                            'ref_id' => $data['ref_id'],
                            'status' => $status,
                            'response' => $responseData['data']
                        ]);
                        
                        return [
                            'success' => true,
                            'data' => $responseData['data']
                        ];
                    } else {
                        Log::error('Top-up request failed', [
                            'ref_id' => $data['ref_id'],
                            'status' => $status,
                            'response' => $responseData['data']
                        ]);
                        
                        return [
                            'success' => false,
                            'message' => $responseData['data']['message'] ?? 'Transaction failed'
                        ];
                    }
                } else {
                    Log::error('Invalid response format from Digiflazz', [
                        'response' => $responseData
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => 'Invalid response from Digiflazz'
                    ];
                }
            } else {
                Log::error('HTTP request failed to Digiflazz', [
                    'status_code' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Failed to connect to Digiflazz'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Exception in makeTopUpRequest', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Membuat signature key yang dinamis untuk setiap request.
     * @param string $refId ID referensi unik untuk request tersebut.
     * @return string
     */
    private function generateSignature($refId)
    {
        return md5($this->username . $this->apiKey . $refId);
    }
    
    // ===================================================================
    // == FUNGSI INTI UNTUK MEMESAN PRODUK ==
    // ===================================================================

    /**
     * Memesan produk ke DigiFlazz setelah pembayaran berhasil.
     * @param Transaction $transaction Transaksi lokal yang sudah tercatat
     * @return array Hasil dari pemesanan
     */
    public function orderProduct(Transaction $transaction)
    {
        // Ambil denom/produk yang dibeli dari relasi
        $denom = $transaction->priceList; 
        if (!$denom || !$denom->sku_digiflazz) {
            Log::error('SKU DigiFlazz tidak ditemukan untuk transaksi', ['order_id' => $transaction->order_id]);
            throw new \Exception('SKU DigiFlazz tidak ditemukan pada data produk.');
        }

        $refId = $transaction->order_id; // Gunakan order_id Anda sebagai ref_id DigiFlazz
        $sku = $denom->sku_digiflazz;
        $customerNo = $transaction->user_id_game;
        
        if (!empty($transaction->server_id)) {
            $customerNo .= $transaction->server_id;
        }

        // Buat signature dinamis khusus untuk transaksi ini
        $signature = $this->generateSignature($refId);

        Log::info('Mengirim pesanan ke DigiFlazz', compact('sku', 'customerNo', 'refId'));

        $response = Http::post($this->baseUrl . '/transaction', [
            'username' => $this->username,
            'buyer_sku_code' => $sku,
            'customer_no' => $customerNo,
            'ref_id' => $refId,
            'sign' => $signature,
        ]);

        $responseData = $response->json()['data'] ?? null;

        if ($response->successful() && isset($responseData['status']) && in_array(strtolower($responseData['status']), ['sukses', 'pending'])) {
            return ['status' => 'success', 'data' => $responseData];
        } else {
            Log::error('Gagal memesan ke DigiFlazz', ['response' => $response->body()]);
            return ['status' => 'failed', 'data' => $responseData ?? ['message' => 'Gagal menghubungi DigiFlazz.']];
        }
    }


    // ===================================================================
    // == FUNGSI-FUNGSI ANDA YANG SUDAH ADA (DENGAN PERBAIKAN) ==
    // ===================================================================
    
    /**
     * Get price list from Digiflazz
     */
    public function getPriceList()
    {
        try {
            $response = Http::post($this->baseUrl . '/price-list', [
                'cmd' => 'prepaid',
                'username' => $this->username,
                'sign' => md5($this->username . $this->apiKey . 'pricelist') // Perbaikan: sign dibuat di sini
            ]);

            if ($response->successful() && isset($response->json()['data'])) {
                return $response->json()['data'];
            }
            
            Log::error('Digiflazz getPriceList Error', ['response' => $response->body()]);
            return [];

        } catch (\Exception $e) {
            Log::error('Digiflazz getPriceList Exception: ' . $e->getMessage());
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
                'sign' => md5($this->username . $this->apiKey . 'pricelist') // Perbaikan: sign dibuat di sini
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
                // Hanya proses item dengan kategori "Games"
                if (strtolower($item['category']) !== 'games') {
                    continue;
                }
                
                // Unik berdasarkan brand/developer
                Produk::updateOrCreate(
                    ['developer' => $item['brand']],
                    [
                        'product_name' => $item['brand'], // Asumsi nama produk sama dengan brand
                        'developer' => $item['brand'],
                        'is_active' => 1,
                        'category' => $item['category'],
                    ]
                );
                $syncedCount++;

            } catch (\Exception $e) {
                $errors[] = "Error syncing brand {$item['brand']}: " . $e->getMessage();
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
    public function importDenoms()
    {
        $priceListFromApi = $this->getPriceList();
        $importedCount = 0;
        $errors = [];

        foreach ($priceListFromApi as $item) {
            try {
                if (strtolower($item['category']) !== 'games' || $item['seller_product_status'] === false) {
                    continue; // Lewati jika bukan game atau produk tidak aktif
                }

                $product = Produk::where('developer', $item['brand'])->first();
                if (!$product) {
                    continue; // Lewati jika brand/game tidak ditemukan di database lokal
                }

                // Buat atau perbarui price list item
                PriceList::updateOrCreate(
                    [
                        'sku_digiflazz' => $item['buyer_sku_code'],
                        'product_id' => $product->product_id,
                    ],
                    [
                        'nama_produk' => $item['product_name'],
                        'harga_beli' => $item['price'],
                        'harga_jual' => $item['price'] + 1000, // Contoh: Markup 1000
                        'provider' => 'Digiflazz',
                        'is_active' => $item['seller_product_status'],
                        // Anda bisa menambahkan kolom lain sesuai kebutuhan
                    ]
                );
                
                $importedCount++;
            } catch (\Exception $e) {
                $errors[] = "Error importing {$item['product_name']}: " . $e->getMessage();
                Log::error("Error importing {$item['product_name']}", ['error' => $e->getMessage()]);
            }
        }

        return [
            'imported_count' => $importedCount,
            'errors' => $errors
        ];
    }
}