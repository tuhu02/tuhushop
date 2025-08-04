<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriDenom;

class UpdateKategoriDenomSortOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriDenoms = KategoriDenom::all();
        
        foreach ($kategoriDenoms as $index => $kategori) {
            $kategori->update(['sort_order' => $index + 1]);
            echo "Updated {$kategori->nama} with sort_order " . ($index + 1) . PHP_EOL;
        }
        
        echo "Successfully updated sort_order for all kategori_denoms" . PHP_EOL;
    }
}
