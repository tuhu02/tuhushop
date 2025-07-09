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
        $kategoriAktif = $request->get('kategori');
        $product = Produk::with(['kategori', 'priceLists', 'kategoriDenoms'])->where('product_id', $product_id)->firstOrFail();
        $kategoriDenoms = $product->kategoriDenoms;
        // Jika tidak ada kategori aktif di query, pakai kategori pertama
        if (!$kategoriAktif && $kategoriDenoms->count() > 0) {
            $kategoriAktif = $kategoriDenoms->first()->slug;
        }
        $kategoriDenom = $kategoriDenoms->firstWhere('slug', $kategoriAktif);
        $filteredDenoms = $kategoriDenom
            ? $product->priceLists->where('kategori_id', $kategoriDenom->id)
            : collect();
        $allGame = Produk::all();
        return view('customer.product', [
            'product' => $product,
            'filteredDenoms' => $filteredDenoms,
            'kategoriAktif' => $kategoriAktif,
            'kategoriDenoms' => $kategoriDenoms,
            'allGame' => $allGame,
            'accountFields' => $product->account_fields,
        ]);
    }

}
