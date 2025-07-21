<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}



