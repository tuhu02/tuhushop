<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $table = 'price_lists';

    protected $fillable = [
        'product_id',
        'nama_produk',
        'harga_beli',
        'kategori_id',
        'provider',
        'harga_member',
        'profit',
        'logo',
        'kode_digiflazz',
        'kode_produk',
        'denom',
        'harga_jual',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_modal' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'harga_member' => 'decimal:2',
        'profit' => 'decimal:2',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id', 'product_id');
    }

    // Alias untuk backward compatibility
    public function game()
    {
        return $this->produk();
    }

    // Fungsi untuk mengambil semua data pricelist
    public static function priceml()
    {
        return self::all();
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Scope untuk filter berdasarkan status
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function kategoriDenom()
    {
        return $this->belongsTo(\App\Models\KategoriDenom::class, 'kategori_id', 'id');
    }
}
