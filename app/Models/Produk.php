<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'developer',
        'release_date',
        'description',
        'thumbnail_url',
        'banner_url',
        'is_active',
        'digiflazz_id',
        'category',
        'price',
        'brand',
        'icon_url',
        'status',
        'is_popular',
        'kategori_id',
        'kode_digiflazz',
        'deskripsi',
        'logo',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    public function priceLists()
    {
        return $this->hasMany(PriceList::class, 'product_id', 'product_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorit::class, 'product_id', 'product_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'product_id', 'product_id');
    }

    public function specialOffers()
    {
        return $this->hasMany(\App\Models\SpecialOffer::class, 'product_id', 'product_id');
    }

    public function kategoriDenoms()
    {
        return $this->hasMany(\App\Models\KategoriDenom::class, 'product_id', 'product_id');
    }

    // Alias untuk backward compatibility
    public static function getFirstGame()
    {
        return self::first();
    }

    public static function getAllGame()
    {
        return self::all();
    }
}
