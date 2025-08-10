<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\PriceList;
use App\Models\Transaction;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ProcessTransaction;
// use Midtrans\Snap;
// use Midtrans\Config;
use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    public function index() { return abort(404); }

    public function showProduct($productId) { return abort(404); }

    public function showCategory($categoryId) { return abort(404); }

    public function checkout(Request $request)
    {
        // 1. Validasi input untuk memastikan semua data aman dan bertipe string
        $validatedData = $request->validate([
            'denom_id'       => 'required|integer|exists:price_lists,id',
            'email'          => 'required|email',
            'user_id'        => 'required|string',
            'server'         => 'nullable|string', // <-- Ini kunci perbaikannya
            'payment_method' => 'required|string',
        ]);
    
        // 2. Ambil data denom
        $denom = PriceList::findOrFail($validatedData['denom_id']);
        $orderId = 'ORDER-' . uniqid();
    
        // 3. Simpan transaksi dengan data yang sudah divalidasi
        $trx = Transaction::create([
            'order_id'           => $orderId,
            'transaction_code'   => 'TRX-' . uniqid(),
            'amount'             => $denom->harga_jual ?? $denom->harga,
            'payment_status'     => 'pending',
            'transaction_status' => 'pending',
            'payment_method'     => $validatedData['payment_method'],
            'user_id'            => Auth::id(),
            'game_id'            => $denom->product_id,
            'user_id_game'       => $validatedData['user_id'],
            'server_id'          => $validatedData['server'] ?? null, // <-- Menggunakan data yang sudah aman
            'player_id'          => $validatedData['user_id'],
            'player_name'        => 'Player-' . $validatedData['user_id'],
            'metadata'           => [
                'denom_id'       => $denom->id,
                'email'          => $validatedData['email'],
                'user_id_game'   => $validatedData['user_id'],
                'server'         => $validatedData['server'] ?? null, // <-- Menggunakan data yang sudah aman
                'payment_method' => $validatedData['payment_method'],
            ],
        ]);
    
        // 4. Redirect ke halaman payment untuk melakukan pembayaran
        return redirect()->route('payment', ['orderId' => $orderId]);
    }

    public function invoice($orderId)
    {
        $trx = Transaction::where('order_id', $orderId)->firstOrFail();
        $snapToken = null;
        $midtransDetail = null;

        // Ambil data produk
        $product = Produk::find($trx->game_id);
        
        // Ambil data denom yang dipilih
        $selectedDenom = null;
        if (isset($trx->metadata['denom_id'])) {
            $selectedDenom = PriceList::find($trx->metadata['denom_id']);
        }

        if ($trx->payment_status === 'pending') {
            try {
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.3ds');
                
                // Konfigurasi metode pembayaran berdasarkan pilihan user
                $paymentMethod = $trx->payment_method ?? $trx->metadata['payment_method'] ?? '';
                $enabledPayments = [];
                
                // Log untuk debugging
                \Log::info('Payment method selected: ' . $paymentMethod);
                
                // Mapping metode pembayaran ke kode Midtrans
                switch (strtolower($paymentMethod)) {
                    case 'gopay':
                    case 'gopay/gopay later':
                        $enabledPayments = ['gopay'];
                        break;
                    case 'qris':
                    case 'qr code':
                    case 'qr':
                        $enabledPayments = ['gopay', 'qris']; // Tambahkan qris juga
                        break;
                    case 'shopeepay':
                        $enabledPayments = ['shopeepay'];
                        break;
                    case 'ovo':
                        $enabledPayments = ['ovo'];
                        break;
                    case 'dana':
                        $enabledPayments = ['dana'];
                        break;
                    case 'linkaja':
                        $enabledPayments = ['linkaja'];
                        break;
                    case 'bca va':
                    case 'bca virtual account':
                        $enabledPayments = ['bca_va'];
                        break;
                    case 'mandiri va':
                    case 'mandiri virtual account':
                        $enabledPayments = ['mandiri_va'];
                        break;
                    case 'bni va':
                    case 'bni virtual account':
                        $enabledPayments = ['bni_va'];
                        break;
                    case 'bri va':
                    case 'bri virtual account':
                        $enabledPayments = ['bri_va'];
                        break;
                    case 'permata va':
                    case 'permata virtual account':
                        $enabledPayments = ['permata_va'];
                        break;
                    case 'bca klikpay':
                        $enabledPayments = ['bca_klikpay'];
                        break;
                    case 'bca klikbca':
                        $enabledPayments = ['bca_klikbca'];
                        break;
                    case 'mandiri clickpay':
                        $enabledPayments = ['mandiri_clickpay'];
                        break;
                    case 'danamon online':
                        $enabledPayments = ['danamon_online'];
                        break;
                    case 'akulaku':
                        $enabledPayments = ['akulaku'];
                        break;
                    case 'kredivo':
                        $enabledPayments = ['kredivo'];
                        break;
                    case 'uob ezpay':
                        $enabledPayments = ['uob_ezpay'];
                        break;
                    case 'indomaret':
                        $enabledPayments = ['indomaret'];
                        break;
                    case 'alfamart':
                        $enabledPayments = ['alfamart'];
                        break;
                    case 'credit card':
                    case 'creditcard':
                        $enabledPayments = ['credit_card'];
                        break;
                    default:
                        // Jika metode tidak dikenali, tampilkan semua metode
                        $enabledPayments = [
                            'gopay', 'shopeepay', 'ovo', 'dana', 'linkaja',
                            'bca_va', 'mandiri_va', 'bni_va', 'bri_va', 'permata_va',
                            'bca_klikpay', 'bca_klikbca', 'mandiri_clickpay',
                            'danamon_online', 'akulaku', 'kredivo', 'uob_ezpay',
                            'indomaret', 'alfamart', 'credit_card'
                        ];
                        \Log::warning('Unknown payment method: ' . $paymentMethod . ', showing all methods');
                        break;
                }
                
                \Log::info('Enabled payments: ' . json_encode($enabledPayments));
                
                // Konfigurasi Midtrans yang akan dikirim
                $midtransConfig = [
                    'transaction_details' => [
                        'order_id' => $trx->order_id,
                        'gross_amount' => $trx->amount,
                    ],
                    'customer_details' => [
                        'email' => $trx->metadata['email'] ?? '-',
                    ],
                    'enabled_payments' => $enabledPayments,
                    'credit_card' => [
                        'secure' => true,
                    ],
                    'callbacks' => [
                        'finish' => route('payment.success', ['orderId' => $trx->order_id]),
                        'error' => route('payment.failed', ['orderId' => $trx->order_id]),
                        'pending' => route('invoice', ['orderId' => $trx->order_id]),
                    ],
                    'snap_options' => [
                        'enabled_payments' => $enabledPayments,
                        'disable_retry' => true,
                        'disable_auto_redirect' => true,
                    ]
                ];
                
                // Jika hanya satu metode pembayaran, coba pendekatan yang berbeda
                if (count($enabledPayments) === 1) {
                    $midtransConfig['enabled_payments'] = $enabledPayments;
                    $midtransConfig['snap_options']['enabled_payments'] = $enabledPayments;
                    
                    // Tambahkan parameter untuk memaksa hanya menampilkan metode yang dipilih
                    if ($enabledPayments[0] === 'gopay') {
                        $midtransConfig['enabled_payments'] = ['gopay'];
                        $midtransConfig['snap_options']['enabled_payments'] = ['gopay'];
                        // Tambahkan parameter untuk memaksa hanya GoPay
                        $midtransConfig['gopay'] = [
                            'enable_callback' => true,
                            'callback_url' => route('payment.success', ['orderId' => $trx->order_id])
                        ];
                    }
                }
                
                \Log::info('Midtrans config: ' . json_encode($midtransConfig));
                
                $snapToken = \Midtrans\Snap::getSnapToken($midtransConfig);
            } catch (\Exception $e) {
                $snapToken = null;
            }
        }

        // Ambil status transaksi dari Midtrans
        try {
            $midtransDetail = \Midtrans\Transaction::status($trx->order_id);
        } catch (\Exception $e) {
            $midtransDetail = null;
        }

        return view('customer.invoice', compact('trx', 'snapToken', 'midtransDetail', 'selectedDenom', 'product'));
    }

    public function payment($orderId)
    {
        $trx = Transaction::where('order_id', $orderId)->firstOrFail();
        $snapToken = null;
        
        // Ambil data produk
        $product = Produk::find($trx->game_id);
        
        // Ambil data denom yang dipilih
        $selectedDenom = null;
        if (isset($trx->metadata['denom_id'])) {
            $selectedDenom = PriceList::find($trx->metadata['denom_id']);
        }

        if ($trx->payment_status === 'pending') {
            try {
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.3ds');
                
                // Konfigurasi metode pembayaran berdasarkan pilihan user
                $paymentMethod = $trx->payment_method ?? $trx->metadata['payment_method'] ?? '';
                $enabledPayments = [];
                
                // Log untuk debugging
                \Log::info('Payment method selected: ' . $paymentMethod);
                
                // Mapping metode pembayaran ke kode Midtrans
                switch (strtolower($paymentMethod)) {
                    case 'gopay':
                    case 'gopay/gopay later':
                        $enabledPayments = ['gopay'];
                        break;
                    case 'qris':
                    case 'qr code':
                    case 'qr':
                        $enabledPayments = ['gopay', 'qris']; // Tambahkan qris juga
                        break;
                    case 'shopeepay':
                        $enabledPayments = ['shopeepay'];
                        break;
                    case 'ovo':
                        $enabledPayments = ['ovo'];
                        break;
                    case 'dana':
                        $enabledPayments = ['dana'];
                        break;
                    case 'linkaja':
                        $enabledPayments = ['linkaja'];
                        break;
                    case 'bca va':
                    case 'bca virtual account':
                        $enabledPayments = ['bca_va'];
                        break;
                    case 'mandiri va':
                    case 'mandiri virtual account':
                        $enabledPayments = ['mandiri_va'];
                        break;
                    case 'bni va':
                    case 'bni virtual account':
                        $enabledPayments = ['bni_va'];
                        break;
                    case 'bri va':
                    case 'bri virtual account':
                        $enabledPayments = ['bri_va'];
                        break;
                    case 'permata va':
                    case 'permata virtual account':
                        $enabledPayments = ['permata_va'];
                        break;
                    case 'bca klikpay':
                        $enabledPayments = ['bca_klikpay'];
                        break;
                    case 'bca klikbca':
                        $enabledPayments = ['bca_klikbca'];
                        break;
                    case 'mandiri clickpay':
                        $enabledPayments = ['mandiri_clickpay'];
                        break;
                    case 'danamon online':
                        $enabledPayments = ['danamon_online'];
                        break;
                    case 'akulaku':
                        $enabledPayments = ['akulaku'];
                        break;
                    case 'kredivo':
                        $enabledPayments = ['kredivo'];
                        break;
                    case 'uob ezpay':
                        $enabledPayments = ['uob_ezpay'];
                        break;
                    case 'indomaret':
                        $enabledPayments = ['indomaret'];
                        break;
                    case 'alfamart':
                        $enabledPayments = ['alfamart'];
                        break;
                    case 'credit card':
                    case 'creditcard':
                        $enabledPayments = ['credit_card'];
                        break;
                    default:
                        // Jika metode tidak dikenali, tampilkan semua metode
                        $enabledPayments = [
                            'gopay', 'shopeepay', 'ovo', 'dana', 'linkaja',
                            'bca_va', 'mandiri_va', 'bni_va', 'bri_va', 'permata_va',
                            'bca_klikpay', 'bca_klikbca', 'mandiri_clickpay',
                            'danamon_online', 'akulaku', 'kredivo', 'uob_ezpay',
                            'indomaret', 'alfamart', 'credit_card'
                        ];
                        \Log::warning('Unknown payment method: ' . $paymentMethod . ', showing all methods');
                        break;
                }
                
                \Log::info('Enabled payments: ' . json_encode($enabledPayments));
                
                // Konfigurasi Midtrans yang akan dikirim
                $midtransConfig = [
                    'transaction_details' => [
                        'order_id' => $trx->order_id,
                        'gross_amount' => $trx->amount,
                    ],
                    'customer_details' => [
                        'email' => $trx->metadata['email'] ?? '-',
                    ],
                    'enabled_payments' => $enabledPayments,
                    'credit_card' => [
                        'secure' => true,
                    ],
                    'callbacks' => [
                        'finish' => route('payment.success', ['orderId' => $trx->order_id]),
                        'error' => route('payment.failed', ['orderId' => $trx->order_id]),
                        'pending' => route('invoice', ['orderId' => $trx->order_id]),
                    ],
                    'snap_options' => [
                        'enabled_payments' => $enabledPayments,
                        'disable_retry' => true,
                        'disable_auto_redirect' => true,
                    ]
                ];
                
                // Jika hanya satu metode pembayaran, coba pendekatan yang berbeda
                if (count($enabledPayments) === 1) {
                    $midtransConfig['enabled_payments'] = $enabledPayments;
                    $midtransConfig['snap_options']['enabled_payments'] = $enabledPayments;
                    
                    // Tambahkan parameter untuk memaksa hanya menampilkan metode yang dipilih
                    if ($enabledPayments[0] === 'gopay') {
                        $midtransConfig['enabled_payments'] = ['gopay'];
                        $midtransConfig['snap_options']['enabled_payments'] = ['gopay'];
                        // Tambahkan parameter untuk memaksa hanya GoPay
                        $midtransConfig['gopay'] = [
                            'enable_callback' => true,
                            'callback_url' => route('payment.success', ['orderId' => $trx->order_id])
                        ];
                    }
                }
                
                \Log::info('Midtrans config: ' . json_encode($midtransConfig));
                
                $snapToken = \Midtrans\Snap::getSnapToken($midtransConfig);
            } catch (\Exception $e) {
                \Log::error('Midtrans error: ' . $e->getMessage());
                $snapToken = null;
            }
        }

        return view('customer.payment', compact('trx', 'product', 'snapToken', 'selectedDenom'));
    }

    public function paymentSuccess($orderId)
    {
        $trx = Transaction::where('order_id', $orderId)->firstOrFail();
        
        // Update status pembayaran
        $trx->update([
            'payment_status' => 'paid',
            'transaction_status' => 'processing'
        ]);
        
        // Dispatch ProcessTransaction job
        ProcessTransaction::dispatch($trx);

        return redirect()->route('invoice', ['orderId' => $orderId]);
    }

    public function paymentFailed($orderId)
    {
        $trx = Transaction::where('order_id', $orderId)->firstOrFail();
        
        // Update status pembayaran
        $trx->update([
            'payment_status' => 'failed',
            'transaction_status' => 'failed'
        ]);
        
        return redirect()->route('invoice', ['orderId' => $orderId]);
    }

    public function checkDigiflazzStatus($orderId)
    {
        $trx = Transaction::where('order_id', $orderId)->firstOrFail();
        
        try {
            // Cek status dari Digiflazz
            $response = Http::post(config('services.digiflazz.base_url') . '/transaction', [
                'username' => config('services.digiflazz.username'),
                'ref_id' => $trx->order_id,
                'sign' => md5(config('services.digiflazz.username') . config('services.digiflazz.api_key') . $trx->order_id)
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['data'])) {
                    $status = strtolower($responseData['data']['status'] ?? '');
                    $serialNumber = $responseData['data']['sn'] ?? null;
                    
                    // Jika ada serial number, maka transaksi berhasil meskipun status pending
                    $isSuccessful = ($status === 'sukses') || 
                                   ($status === 'success') || 
                                   ($status === 'pending' && !empty($serialNumber));
                    
                    if (in_array($status, ['sukses', 'success', 'pending'])) {
                        $finalStatus = $isSuccessful ? 'success' : 'processing';
                        
                        $trx->update([
                            'transaction_status' => $finalStatus,
                            'metadata' => array_merge($trx->metadata ?? [], [
                                'digiflazz_response' => $responseData['data']
                            ])
                        ]);
                        
                        return response()->json([
                            'success' => true,
                            'status' => $finalStatus,
                            'data' => $responseData['data']
                        ]);
                    } else {
                        $trx->update([
                            'transaction_status' => 'failed',
                            'metadata' => array_merge($trx->metadata ?? [], [
                                'error' => $responseData['data']['message'] ?? 'Transaction failed'
                            ])
                        ]);
                        
                        return response()->json([
                            'success' => false,
                            'status' => 'failed',
                            'message' => $responseData['data']['message'] ?? 'Transaction failed'
                        ]);
                    }
                }
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to check status from Digiflazz'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function search(Request $request) { return abort(404); }
} 