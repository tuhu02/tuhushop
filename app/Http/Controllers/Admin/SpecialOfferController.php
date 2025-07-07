<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpecialOffer;
use App\Models\Produk;

class SpecialOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productId = $request->get('product_id');
        if ($productId) {
            $offers = SpecialOffer::where('product_id', $productId)->get();
            $product = Produk::find($productId);
            $products = Produk::all(); // Untuk dropdown
        } else {
            $offers = collect(); // kosong
            $product = null;
            $products = Produk::all();
        }
        return view('admin.special_offers.index', compact('offers', 'product', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $productId = $request->get('product_id');
        $product = Produk::find($productId);
        return view('admin.special_offers.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'type' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
        ]);
        SpecialOffer::create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'title' => $request->title,
            'icon' => $request->icon,
            'active' => $request->has('active'),
        ]);
        return redirect()->route('admin.special-offers.index', ['product_id' => $request->product_id])->with('success', 'Special offer berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $offer = SpecialOffer::findOrFail($id);
        $product = Produk::find($offer->product_id);
        return view('admin.special_offers.edit', compact('offer', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $offer = SpecialOffer::findOrFail($id);
        $request->validate([
            'type' => 'required',
            'title' => 'required',
            'icon' => 'nullable',
        ]);
        $offer->update([
            'type' => $request->type,
            'title' => $request->title,
            'icon' => $request->icon,
            'active' => $request->has('active'),
        ]);
        return redirect()->route('admin.special-offers.index', ['product_id' => $offer->product_id])->with('success', 'Special offer berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $offer = SpecialOffer::findOrFail($id);
        $productId = $offer->product_id;
        $offer->delete();
        return redirect()->route('admin.special-offers.index', ['product_id' => $productId])->with('success', 'Special offer berhasil dihapus!');
    }
}
