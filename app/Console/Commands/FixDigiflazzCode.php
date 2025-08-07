<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PriceList;

class FixDigiflazzCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digiflazz:fix-code {denomId} {newCode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix Digiflazz code for a denom';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $denomId = $this->argument('denomId');
        $newCode = $this->argument('newCode');
        
        $this->info('Fixing Digiflazz code for denom ID: ' . $denomId);
        
        $denom = PriceList::find($denomId);
        
        if (!$denom) {
            $this->error('Denom not found!');
            return 1;
        }
        
        $this->info('Current denom details:');
        $this->table(['Field', 'Value'], [
            ['ID', $denom->id],
            ['Product Name', $denom->nama_produk],
            ['Current Digiflazz Code', $denom->kode_digiflazz ?? 'NOT SET'],
            ['Price', 'Rp ' . number_format($denom->harga, 0, ',', '.')],
        ]);
        
        $oldCode = $denom->kode_digiflazz;
        $denom->update(['kode_digiflazz' => $newCode]);
        
        $this->info('✅ Updated Digiflazz code from "' . $oldCode . '" to "' . $newCode . '"');
        
        return 0;
    }
} 