<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class UpdateProductSortOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products and update their sort_order
        $products = Produk::all();
        
        foreach ($products as $index => $product) {
            $product->update(['sort_order' => $index + 1]);
        }
        
        $this->command->info('Product sort_order updated successfully!');
    }
}
