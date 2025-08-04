<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriDenom extends Model
{
    use HasFactory;
    protected $table = 'kategori_denoms';
    protected $fillable = ['nama', 'slug', 'product_id', 'sort_order'];

    public function product()
    {
        return $this->belongsTo(\App\Models\Produk::class, 'product_id', 'product_id');
    }

    public function denoms()
    {
        return $this->hasMany(\App\Models\PriceList::class, 'kategori_id', 'id');
    }
} 