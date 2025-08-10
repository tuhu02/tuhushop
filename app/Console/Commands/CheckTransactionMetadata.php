<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;

class CheckTransactionMetadata extends Command
{
    protected $signature = 'transaction:metadata {orderId}';
    protected $description = 'Check transaction metadata for debugging';

    public function handle()
    {
        $orderId = $this->argument('orderId');
        
        $this->info('Checking metadata for transaction: ' . $orderId);
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error('Transaction not found!');
            return 1;
        }
        
        $this->info('Transaction found. Checking metadata...');
        
        if ($transaction->metadata) {
            $this->info('Metadata:');
            $this->line(json_encode($transaction->metadata, JSON_PRETTY_PRINT));
        } else {
            $this->warn('No metadata found');
        }
        
        if ($transaction->notes) {
            $this->info('Notes: ' . $transaction->notes);
        }
        
        if ($transaction->fulfillment_response) {
            $this->info('Fulfillment Response:');
            $this->line(json_encode($transaction->fulfillment_response, JSON_PRETTY_PRINT));
        }
        
        return 0;
    }
}
