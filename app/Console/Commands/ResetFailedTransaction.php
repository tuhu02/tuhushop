<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Jobs\ProcessTransaction;

class ResetFailedTransaction extends Command
{
    protected $signature = 'reset:failed-transaction {order_id}';
    protected $description = 'Reset a failed transaction to processing status for retry';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error("Transaction with order_id {$orderId} not found!");
            return 1;
        }

        if ($transaction->transaction_status !== 'failed') {
            $this->error("Transaction is not in failed status!");
            return 1;
        }

        // Reset transaction status
        $transaction->update([
            'transaction_status' => 'processing',
            'notes' => null,
            'metadata' => array_merge($transaction->metadata ?? [], [
                'retry_count' => ($transaction->metadata['retry_count'] ?? 0) + 1,
                'retry_at' => now()->toISOString()
            ])
        ]);

        $this->info("✅ Transaction reset to processing status");
        $this->info("Retry count: " . ($transaction->metadata['retry_count'] ?? 1));

        // Dispatch job to process again
        ProcessTransaction::dispatch($transaction);
        $this->info("✅ Job dispatched for reprocessing");

        return 0;
    }
} 