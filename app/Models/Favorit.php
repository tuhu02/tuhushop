<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'game_id');
    }
}



