<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\PriceList;
use App\Models\Transaction;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Auth;
// use Midtrans\Snap;
// use Midtrans\Config;

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
    
        // 4. Redirect ke halaman invoice
        return redirect()->route('invoice', ['orderId' => $orderId]);
    }

    public function invoice($orderId)
    {
        $trx = Transaction::where('order_id', $orderId)->firstOrFail();
        $snapToken = null;
        $midtransDetail = null;

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
                $snapToken = \Midtrans\Snap::getSnapToken([
                    'transaction_details' => [
                        'order_id' => $trx->order_id,
                        'gross_amount' => $trx->amount,
                    ],
                    'customer_details' => [
                        'email' => $trx->metadata['email'] ?? '-',
                    ],
                ]);
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

        return view('customer.invoice', compact('trx', 'snapToken', 'midtransDetail', 'selectedDenom'));
    }

    public function payment($orderId)
    {
        // Ambil Snap Token dari transaksi (atau generate ulang jika perlu)
        // Untuk demo, redirect ke checkout saja
        return redirect()->route('checkout');
    }

    public function paymentSuccess($orderId) { return abort(404); }

    public function paymentFailed($orderId) { return abort(404); }

    public function search(Request $request) { return abort(404); }
} 