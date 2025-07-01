<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    
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
}