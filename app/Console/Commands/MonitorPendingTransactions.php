<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Services\DigiflazzService;

class MonitorPendingTransactions extends Command
{
    protected $signature = 'transaction:monitor-pending';
    protected $description = 'Monitor and update pending transactions from Digiflazz';

    public function handle(DigiflazzService $digiflazzService)
    {
        $this->info('🔍 Monitoring pending transactions...');
        
        // Find transactions that are successful locally but might still be pending in Digiflazz
        $pendingTransactions = Transaction::where('transaction_status', Transaction::STATUS_SUCCESS)
            ->where('payment_status', Transaction::PAYMENT_PAID)
            ->whereJsonContains('metadata->digiflazz_response->status', 'Pending')
            ->get();
        
        if ($pendingTransactions->isEmpty()) {
            $this->info('✅ No pending transactions found!');
            return 0;
        }
        
        $this->info('Found ' . $pendingTransactions->count() . ' pending transactions:');
        $this->newLine();
        
        foreach ($pendingTransactions as $transaction) {
            $this->line("📋 Order ID: {$transaction->order_id}");
            $this->line("💰 Amount: Rp " . number_format($transaction->amount, 0, ',', '.'));
            $this->line("🎮 User ID Game: {$transaction->user_id_game}");
            $this->line("📅 Created: {$transaction->created_at->diffForHumans()}");
            
            // Check current status from Digiflazz
            $this->line("🔄 Checking current status...");
            
            $result = $this->checkTransactionStatus($digiflazzService, $transaction->order_id);
            
            if ($result['success']) {
                $currentStatus = strtolower($result['data']['status'] ?? 'unknown');
                
                switch ($currentStatus) {
                    case 'sukses':
                        $this->line("✅ Status: COMPLETED");
                        if (!empty($result['data']['sn'])) {
                            $this->line("🎫 Serial Number: {$result['data']['sn']}");
                        }
                        break;
                        
                    case 'pending':
                        $this->line("⏳ Status: STILL PENDING");
                        $this->line("ℹ️  This is normal - waiting for game server response");
                        break;
                        
                    case 'gagal':
                        $this->line("❌ Status: FAILED");
                        $this->line("💬 Message: " . ($result['data']['message'] ?? 'No message'));
                        break;
                        
                    default:
                        $this->line("❓ Status: {$currentStatus}");
                }
            } else {
                $this->line("⚠️  Could not check status: {$result['message']}");
            }
            
            $this->line("---");
        }
        
        $this->newLine();
        $this->info('📖 Status Explanation:');
        $this->line('✅ SUKSES    = Transaction completed, diamonds/items delivered');
        $this->line('⏳ PENDING   = Transaction accepted, waiting for game server (NORMAL)');
        $this->line('❌ GAGAL     = Transaction failed, will be refunded');
        
        return 0;
    }
    
    private function checkTransactionStatus(DigiflazzService $digiflazzService, $refId)
    {
        try {
            $username = config('services.digiflazz.username');
            $apiKey = config('services.digiflazz.api_key');
            $baseUrl = config('services.digiflazz.base_url', 'https://api.digiflazz.com/v1');
            
            $signature = md5($username . $apiKey . $refId);
            
            $response = \Illuminate\Support\Facades\Http::timeout(30)->post($baseUrl . '/transaction', [
                'username' => $username,
                'buyer_sku_code' => 'status',
                'customer_no' => $refId,
                'ref_id' => $refId,
                'sign' => $signature,
            ]);
            
            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['data'])) {
                    return [
                        'success' => true,
                        'data' => $responseData['data']
                    ];
                }
            }
            
            return [
                'success' => false,
                'message' => 'Invalid response from Digiflazz'
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection error: ' . $e->getMessage()
            ];
        }
    }
}

