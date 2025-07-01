<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $table = 'pricelists';

    // Fungsi untuk mengambil semua data pricelist
    public static function priceml()
    {
        return $this->all(); // Mengambil semua data pricelist
    }
}
