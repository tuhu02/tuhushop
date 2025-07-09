<?php

namespace App\Http\Controllers;

use App\Models\Game; // Pastikan model sudah diimport
use App\Models\Favorit; 

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil satu data game (misalnya, yang pertama)
        $game = Game::first(); // Mengambil record pertama dari tabel products
        $allGames = Game::getAllGame();
        $favorites = Favorit::with('game')->get();
        
        // Ambil game yang populer
        $populerGames = Game::where('is_popular', true)->get();
        
        $data = [
            'title' => 'Dashboard Pengguna',
            'games' => $game, // Mengirimkan satu game ke view
            'allGame' => $allGames,
            'favorites' => $favorites,
            'populerGames' => $populerGames,
        ];
    
        return view('dashboard', $data);
    }
}