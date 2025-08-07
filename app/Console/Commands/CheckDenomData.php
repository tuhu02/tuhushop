<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PriceList;

class CheckDenomData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'denom:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check denom data with Digiflazz codes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking denom data...');
        
        $denoms = PriceList::whereNotNull('kode_digiflazz')->take(10)->get(['id', 'nama_produk', 'kode_digiflazz']);
        
        if ($denoms->count() === 0) {
            $this->error('No denoms found with kode_digiflazz!');
            return 1;
        }
        
        $this->info('Found ' . $denoms->count() . ' denoms with Digiflazz codes:');
        
        $data = [];
        foreach ($denoms as $denom) {
            $data[] = [
                $denom->id,
                $denom->nama_produk,
                $denom->kode_digiflazz
            ];
        }
        
        $this->table(['ID', 'Product Name', 'Digiflazz Code'], $data);
        
        $this->info('✅ Denom data looks good!');
        return 0;
    }
} 