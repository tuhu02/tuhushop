<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriDenom;
use Illuminate\Http\Request;
use App\Models\Produk;

class KategoriDenomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoriDenoms = KategoriDenom::with('product')->orderBy('nama')->get();
        $products = Produk::orderBy('product_name')->get();
        return view('admin.kategoriDenom', compact('kategoriDenoms', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Produk::orderBy('product_name')->get();
        return view('admin.kategoriDenom', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:kategori_denoms,slug',
            'product_id' => 'required|exists:products,product_id',
        ]);
        KategoriDenom::create($request->only(['nama', 'slug', 'product_id']));
        return redirect()->route('admin.kategori-denom.index')->with('success', 'Kategori denom berhasil ditambahkan!');
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
        $kategoriDenom = KategoriDenom::findOrFail($id);
        $kategoriDenoms = KategoriDenom::with('product')->orderBy('nama')->get();
        $products = Produk::orderBy('product_name')->get();
        return view('admin.kategoriDenom', compact('kategoriDenoms', 'kategoriDenom', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategoriDenom = KategoriDenom::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:kategori_denoms,slug,' . $kategoriDenom->id,
            'product_id' => 'required|exists:products,product_id',
        ]);
        $kategoriDenom->update($request->only(['nama', 'slug', 'product_id']));
        return redirect()->route('admin.kategori-denom.index')->with('success', 'Kategori denom berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategoriDenom = KategoriDenom::findOrFail($id);
        $kategoriDenom->delete();
        return redirect()->route('admin.kategori-denom.index')->with('success', 'Kategori denom berhasil dihapus!');
    }
}
