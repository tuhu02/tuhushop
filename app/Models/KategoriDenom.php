<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriDenom extends Model
{
    use HasFactory;
    protected $table = 'kategori_denoms';
    protected $fillable = ['nama', 'slug'];

    public function produk()
    {
        return $this->belongsTo(\App\Models\Produk::class, 'product_id', 'product_id');
    }

    public function denoms()
    {
        return $this->hasMany(\App\Models\PriceList::class, 'kategori_id', 'id');
    }
} 