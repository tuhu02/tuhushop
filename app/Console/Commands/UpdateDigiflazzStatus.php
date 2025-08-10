<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateDigiflazzStatus extends Command
{
    protected $signature = 'digiflazz:update-status {orderId}';
    protected $description = 'Update Digiflazz status for specific order ID';

    public function handle()
    {
        $orderId = $this->argument('orderId');
        
        $this->info('Updating Digiflazz status for: ' . $orderId);
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error('Transaction not found!');
            return 1;
        }
        
        $this->info('Current transaction status: ' . $transaction->transaction_status);
        
        // Get Digiflazz credentials
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        $baseUrl = config('services.digiflazz.base_url', 'https://api.digiflazz.com/v1');
        
        // Create signature
        $sign = md5($username . $apiKey . $orderId);
        
        try {
            // Check status from Digiflazz
            $this->info('Checking status from Digiflazz...');
            
            $response = Http::timeout(30)->post($baseUrl . '/transaction', [
                'username' => $username,
                'ref_id' => $orderId,
                'sign' => $sign
            ]);
            
            if ($response->successful()) {
                $result = $response->json();
                $data = $result['data'] ?? [];
                
                $this->info('Digiflazz Response:');
                $this->table(['Field', 'Value'], [
                    ['Status', $data['status'] ?? 'N/A'],
                    ['Message', $data['message'] ?? 'N/A'],
                    ['RC', $data['rc'] ?? 'N/A'],
                    ['Customer No', $data['customer_no'] ?? 'N/A'],
                    ['SN', $data['sn'] ?? 'N/A'],
                    ['Price', isset($data['price']) ? 'Rp ' . number_format($data['price'], 0, ',', '.') : 'N/A'],
                ]);
                
                // Update transaction status based on Digiflazz response
                $status = strtolower($data['status'] ?? '');
                $oldStatus = $transaction->transaction_status;
                
                if ($status === 'sukses' || $status === 'success') {
                    $transaction->transaction_status = 'success';
                    $this->info('✅ Status updated to SUCCESS');
                } elseif ($status === 'gagal' || $status === 'failed') {
                    $transaction->transaction_status = 'failed';
                    $this->warn('❌ Status updated to FAILED');
                } elseif ($status === 'pending' || $status === 'processing') {
                    $transaction->transaction_status = 'processing';
                    $this->warn('⏳ Status remains PROCESSING/PENDING');
                } else {
                    $this->warn('⚠️ Unknown status: ' . $status);
                }
                
                // Update metadata
                $transaction->metadata = array_merge($transaction->metadata ?? [], [
                    'digiflazz_response' => $data,
                    'last_status_check' => now()->toISOString()
                ]);
                
                $transaction->save();
                
                $this->info("Status updated from '{$oldStatus}' to '{$transaction->transaction_status}'");
                
                // Log the update
                Log::info('Manual Digiflazz status update', [
                    'order_id' => $orderId,
                    'old_status' => $oldStatus,
                    'new_status' => $transaction->transaction_status,
                    'digiflazz_response' => $data
                ]);
                
            } else {
                $this->error('Failed to get response from Digiflazz');
                $this->error('Status Code: ' . $response->status());
                $this->error('Response: ' . $response->body());
            }
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            Log::error('Manual Digiflazz status update failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
        }
        
        return 0;
    }
}
