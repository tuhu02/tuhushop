<?php

namespace App\Http\Controllers;

use App\Models\Produk; // Update to use Produk model
use App\Models\Favorit; 

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil satu data produk (misalnya, yang pertama)
        $product = Produk::orderBy('sort_order', 'asc')->first(); // Mengambil record pertama dari tabel products
        $allProducts = Produk::orderBy('sort_order', 'asc')->get(); // Order by sort_order
        $favorites = Favorit::with('produk')->get(); // Update relationship name
        
        // Ambil produk yang populer
        $populerProducts = Produk::where('is_popular', true)->orderBy('sort_order', 'asc')->get();
        
        $data = [
            'title' => 'Dashboard Pengguna',
            'games' => $product, // Keep variable name for backward compatibility
            'allGame' => $allProducts, // Keep variable name for backward compatibility
            'favorites' => $favorites,
            'populerGames' => $populerProducts, // Keep variable name for backward compatibility
        ];
    
        return view('dashboard', $data);
    }
}