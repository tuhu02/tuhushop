<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\PriceList;
use App\Models\Transaction;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;

class CustomerController extends Controller
{
    public function index() { return abort(404); }

    public function showProduct($productId) { return abort(404); }

    public function showCategory($categoryId) { return abort(404); }

    public function checkout(Request $request)
    {
        // Validasi input
        $request->validate([
            'denom_id' => 'required|integer',
            'email' => 'required|email',
        ]);

        // Ambil data denom
        $denom = PriceList::findOrFail($request->denom_id);
        $orderId = uniqid('ORDER-');

        // Simpan transaksi (opsional, bisa disesuaikan)
        $trx = Transaction::create([
            'order_id' => $orderId,
            'amount' => $denom->harga_jual ?? $denom->harga,
            'payment_status' => 'pending',
            'transaction_status' => 'pending',
            'user_id' => Auth::id(),
            'game_id' => $denom->product_id,
            'metadata' => [
                'denom_id' => $denom->id,
                'email' => $request->email,
            ],
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.sanitized');
        Config::$is3ds = config('midtrans.3ds');

        $channel = $request->input('payment_method');
        $enabledPayments = $channel ? [$channel] : [];

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $denom->harga_jual ?? $denom->harga,
            ],
            'customer_details' => [
                'email' => $request->email,
            ],
            'enabled_payments' => $enabledPayments,
        ];

        $snapToken = Snap::getSnapToken($params);
        return view('customer.payment', compact('snapToken', 'orderId'));
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