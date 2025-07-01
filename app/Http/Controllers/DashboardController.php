<?php

namespace App\Http\Controllers;

use App\Models\Game; // Pastikan model sudah diimport
use App\Models\Favorit; 

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil satu data game (misalnya, yang pertama)
        $game = Game::first(); // Mengambil record pertama dari tabel games
        $allGames = Game::getAllGame();
        $favorites = Favorit::with('game')->get();
        $data = [
            'title' => 'Dashboard Pengguna',
            'games' => $game, // Mengirimkan satu game ke view
            'allGame' => $allGames,
            'favorites' => $favorites,
        ];
    
        return view('dashboard', $data);
    }
}