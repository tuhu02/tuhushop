<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index()
    {
        $games = Produk::orderBy('sort_order', 'asc')->get();
        return view('admin.kelolaGame', compact('games'));
    }

    public function edit(Produk $product)
    {
        return view('admin.games.edit', compact('product'));
    }

    public function update(Request $request, Produk $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'developer' => 'required|string|max:255',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'product_name' => $request->product_name,
            'developer' => $request->developer,
        ];

        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($product->thumbnail_url && Storage::disk('public')->exists('image/' . $product->thumbnail_url)) {
                Storage::disk('public')->delete('image/' . $product->thumbnail_url);
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file ke public/image
            $file->move(public_path('image'), $filename);
            $data['thumbnail_url'] = $filename;
        }

        $product->update($data);

        return redirect()->route('admin.games.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $product)
    {
        // Hapus thumbnail jika ada
        if ($product->thumbnail_url && Storage::disk('public')->exists('image/' . $product->thumbnail_url)) {
            Storage::disk('public')->delete('image/' . $product->thumbnail_url);
        }

        $product->delete();

        return redirect()->route('admin.games.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function togglePopular(Produk $product)
    {
        $product->update(['is_popular' => !$product->is_popular]);
        
        $status = $product->is_popular ? 'ditandai sebagai populer' : 'dihapus dari populer';
        return redirect()->route('admin.games.index')->with('success', "Produk berhasil {$status}!");
    }
} 