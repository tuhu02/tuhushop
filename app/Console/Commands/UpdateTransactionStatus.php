<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class UpdateTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:update-status {orderId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update transaction status based on Digiflazz response with new logic';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('orderId');
        
        $this->info('Updating transaction status for: ' . $orderId);
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error('Transaction not found!');
            return 1;
        }
        
        $this->info('Current status: ' . $transaction->transaction_status);
        
        try {
            // Check status from Digiflazz
            $response = Http::post(config('services.digiflazz.base_url') . '/transaction', [
                'username' => config('services.digiflazz.username'),
                'ref_id' => $transaction->order_id,
                'sign' => md5(config('services.digiflazz.username') . config('services.digiflazz.api_key') . $transaction->order_id)
            ]);
            
            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['data'])) {
                    $status = strtolower($responseData['data']['status'] ?? '');
                    $serialNumber = $responseData['data']['sn'] ?? null;
                    
                    $this->info('Digiflazz Status: ' . $status);
                    $this->info('Serial Number: ' . ($serialNumber ?: 'None'));
                    
                    // Apply new logic
                    $isSuccessful = ($status === 'sukses') || 
                                   ($status === 'success') || 
                                   ($status === 'pending' && !empty($serialNumber));
                    
                    $this->info('Is Successful: ' . ($isSuccessful ? 'Yes' : 'No'));
                    
                    if (in_array($status, ['sukses', 'success', 'pending'])) {
                        $finalStatus = $isSuccessful ? 'success' : 'processing';
                        
                            $transaction->update([
                            'transaction_status' => $finalStatus,
                            'metadata' => array_merge($transaction->metadata ?? [], [
                                'digiflazz_response' => $responseData['data']
                            ])
                        ]);
                        
                        $this->info('Updated status to: ' . $finalStatus);
                        
                        // Show updated transaction details
                        $this->table(['Field', 'Value'], [
                            ['Order ID', $transaction->order_id],
                            ['Old Status', $transaction->getOriginal('transaction_status')],
                            ['New Status', $transaction->transaction_status],
                            ['Digiflazz Status', $status],
                            ['Serial Number', $serialNumber ?: 'N/A'],
                            ['Is Successful', $isSuccessful ? 'Yes' : 'No']
                        ]);
                        
                    } else {
                            $transaction->update([
                            'transaction_status' => 'failed',
                            'metadata' => array_merge($transaction->metadata ?? [], [
                                'error' => $responseData['data']['message'] ?? 'Transaction failed'
                            ])
                        ]);
                        
                        $this->error('Updated status to: failed');
                    }
                } else {
                    $this->error('Invalid response format from Digiflazz');
                }
            } else {
                $this->error('Failed to get response from Digiflazz');
            }
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}