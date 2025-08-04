<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\PriceList;
use App\Models\KategoriDenom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProdukController extends Controller
{
    /**
     * Proses pembelian produk Digiflazz
     */
    public function buyDigiflazz(Request $request, $product_id)
    {
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        $baseUrl = config('services.digiflazz.base_url');

        // Validasi input
        $request->validate([
            'buyer_sku_code' => 'required|string',
            'customer_no' => 'required|string',
        ]);

        $buyerSku = $request->input('buyer_sku_code');
        $customerNo = $request->input('customer_no');
        $refId = uniqid('trx_');
        $sign = md5($username . $apiKey . $refId);

        // Kirim request ke Digiflazz
        $response = Http::post($baseUrl . '/transaction', [
            'username' => $username,
            'buyer_sku_code' => $buyerSku,
            'customer_no' => $customerNo,
            'ref_id' => $refId,
            'sign' => $sign,
        ]);

        // Log respons untuk debugging
        \Log::info('Digiflazz Buy Response', [
            'request' => [
                'buyer_sku_code' => $buyerSku,
                'customer_no' => $customerNo,
                'ref_id' => $refId,
                'sign' => $sign,
            ],
            'response' => $response->json(),
        ]);

        return response()->json($response->json());
    }
    public function showPublic($product_id)
    {
        // Ambil produk berdasarkan product_id
        $product = Produk::where('product_id', $product_id)->first();
        
        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        // Ambil kategori denom yang memiliki price list untuk produk ini
        $kategoriDenoms = KategoriDenom::whereHas('denoms', function($query) use ($product) {
            $query->where('product_id', $product->product_id);
        })->orderBy('sort_order', 'asc')->get();
        
        // Ambil kategori aktif dari query parameter, default ke kategori pertama
        $kategoriAktif = request('kategori', $kategoriDenoms->first()->slug ?? 'diamond');
        
        // Filter denom berdasarkan kategori aktif
        $filteredDenoms = PriceList::where('product_id', $product->product_id)
            ->whereHas('kategoriDenom', function($query) use ($kategoriAktif) {
                $query->where('slug', $kategoriAktif);
            })
            ->orderBy('sort_order', 'asc')
            ->get();

        // Ambil semua game untuk rekomendasi
        $allGame = Produk::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->limit(10)
            ->get();

        // Parse account fields dari JSON
        $accountFields = [];
        if (!empty($product->account_fields)) {
            // Jika account_fields sudah berupa array (karena cast), gunakan langsung
            if (is_array($product->account_fields)) {
                $accountFields = $product->account_fields;
            } else {
                // Jika masih string JSON, decode
                $accountFields = json_decode($product->account_fields, true) ?? [];
            }
        }

        return view('customer.product', compact(
            'product',
            'kategoriDenoms',
            'kategoriAktif',
            'filteredDenoms',
            'allGame',
            'accountFields'
        ));
    }

    public function cekMLBBUsername(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'user_id' => 'required|string',
                'server' => 'required|string'
            ]);

            // Ambil data dari request
            $userId = $request->input('user_id');
            $serverId = $request->input('server');
            
            // Log untuk debugging
            \Log::info('MLBB Username Check', [
                'user_id' => $userId,
                'server' => $serverId,
                'request_data' => $request->all()
            ]);
            
            // Validasi tambahan
            if (empty($userId) || empty($serverId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID dan Server ID harus diisi'
                ], 400);
            }
            
            // Pengecekan nickname MLBB yang sebenarnya
            // Menggunakan API MLBB atau service yang sesuai
            $nickname = $this->checkMLBBNickname($userId, $serverId);
            if (is_array($nickname) && isset($nickname['error_response'])) {
                return response()->json([
                    'success' => false,
                    'nickname' => null,
                    'message' => 'Nickname tidak ditemukan atau server sedang maintenance',
                    'digiflazz_response' => $nickname['error_response'],
                    'user_id' => $userId,
                    'server' => $serverId
                ], 404);
            }
            if ($nickname) {
                return response()->json([
                    'success' => true,
                    'nickname' => $nickname,
                    'user_id' => $userId,
                    'server' => $serverId
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'nickname' => null,
                    'message' => 'Nickname tidak ditemukan atau server sedang maintenance',
                    'user_id' => $userId,
                    'server' => $serverId
                ], 404);
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', $e->errors())
            ], 422);
        } catch (\Exception $e) {
            \Log::error('MLBB Username Check Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek nickname: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Method untuk mengecek nickname MLBB yang sebenarnya
     */
    private function checkMLBBNickname($userId, $serverId)
    {
        try {
            $username = config('services.digiflazz.username');
            $apiKey = config('services.digiflazz.api_key');
            $baseUrl = config('services.digiflazz.base_url');
            $customerNo = $userId . $serverId;
            $refId = uniqid('cekmlbb_');
            $sign = md5($username . $apiKey . $refId);

            $response = Http::post($baseUrl . '/cek-username', [
                'username' => $username,
                'customer_no' => $customerNo,
                'ref_id' => $refId,
                'sign' => $sign,
            ]);

            \Log::info('Digiflazz cek-username response', [
                'request' => [
                    'username' => $username,
                    'customer_no' => $customerNo,
                    'ref_id' => $refId,
                    'sign' => $sign,
                ],
                'response' => $response->json(),
            ]);

            // Untuk debugging, return response full jika gagal
            if ($response->successful() && isset($response['data']['username'])) {
                return $response['data']['username'];
            }

            // Jika gagal, return array response agar bisa ditampilkan di frontend
            return ['error_response' => $response->json()];
        } catch (\Exception $e) {
            \Log::error('MLBB Digiflazz API Error', [
                'error' => $e->getMessage(),
                'user_id' => $userId,
                'server_id' => $serverId
            ]);
            return null;
        }
    }

    /**
     * Simulasi nickname MLBB (fallback jika API tidak tersedia)
     */
    private function simulateMLBBNickname($userId, $serverId)
    {
        // Simulasi yang lebih realistis
        $nicknames = [
            'ProPlayer', 'MLBBKing', 'DiamondHunter', 'EpicGamer', 'LegendPlayer',
            'MobileHero', 'BattleRoyale', 'ArenaChampion', 'VictorySeeker', 'ElitePlayer',
            'MasterGamer', 'DiamondCollector', 'EpicWarrior', 'LegendaryHero', 'ProGamer'
        ];
        
        // Gunakan user_id untuk menentukan nickname yang konsisten
        $index = abs(crc32($userId)) % count($nicknames);
        $baseNickname = $nicknames[$index];
        
        // Tambahkan angka random untuk membuat lebih realistis
        $randomNumber = rand(100, 999);
        
        return $baseNickname . $randomNumber;
    }
}