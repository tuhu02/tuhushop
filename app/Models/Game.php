<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'game_id';
    
    protected $fillable = [
        'game_name',
        'developer',
        'release_date',
        'description',
        'thumbnail_url',
        'is_active',
        'digiflazz_id',
        'category',
        'price',
        'brand',
        'icon_url',
        'status'
    ];
    
    /**
     * Method untuk mengambil game pertama
     */
    public static function getFirstGame()
    {
        return self::first(); // Mengambil record pertama dari tabel games
    }

    public static function getAllGame()
    {
        return self::all();
    }

    public function favorites()
    {
        return $this->hasMany(Favorit::class, 'game_id', 'game_id');
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class, 'game_id', 'game_id');
    }
}