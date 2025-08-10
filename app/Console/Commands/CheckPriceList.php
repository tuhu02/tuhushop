<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PriceList;
use App\Models\Transaction;

class CheckPriceList extends Command
{
    protected $signature = 'pricelist:check {kode?}';
    protected $description = 'Check PriceList data for debugging';

    public function handle()
    {
        $kode = $this->argument('kode');
        
        if ($kode) {
            $this->info('Checking PriceList with kode_digiflazz: ' . $kode);
            $items = PriceList::where('kode_digiflazz', $kode)->get();
        } else {
            $this->info('Checking all PriceList items with kode_digiflazz');
            $items = PriceList::whereNotNull('kode_digiflazz')->get();
        }
        
        if ($items->isEmpty()) {
            $this->error('No PriceList items found!');
            return 1;
        }
        
        $this->info('Found ' . $items->count() . ' items:');
        
        foreach ($items as $item) {
            $this->line("ID: {$item->id}");
            $this->line("Name: {$item->nama_produk}");
            $this->line("Kode Digiflazz: {$item->kode_digiflazz}");
            $this->line("Harga Beli: Rp " . number_format($item->harga_beli, 0, ',', '.'));
            $this->line("Harga Jual: Rp " . number_format($item->harga_jual, 0, ',', '.'));
            $this->line("Product ID: {$item->product_id}");
            $this->line("Kategori ID: {$item->kategori_id}");
            $this->line("---");
        }
        
        return 0;
    }
}
