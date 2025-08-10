<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Jobs\ProcessTransaction;

class RetryTransaction extends Command
{
    protected $signature = 'transaction:retry {orderId}';
    protected $description = 'Retry a failed transaction';

    public function handle()
    {
        $orderId = $this->argument('orderId');
        
        $this->info('Retrying transaction: ' . $orderId);
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error('Transaction not found!');
            return 1;
        }
        
        if ($transaction->transaction_status === Transaction::STATUS_SUCCESS) {
            $this->warn('Transaction is already successful!');
            return 0;
        }
        
        $this->info('Current status: ' . $transaction->transaction_status);
        
        // Reset the transaction status to processing
        $transaction->update([
            'transaction_status' => Transaction::STATUS_PROCESSING,
            'notes' => null
        ]);
        
        // Dispatch the job again
        ProcessTransaction::dispatch($transaction);
        
        $this->info('Transaction job dispatched successfully!');
        
        return 0;
    }
}
