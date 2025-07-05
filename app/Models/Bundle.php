<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image', 'price', 'status'
    ];

    public function products()
    {
        return $this->belongsToMany(PriceList::class, 'bundle_product', 'bundle_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}
