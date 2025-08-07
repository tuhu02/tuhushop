<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\PriceList;

class CheckTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:check {orderId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check transaction details and related data';

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
        
        $this->info('Transaction Details:');
        $this->table(['Field', 'Value'], [
            ['Order ID', $transaction->order_id],
            ['Payment Status', $transaction->payment_status],
            ['Transaction Status', $transaction->transaction_status],
            ['Amount', 'Rp ' . number_format($transaction->amount, 0, ',', '.')],
            ['User ID Game', $transaction->user_id_game],
            ['Server ID', $transaction->server_id ?? 'N/A'],
            ['User ID', $transaction->user_id ?? 'N/A'],
        ]);
        
        if (isset($transaction->metadata['denom_id'])) {
            $denomId = $transaction->metadata['denom_id'];
            $denom = PriceList::find($denomId);
            
            if ($denom) {
                $this->info('Denom Details:');
                $this->table(['Field', 'Value'], [
                    ['ID', $denom->id],
                    ['Product Name', $denom->nama_produk],
                    ['Digiflazz Code', $denom->kode_digiflazz ?? 'NOT SET'],
                    ['Price', 'Rp ' . number_format($denom->harga, 0, ',', '.')],
                ]);
            } else {
                $this->error('Denom not found for ID: ' . $denomId);
            }
        } else {
            $this->error('Denom ID not found in metadata!');
        }
        
        if ($transaction->user) {
            $this->info('User Details:');
            $this->table(['Field', 'Value'], [
                ['ID', $transaction->user->id],
                ['Name', $transaction->user->name],
                ['Email', $transaction->user->email],
            ]);
        } else {
            $this->warn('User not found for transaction!');
        }
        
        return 0;
    }
} 