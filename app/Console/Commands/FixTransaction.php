<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Jobs\ProcessTransaction;

class FixTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:fix {orderId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix a failed transaction by re-running the ProcessTransaction job';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('orderId');
        
        $this->info('Checking transaction: ' . $orderId);
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error('Transaction not found!');
            return 1;
        }
        
        $this->info('Transaction found:');
        $this->table(['Field', 'Value'], [
            ['Order ID', $transaction->order_id],
            ['Payment Status', $transaction->payment_status],
            ['Transaction Status', $transaction->transaction_status],
            ['Amount', 'Rp ' . number_format($transaction->amount, 0, ',', '.')],
            ['User ID Game', $transaction->user_id_game],
            ['Denom ID', $transaction->metadata['denom_id'] ?? 'N/A'],
        ]);
        
        if ($transaction->payment_status !== 'paid') {
            $this->error('Payment not completed yet!');
            return 1;
        }
        
        if ($transaction->transaction_status === 'success') {
            $this->info('✅ Transaction already successful!');
            return 0;
        }
        
        $this->info('Re-running ProcessTransaction job...');
        
        // Reset transaction status to pending
        $transaction->update([
            'transaction_status' => 'pending'
        ]);
        
        // Dispatch the job again
        ProcessTransaction::dispatch($transaction);
        
        $this->info('✅ ProcessTransaction job dispatched!');
        $this->info('Check the queue worker to see if it processes successfully.');
        
        return 0;
    }
} 