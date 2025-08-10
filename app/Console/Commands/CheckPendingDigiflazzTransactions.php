<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class CheckPendingDigiflazzTransactions extends Command
{
    protected $signature = 'digiflazz:check-pending';
    protected $description = 'Cek status transaksi Digiflazz yang masih processing/pending dan update otomatis';

    public function handle()
    {
        $pending = Transaction::whereIn('transaction_status', ['processing', 'pending'])->get();
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        $baseUrl = config('services.digiflazz.base_url', 'https://api.digiflazz.com/v1');

        if ($pending->isEmpty()) {
            $this->info('Tidak ada transaksi processing/pending.');
            return 0;
        }

        foreach ($pending as $trx) {
            $sign = md5($username . $apiKey . $trx->order_id);
            $response = Http::post($baseUrl . '/transaction', [
                'username' => $username,
                'ref_id' => $trx->order_id,
                'sign' => $sign
            ]);
            $result = $response->json();
            $data = $result['data'] ?? [];
            $status = strtolower($data['status'] ?? '');
            $serialNumber = $data['sn'] ?? null;

            // Jika ada serial number, maka transaksi berhasil meskipun status pending
            $isSuccessful = ($status === 'sukses') || 
                           ($status === 'success') || 
                           ($status === 'pending' && !empty($serialNumber));

            if ($isSuccessful) {
                $trx->transaction_status = 'success';
            } elseif ($status === 'gagal' || $status === 'failed') {
                $trx->transaction_status = 'failed';
            } elseif ($status === 'pending' || $status === 'processing') {
                $trx->transaction_status = 'processing';
            }
            $trx->metadata = array_merge($trx->metadata ?? [], ['digiflazz_response' => $data]);
            $trx->save();

            $this->info("Order {$trx->order_id} status updated: {$trx->transaction_status}");
        }
        return 0;
    }
}
