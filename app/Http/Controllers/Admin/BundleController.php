<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\PriceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bundles = Bundle::with('products')->paginate(10);
        return view('admin.bundles.index', compact('bundles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = PriceList::all();
        return view('admin.bundles.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:price_lists,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('bundles', 'public');
        }

        $bundle = Bundle::create($data);

        $syncData = [];
        foreach ($data['products'] as $i => $productId) {
            $syncData[$productId] = ['quantity' => $data['quantities'][$i] ?? 1];
        }
        $bundle->products()->sync($syncData);

        return redirect()->route('admin.bundles.index')->with('success', 'Bundling berhasil ditambahkan!');
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
    public function edit(Bundle $bundle)
    {
        $products = PriceList::all();
        $bundle->load('products');
        return view('admin.bundles.edit', compact('bundle', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bundle $bundle)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:price_lists,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            if ($bundle->image) Storage::disk('public')->delete($bundle->image);
            $data['image'] = $request->file('image')->store('bundles', 'public');
        }

        $bundle->update($data);

        $syncData = [];
        foreach ($data['products'] as $i => $productId) {
            $syncData[$productId] = ['quantity' => $data['quantities'][$i] ?? 1];
        }
        $bundle->products()->sync($syncData);

        return redirect()->route('admin.bundles.index')->with('success', 'Bundling berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bundle $bundle)
    {
        if ($bundle->image) Storage::disk('public')->delete($bundle->image);
        $bundle->delete();
        return redirect()->route('admin.bundles.index')->with('success', 'Bundling berhasil dihapus!');
    }
}
