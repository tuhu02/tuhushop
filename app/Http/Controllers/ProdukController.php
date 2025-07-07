<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Import model Produk
use App\Models\PriceList;
class ProdukController extends Controller
{
    // Method untuk menampilkan semua data produk
    public function index()
    {
        // Ambil semua data produk dari database
        $produk = Produk::all();

        // Kirim data ke view
        return view('produk.index', compact('produk'));
    }

    public function show($game)
    {
        $diamond = PriceList::where('product_id', 1)->where('kategori','diamond')->get();
        $nonDiamond = PriceList::where('product_id',1)->where('kategori','nondiamond')->get();
        $data = [
            "diamond" => $diamond,
            "nonDiamond" => $nonDiamond,
        ];
        return view('produk.' . $game, $data);
    }

    public function showPublic($product_id, Request $request)
    {
        $kategoriAktif = $request->get('kategori', 'diamond');
        $product = Produk::with(['kategori', 'priceLists'])->where('product_id', $product_id)->firstOrFail();
        $filteredDenoms = $product->priceLists->where('kategori', $kategoriAktif);
        $allGame = Produk::all();
        $specialOffers = $product->specialOffers;
        return view('customer.product', [
            'product' => $product,
            'filteredDenoms' => $filteredDenoms,
            'kategoriAktif' => $kategoriAktif,
            'allGame' => $allGame,
            'specialOffers' => $specialOffers,
        ]);
    }

}
