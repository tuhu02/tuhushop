<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produks';
    protected $fillable = ['nama'];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }

    // Alias untuk backward compatibility
    public function games()
    {
        return $this->produks();
    }

    // Scope untuk kategori aktif
    public function scopeActive($query)
    {
        return $query->whereHas('produks', function($q) {
            $q->where('is_active', 1);
        });
    }
} 