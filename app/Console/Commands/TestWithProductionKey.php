<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Services\DigiflazzService;
use Illuminate\Support\Facades\Http;

class TestWithProductionKey extends Command
{
    protected $signature = 'test:production-key {order_id} {production_key}';
    protected $description = 'Test transaction with production key';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        $productionKey = $this->argument('production_key');
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error("Transaction with order_id {$orderId} not found!");
            return 1;
        }

        $this->info("Testing transaction: {$orderId}");
        $this->info("Current status: {$transaction->transaction_status}");
        $this->info("Payment status: {$transaction->payment_status}");

        // Get denom data
        $denom = $transaction->priceList;
        if (!$denom || !$denom->kode_digiflazz) {
            $this->error("❌ SKU DigiFlazz not found!");
            return 1;
        }

        $this->info("✅ PriceList found: {$denom->nama_produk}");
        $this->info("Kode DigiFlazz: {$denom->kode_digiflazz}");

        // Test with production key
        $username = config('services.digiflazz.username');
        $refId = $transaction->order_id;
        $sku = $denom->kode_digiflazz;
        $customerNo = $transaction->user_id_game;
        
        // Test different signature formats
        $signatures = [
            'Username + Production Key + Ref ID' => md5($username . $productionKey . $refId),
            'Production Key + Username + Ref ID' => md5($productionKey . $username . $refId),
            'Ref ID + Username + Production Key' => md5($refId . $username . $productionKey),
        ];

        foreach ($signatures as $format => $signature) {
            $this->info("\n=== Testing {$format} ===");
            $this->info("Signature: {$signature}");
            
            $requestData = [
                'username' => $username,
                'buyer_sku_code' => $sku,
                'customer_no' => $customerNo,
                'ref_id' => $refId,
                'sign' => $signature,
            ];

            try {
                $response = Http::timeout(30)->post('https://api.digiflazz.com/v1/transaction', $requestData);
                
                if ($response->successful()) {
                    $responseData = $response->json();
                    if (isset($responseData['data'])) {
                        $status = strtolower($responseData['data']['status'] ?? '');
                        if (in_array($status, ['sukses', 'pending'])) {
                            $this->info("✅ SUCCESS with {$format}!");
                            $this->info("Response: " . json_encode($responseData['data'], JSON_PRETTY_PRINT));
                            return 0;
                        } else {
                            $this->error("❌ Failed with {$format}: " . ($responseData['data']['message'] ?? 'Unknown error'));
                        }
                    }
                } else {
                    $responseData = $response->json();
                    $errorMessage = $responseData['data']['message'] ?? 'Unknown error';
                    $this->error("❌ HTTP Error with {$format}: {$errorMessage}");
                }
            } catch (\Exception $e) {
                $this->error("❌ Exception with {$format}: " . $e->getMessage());
            }
        }

        $this->error("❌ All signature formats failed!");
        return 1;
    }
} 