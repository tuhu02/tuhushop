<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Services\DigiflazzService;
use Illuminate\Support\Facades\Log;

class TestTransaction extends Command
{
    protected $signature = 'test:transaction {order_id}';
    protected $description = 'Test transaction processing for a specific order ID';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error("Transaction with order_id {$orderId} not found!");
            return 1;
        }

        $this->info("Testing transaction: {$orderId}");
        $this->info("Current status: {$transaction->transaction_status}");
        $this->info("Payment status: {$transaction->payment_status}");

        // Test Digiflazz connection
        $digiflazzService = new DigiflazzService();
        
        try {
            $this->info("Testing Digiflazz connection...");
            $connectionTest = $digiflazzService->checkConnection();
            
            if ($connectionTest['success']) {
                $this->info("✅ Digiflazz connection successful");
            } else {
                $this->error("❌ Digiflazz connection failed: " . $connectionTest['message']);
                return 1;
            }

            // Test order product
            $this->info("Testing order product...");
            $result = $digiflazzService->orderProduct($transaction);
            
            if ($result['status'] === 'success') {
                $this->info("✅ Order product successful");
                $this->info("Response: " . json_encode($result['data'], JSON_PRETTY_PRINT));
            } else {
                $this->error("❌ Order product failed: " . ($result['data']['message'] ?? 'Unknown error'));
                $this->error("Response: " . json_encode($result['data'], JSON_PRETTY_PRINT));
            }

        } catch (\Exception $e) {
            $this->error("❌ Exception: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
            return 1;
        }

        return 0;
    }
} 