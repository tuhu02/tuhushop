<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Produk
{
    use HasFactory;
    
    // Game model sekarang extends Produk untuk backward compatibility
    // Semua method dan relasi sudah ada di Produk model
    
    /**
     * Method untuk mengambil produk pertama
     */
    public static function getFirstProduct()
    {
        return self::first();
    }

    public static function getAllProducts()
    {
        return self::all();
    }

    public function favorites()
    {
        return $this->hasMany(Favorit::class, 'product_id', 'product_id');
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class, 'game_id', 'game_id');
    }

    public function priceLists()
    {
        return $this->hasMany(\App\Models\PriceList::class, 'product_id', 'product_id');
    }

    public function kategori()
    {
        return $this->belongsTo(\App\Models\KategoriProduk::class, 'kategori_id');
    }

    // Alias untuk backward compatibility
    public static function getFirstGame()
    {
        return self::getFirstProduct();
    }

    public static function getAllGame()
    {
        return self::getAllProducts();
    }
}