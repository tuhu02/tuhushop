<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Import model Produk
use App\Models\PriceList;
use Illuminate\Support\Facades\Http;
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
        if ($kategoriDenom) {
            $filteredDenoms = $product->priceLists->where('kategori_id', $kategoriDenom->id)->sortBy('sort_order');
        } else {
            // Jika tidak ada kategoriDenom, tampilkan semua denom
            $filteredDenoms = $product->priceLists->sortBy('sort_order');
        }
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

    // Cek nickname Mobile Legends via DigiFlazz
    public function cekMLBBUsername(Request $request)
    {
        $userId = $request->input('user_id');
        $server = $request->input('server');
        $customerNo = $userId . $server;
        $refId = uniqid('cekmlbb_');
        $username = env('DIGIFLAZZ_USERNAME');
        $apiKey = env('DIGIFLAZZ_API_KEY');
        $sign = md5($username . $apiKey . $refId);

        $response = Http::post('https://api.digiflazz.com/v1/transaction', [
            'username' => $username,
            'buyer_sku_code' => 'unametuhu',
            'customer_no' => $customerNo,
            'ref_id' => $refId,
            'sign' => $sign,
        ]);

        $json = $response->json();
        // Cek nickname di response (bisa di message atau customer_name tergantung API)
        $nickname = $json['data']['customer_name'] ?? ($json['data']['message'] ?? null);
        return response()->json([
            'nickname' => $nickname,
            'raw' => $json
        ]);
    }
}
