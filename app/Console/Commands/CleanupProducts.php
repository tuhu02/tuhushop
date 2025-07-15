<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Produk;
use App\Models\PriceList;

class CleanupProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menstandarisasi dan merapikan data produk serta denom (price list)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Menstandarisasi nama produk...');
        $products = Produk::all();
        foreach ($products as $product) {
            $product->name = ucwords(strtolower($product->name));
            $product->save();
        }

        $this->info('Menggabungkan produk duplikat...');
        $grouped = Produk::all()->groupBy(function($item) {
            return strtolower($item->name);
        });

        foreach ($grouped as $name => $items) {
            if ($items->count() > 1) {
                $main = $items->first();
                $dupes = $items->slice(1);

                foreach ($dupes as $dupe) {
                    PriceList::where('product_id', $dupe->id)->update(['product_id' => $main->id]);
                    $dupe->delete();
                }
                $this->info("Produk duplikat untuk '{$main->name}' digabungkan.");
            }
        }

        $this->info('Produk dan denom sudah rapi!');
    }
}
