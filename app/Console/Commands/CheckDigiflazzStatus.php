<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Services\DigiflazzService;
use Illuminate\Support\Facades\Log;

class CheckDigiflazzStatus extends Command
{
    protected $signature = 'digiflazz:check-status {orderId}';
    protected $description = 'Check transaction status from Digiflazz';

    public function handle(DigiflazzService $digiflazzService)
    {
        $orderId = $this->argument('orderId');
        
        $this->info('Checking Digiflazz status for: ' . $orderId);
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error('Transaction not found!');
            return 1;
        }
        
        // Check status from Digiflazz
        $result = $this->checkTransactionStatus($digiflazzService, $orderId);
        
        if ($result['success']) {
            $this->info('Status from Digiflazz:');
            $this->table(['Field', 'Value'], [
                ['Status', $result['data']['status'] ?? 'Unknown'],
                ['Message', $result['data']['message'] ?? 'No message'],
                ['SN', $result['data']['sn'] ?? 'Not available'],
                ['RC', $result['data']['rc'] ?? 'Not available'],
            ]);
            
            // Update local transaction if status changed
            if (isset($result['data']['status'])) {
                $currentStatus = $result['data']['status'];
                
                $transaction->update([
                    'metadata' => array_merge($transaction->metadata ?? [], [
                        'last_status_check' => now()->toISOString(),
                        'digiflazz_status_response' => $result['data']
                    ])
                ]);
                
                if (strtolower($currentStatus) === 'sukses') {
                    $transaction->update([
                        'transaction_status' => Transaction::STATUS_SUCCESS,
                        'notes' => 'Transaction completed successfully'
                    ]);
                    $this->info('✅ Transaction marked as SUCCESS!');
                } elseif (strtolower($currentStatus) === 'gagal') {
                    $transaction->update([
                        'transaction_status' => Transaction::STATUS_FAILED,
                        'notes' => $result['data']['message'] ?? 'Transaction failed'
                    ]);
                    $this->error('❌ Transaction marked as FAILED!');
                } else {
                    $this->warn('⏳ Transaction still PENDING - waiting for completion');
                }
            }
        } else {
            $this->error('Failed to check status: ' . $result['message']);
        }
        
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
            Log::error('Exception in checkTransactionStatus', [
                'error' => $e->getMessage(),
                'ref_id' => $refId
            ]);
            
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ];
        }
    }
}

