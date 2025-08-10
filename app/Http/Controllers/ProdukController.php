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
        try {
            // Ambil detail produk untuk identifikasi tipe
            $product = Produk::where('product_id', $product_id)->firstOrFail();
            $username = config('services.digiflazz.username');
            $apiKey = config('services.digiflazz.api_key');
            $baseUrl = config('services.digiflazz.base_url');

            // Validasi input dasar
            $request->validate([
                'buyer_sku_code' => 'required|string',
            ]);

            $buyerSku = $request->input('buyer_sku_code');
            $refId = $request->input('ref_id') ?? uniqid('trx_');
            $testing = $request->input('testing', false);
            $sign = md5($username . $apiKey . $refId);

            // Cek apakah ini produk MLBB dari nama atau kode produk
            $isMLBB = stripos($product->product_name, 'mobile legend') !== false || 
                     stripos($product->product_name, 'mlbb') !== false ||
                     stripos($buyerSku, 'mlbb') !== false;

            if ($isMLBB) {
                // Validasi khusus untuk MLBB
                $request->validate([
                    'user_id' => 'required|string',
                    'server' => 'required|string',
                ]);

                $userId = $request->input('user_id');
                $serverId = $request->input('server');

                // Format MLBB: User ID (Server ID)
                $customerNo = $userId . $serverId;

                // Cek nickname dulu sebelum melakukan pembelian
                $nickname = $this->checkMLBBNickname($userId, $serverId);
                if (!$nickname || (is_array($nickname) && isset($nickname['error_response']))) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User ID atau Server tidak valid. Mohon periksa kembali.',
                    ], 400);
                }
            } else {
                // Untuk produk non-MLBB
                $request->validate([
                    'customer_no' => 'required|string',
                ]);
                $customerNo = $request->input('customer_no');
            }

            // Build payload sesuai dokumentasi
            $payload = [
                'username' => $username,
                'buyer_sku_code' => $buyerSku,
                'customer_no' => $customerNo,
                'ref_id' => $refId,
                'sign' => $sign,
            ];

            if ($testing) {
                $payload['testing'] = true;
            }

            // Dapatkan harga dari price list
            $priceList = PriceList::where('buyer_sku_code', $buyerSku)->first();
            if (!$priceList) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harga produk tidak ditemukan',
                ], 400);
            }

            // Calculate total amount
            $price = $priceList->price;
            $adminFee = $priceList->admin_fee ?? 0;
            $total = $price + $adminFee;

            // Validate minimum balance if needed
            if (auth()->check() && auth()->user()->balance < $total) {
                return response()->json([
                    'success' => false,
                    'message' => 'Saldo tidak mencukupi untuk melakukan pembelian ini'
                ], 400);
            }

            // Create transaction record
            $transaction = \App\Models\Transaction::create([
                'product_id' => $product->id,
                'buyer_sku_code' => $buyerSku,
                'customer_no' => $customerNo,
                'user_id' => $isMLBB ? $request->input('user_id') : null,
                'server_id' => $isMLBB ? $request->input('server') : null,
                'ref_id' => $refId,
                'status' => 'UNPAID',
                'price' => $price,
                'admin' => $adminFee,
                'total' => $total,
                'testing' => $testing,
                'user_id' => auth()->id(), // Save authenticated user ID if available
                'digiflazz_payload' => json_encode($payload), // Save payload for later use
            ]);

            // Setup Midtrans Payment
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->ref_id,
                    'gross_amount' => $transaction->total,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name ?? 'Guest',
                    'email' => auth()->user()->email ?? 'guest@example.com',
                ],
                'item_details' => [
                    [
                        'id' => $product->product_id,
                        'price' => $transaction->price,
                        'quantity' => 1,
                        'name' => $product->product_name,
                    ]
                ]
            ];

            if ($transaction->admin > 0) {
                $params['item_details'][] = [
                    'id' => 'admin_fee',
                    'price' => $transaction->admin,
                    'quantity' => 1,
                    'name' => 'Biaya Admin'
                ];
            }

            try {
                // Dapatkan Snap Token dari Midtrans
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                
                // Update transaction dengan snap token
                $transaction->update(['snap_token' => $snapToken]);

                // Redirect langsung ke halaman pembayaran
                return redirect()->route('payment.show', ['ref_id' => $transaction->ref_id]);

            } catch (\Exception $e) {
                \Log::error('Midtrans Error', ['error' => $e->getMessage()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses pembayaran'
                ], 500);
            }

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Buy Digiflazz Error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memproses pembelian'], 500);
        }
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
            // Jika response error, ambil pesan error yang bisa ditampilkan
            if (is_array($nickname) && isset($nickname['error_response'])) {
                $digiflazz = $nickname['error_response'];
                $errorMsg = isset($digiflazz['data']['message']) ? $digiflazz['data']['message'] : (isset($digiflazz['data']) ? json_encode($digiflazz['data']) : 'Nickname tidak ditemukan atau server sedang maintenance');
                return response()->json([
                    'success' => false,
                    'nickname' => null,
                    'message' => $errorMsg,
                    'user_id' => $userId,
                    'server' => $serverId
                ], 404);
            }
            if ($nickname && is_string($nickname)) {
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

    /**
     * Handle payment notification from Midtrans
     */
    public function handlePaymentNotification(Request $request)
    {
        try {
            $notif = new \Midtrans\Notification();
            
            \Log::info('Payment Notification Received', [
                'order_id' => $notif->order_id,
                'transaction_status' => $notif->transaction_status,
                'fraud_status' => $notif->fraud_status,
                'payment_type' => $notif->payment_type,
                'gross_amount' => $notif->gross_amount
            ]);

            $transaction = \App\Models\Transaction::where('ref_id', $notif->order_id)
                ->lockForUpdate() // Prevent race conditions
                ->firstOrFail();

            // Verify transaction amount
            if ((int)$notif->gross_amount !== (int)$transaction->total) {
                \Log::error('Payment amount mismatch', [
                    'expected' => $transaction->total,
                    'received' => $notif->gross_amount
                ]);
                return response()->json(['status' => 'ERROR', 'message' => 'Amount mismatch'], 400);
            }

            // Update payment details
            $transaction->payment_type = $notif->payment_type;
            $transaction->payment_status = $notif->transaction_status;
            $transaction->payment_time = now();
            $transaction->payment_details = json_encode($notif);
            
            // Log payment status update
            \Log::info('Payment Status Updated', [
                'ref_id' => $transaction->ref_id,
                'old_status' => $transaction->getOriginal('payment_status'),
                'new_status' => $notif->transaction_status,
            ]);

            switch ($notif->transaction_status) {
                case 'capture':
                    if ($notif->fraud_status == 'challenge') {
                        $transaction->status = 'CHALLENGE';
                    } else if ($notif->fraud_status == 'accept') {
                        $this->processDigiflazzTransaction($transaction);
                    }
                    break;
                    
                case 'settlement':
                    $this->processDigiflazzTransaction($transaction);
                    break;
                    
                case 'pending':
                    $transaction->status = 'PENDING';
                    break;
                    
                case 'deny':
                case 'cancel':
                case 'expire':
                    $transaction->status = 'FAILED';
                    // Optionally notify user about failed payment
                    if ($transaction->user_id) {
                        $transaction->user->notify(new \App\Notifications\PaymentFailedNotification($transaction));
                    }
                    break;
                    
                case 'refund':
                    $transaction->status = 'REFUNDED';
                    break;
            }

            $transaction->save();

            \Log::info('Payment Notification Processed', [
                'transaction_id' => $transaction->id,
                'status' => $transaction->status
            ]);
            
            return response()->json(['status' => 'OK']);
            
        } catch (\Exception $e) {
            \Log::error('Payment Notification Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'ERROR', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'OK']);
    }

    /**
     * Process Digiflazz transaction after successful payment
     */
    private function processDigiflazzTransaction($transaction)
    {
        try {
            $username = config('services.digiflazz.username');
            $apiKey = config('services.digiflazz.api_key');
            $baseUrl = config('services.digiflazz.base_url');
            $sign = md5($username . $apiKey . $transaction->ref_id);

            // Build payload untuk Digiflazz
            $payload = [
                'username' => $username,
                'buyer_sku_code' => $transaction->buyer_sku_code,
                'customer_no' => $transaction->customer_no,
                'ref_id' => $transaction->ref_id,
                'sign' => $sign,
            ];

            if ($transaction->testing) {
                $payload['testing'] = true;
            }

            // Kirim request ke Digiflazz
            $response = Http::post($baseUrl . '/transaction', $payload);
            $result = $response->json();

            // Log detail transaksi
            \Log::info('Digiflazz Buy Response', [
                'transaction_id' => $transaction->id,
                'request' => $payload,
                'response' => $result,
            ]);

            // Jika respons gagal, update status jadi FAILED
            if (!$response->successful()) {
                $transaction->status = 'FAILED';
                $transaction->digiflazz_response = $result;
                $transaction->save();
                \Log::error('Digiflazz response not successful', ['response' => $result]);
                return;
            }

            // Update transaction dengan response dari Digiflazz
            $responseData = $result['data'] ?? [];
            $digiflazzStatus = $responseData['status'] ?? null;
            $digiflazzMessage = $responseData['message'] ?? null;

            // Jika status Digiflazz sukses, update jadi SUCCESS
            if (strtolower($digiflazzStatus) === 'sukses' || strtolower($digiflazzStatus) === 'success') {
                $transaction->status = 'SUCCESS';
            } else if (strtolower($digiflazzStatus) === 'pending' || strtolower($digiflazzStatus) === 'processing') {
                $transaction->status = 'PENDING';
            } else {
                $transaction->status = 'FAILED';
            }

            $transaction->sn = $responseData['sn'] ?? null;
            $transaction->digiflazz_status = $digiflazzStatus;
            $transaction->digiflazz_message = $digiflazzMessage;
            $transaction->digiflazz_rc = $responseData['rc'] ?? null;
            $transaction->digiflazz_response = $result;
            $transaction->save();

            \Log::info('Digiflazz transaction status updated', [
                'transaction_id' => $transaction->id,
                'status' => $transaction->status,
                'digiflazz_status' => $digiflazzStatus,
                'digiflazz_message' => $digiflazzMessage,
                'response' => $result
            ]);

            // Kirim notifikasi ke user jika perlu
            if ($transaction->user_id) {
                $transaction->user->notify(new \App\Notifications\TransactionStatusNotification($transaction));
            }

        } catch (\Exception $e) {
            \Log::error('Digiflazz Processing Error', [
                'error' => $e->getMessage(),
                'transaction_id' => $transaction->id
            ]);
            $transaction->status = 'ERROR';
            $transaction->save();
        }
    }

    /**
     * Show payment page
     */
    public function showPayment($ref_id)
    {
        $transaction = \App\Models\Transaction::where('ref_id', $ref_id)
            ->with('product')
            ->firstOrFail();

        // Jika transaksi gagal/cancel/expire, redirect ke produk
        if (in_array($transaction->status, ['FAILED', 'ERROR', 'REFUNDED'])) {
            return redirect()->route('produk.public', ['product_id' => $transaction->product->product_id])
                ->with('error', 'Transaksi sudah gagal/dibatalkan. Silakan lakukan pembelian ulang.');
        }

        // Jika transaksi sudah sukses, redirect ke invoice
        if (in_array($transaction->status, ['SUCCESS', 'PENDING']) && in_array($transaction->payment_status, ['settlement', 'capture'])) {
            return redirect()->route('transaction.invoice', ['ref_id' => $ref_id]);
        }

        // Jika transaksi masih UNPAID, tampilkan halaman pembayaran
        if ($transaction->status === 'UNPAID') {
            return view('customer.payment', [
                'snapToken' => $transaction->snap_token,
                'transaction' => $transaction,
                'product' => $transaction->product
            ]);
        }

        // Default: redirect ke produk jika status tidak dikenali
        return redirect()->route('produk.public', ['product_id' => $transaction->product->product_id])
            ->with('error', 'Status transaksi tidak valid. Silakan lakukan pembelian ulang.');
    }

    /**
     * Show invoice after successful payment
     */
    public function showInvoice($ref_id)
    {
        $transaction = \App\Models\Transaction::where('ref_id', $ref_id)
            ->with('product') // Eager load product
            ->firstOrFail();

        // Cek status pembayaran dan transaksi
        if ($transaction->payment_status !== 'settlement' && $transaction->payment_status !== 'capture') {
            return redirect()->route('payment.show', ['ref_id' => $ref_id])
                ->with('error', 'Silakan selesaikan pembayaran terlebih dahulu');
        }

        if (!in_array($transaction->status, ['SUCCESS', 'PENDING'])) {
            return redirect()->route('produk.public', $transaction->product->product_id)
                ->with('error', 'Invoice hanya tersedia untuk transaksi yang sudah dibayar atau sedang diproses');
        }

        return view('customer.invoice', [
            'product' => $transaction->product,
            'buyerSku' => $transaction->buyer_sku_code,
            'customerNo' => $transaction->customer_no,
            'userId' => $transaction->user_id,
            'serverId' => $transaction->server_id,
            'refId' => $transaction->ref_id,
            'status' => $transaction->status,
            'message' => $transaction->digiflazz_message ?? ($transaction->status === 'SUCCESS' ? 'Pembayaran berhasil' : 'Pembayaran sedang diproses'),
            'sn' => $transaction->sn,
            'price' => $transaction->price,
            'admin' => $transaction->admin,
            'testing' => $transaction->testing,
            'digiflazz_status' => $transaction->digiflazz_status,
            'created_at' => $transaction->created_at,
            'paid_at' => $transaction->updated_at,
        ]);
    }
}