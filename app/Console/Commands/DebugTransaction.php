<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\PriceList;

class DebugTransaction extends Command
{
    protected $signature = 'debug:transaction {order_id}';
    protected $description = 'Debug transaction data for a specific order ID';

    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        $transaction = Transaction::where('order_id', $orderId)->first();
        
        if (!$transaction) {
            $this->error("Transaction with order_id {$orderId} not found!");
            return 1;
        }

        $this->info("=== Transaction Debug Info ===");
        $this->info("Order ID: {$transaction->order_id}");
        $this->info("Status: {$transaction->transaction_status}");
        $this->info("Payment Status: {$transaction->payment_status}");
        $this->info("User ID Game: {$transaction->user_id_game}");
        $this->info("Server ID: {$transaction->server_id}");
        
        $this->info("\n=== Metadata ===");
        $this->info(json_encode($transaction->metadata, JSON_PRETTY_PRINT));
        
        $this->info("\n=== PriceList Relationship ===");
        $priceList = $transaction->priceList;
        if ($priceList) {
            $this->info("✅ PriceList found!");
            $this->info("ID: {$priceList->id}");
            $this->info("Nama Produk: {$priceList->nama_produk}");
            $this->info("Kode Digiflazz: {$priceList->kode_digiflazz}");
        } else {
            $this->error("❌ PriceList not found!");
            
            // Check if denom_id exists in metadata
            $denomId = $transaction->metadata['denom_id'] ?? null;
            if ($denomId) {
                $this->info("Denom ID from metadata: {$denomId}");
                $priceListDirect = PriceList::find($denomId);
                if ($priceListDirect) {
                    $this->info("✅ PriceList found by direct query!");
                    $this->info("ID: {$priceListDirect->id}");
                    $this->info("Nama Produk: {$priceListDirect->nama_produk}");
                    $this->info("Kode Digiflazz: {$priceListDirect->kode_digiflazz}");
                } else {
                    $this->error("❌ PriceList not found by direct query either!");
                }
            } else {
                $this->error("❌ No denom_id in metadata!");
            }
        }

        return 0;
    }
} 