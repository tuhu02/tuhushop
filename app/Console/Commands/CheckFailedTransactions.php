<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;

class CheckFailedTransactions extends Command
{
    protected $signature = 'transaction:check-failed';
    protected $description = 'Check for failed transactions that need to be retried';

    public function handle()
    {
        $this->info('Checking for failed transactions...');
        
        $failedTransactions = Transaction::where('transaction_status', Transaction::STATUS_FAILED)
            ->where('payment_status', Transaction::PAYMENT_PAID)
            ->get();
        
        if ($failedTransactions->isEmpty()) {
            $this->info('No failed transactions found!');
            return 0;
        }
        
        $this->info('Found ' . $failedTransactions->count() . ' failed transactions:');
        
        foreach ($failedTransactions as $transaction) {
            $this->line("Order ID: {$transaction->order_id}");
            $this->line("Amount: Rp " . number_format($transaction->amount, 0, ',', '.'));
            $this->line("User ID Game: {$transaction->user_id_game}");
            $this->line("Notes: {$transaction->notes}");
            $this->line("Created: {$transaction->created_at}");
            $this->line("---");
        }
        
        return 0;
    }
}
