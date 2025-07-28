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
        // Validasi input
        $request->validate([
            'denom_id' => 'required|integer',
            'email' => 'required|email',
            'user_id' => 'required|string', // Add validation for user_id
        ]);

        // Ambil data denom
        $denom = PriceList::findOrFail($request->denom_id);
        $orderId = uniqid('ORDER-');

        // Determine user_id - use authenticated user if available, otherwise null for guest users
        $userId = Auth::id(); // This will be null for guest users

        // Handle server field safely
        $serverValue = '';
        if ($request->has('server')) {
            $serverInput = $request->input('server'); // Use input() method to get form field
            if (is_string($serverInput)) {
                $serverValue = $serverInput;
            } elseif (is_object($serverInput)) {
                // If it's an object, try to convert it to string or get a property
                $serverValue = (string) $serverInput;
            } else {
                $serverValue = (string) $serverInput;
            }
        }

        // Simpan transaksi (opsional, bisa disesuaikan)
        $trx = Transaction::create([
            'order_id' => $orderId,
            'transaction_code' => 'TRX-' . uniqid(), // Generate unique transaction code
            'amount' => $denom->harga_jual ?? $denom->harga,
            'payment_status' => 'pending',
            'transaction_status' => 'pending',
            'user_id' => $userId, // This can now be null for guest users
            'game_id' => $denom->product_id,
            'user_id_game' => $request->user_id, // Set the game user_id directly
            'server_id' => $serverValue, // Use the safely handled server value
            'player_id' => $request->user_id, // Use game user_id as player_id
            'player_name' => 'Player-' . $request->user_id, // Generate player name
            'metadata' => [
                'denom_id' => $denom->id,
                'email' => $request->email,
                'user_id_game' => $request->user_id, // Store game user_id in metadata too
                'server' => $serverValue, // Use the safely handled server value
            ],
        ]);

        // Redirect ke halaman invoice
        return redirect()->route('invoice', ['orderId' => $orderId]);
    }

    public function invoice($orderId)
    {
        $trx = Transaction::where('order_id', $orderId)->firstOrFail();
        $snapToken = null;
        $midtransDetail = null;

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

        return view('customer.invoice', compact('trx', 'snapToken', 'midtransDetail'));
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