<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\DigiFlazzService; // Kita akan buat service ini nanti
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Validasi Signature Key dari Midtrans
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed !== $request->signature_key) {
            Log::info('Webhook signature tidak valid', ['request' => $request->all()]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Cari Transaksi di Database Anda
        $transaction = Transaction::where('order_id', $request->order_id)->first();
        if (!$transaction) {
            Log::warning('Transaksi tidak ditemukan untuk order_id: ' . $request->order_id);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 3. Hindari Duplikasi Proses
        if ($transaction->payment_status !== 'pending') {
            Log::info('Webhook untuk transaksi yang sudah diproses diterima lagi.', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Transaction already processed']);
        }

        // 4. Proses Status dari Midtrans
        if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
            // Update status pembayaran di database Anda
            $transaction->payment_status = 'success';
            $transaction->save();

            // 5. PICU PEMESANAN KE DIGIFLAZZ!
            try {
                $digiflazzService = new DigiFlazzService();
                $result = $digiflazzService->orderProduct($transaction);
                
                // Simpan hasil dari DigiFlazz ke database Anda
                $transaction->fulfillment_status = $result['status']; // 'success' atau 'failed'
                $transaction->fulfillment_response = $result['data']; // Simpan response lengkap dari DigiFlazz
                $transaction->save();
                
                Log::info('Pesanan DigiFlazz berhasil untuk order_id: ' . $transaction->order_id, ['response' => $result['data']]);

            } catch (\Exception $e) {
                $transaction->fulfillment_status = 'failed';
                $transaction->fulfillment_response = ['error' => $e->getMessage()];
                $transaction->save();
                
                Log::error('Gagal memesan ke DigiFlazz untuk order_id: ' . $transaction->order_id, ['error' => $e->getMessage()]);
            }
        } 
        else if ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
            $transaction->payment_status = 'failed';
            $transaction->transaction_status = 'failed';
            $transaction->save();
            Log::warning('Pembayaran gagal atau dibatalkan untuk order_id: ' . $transaction->order_id);
        }

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}