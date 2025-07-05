<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PriceList;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class PriceListController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'nama_denom' => 'required|string|max:255',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'harga_member' => 'required|numeric|min:0',
            'profit' => 'required|numeric|min:0',
            'provider' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kode_digiflazz' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('denoms', 'public');
            $data['logo'] = $logoPath;
        }

        // Set default values
        $data['nama_produk'] = $data['nama_denom'];
        $data['harga'] = $data['harga_jual'];
        $data['status'] = $data['status'] ?? 'active';

        PriceList::create($data);
        
        return back()->with('success', 'Denom berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $priceList = PriceList::findOrFail($id);
        
        $request->validate([
            'nama_denom' => 'required|string|max:255',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'harga_member' => 'required|numeric|min:0',
            'profit' => 'required|numeric|min:0',
            'provider' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kode_digiflazz' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($priceList->logo) {
                Storage::disk('public')->delete($priceList->logo);
            }
            $logoPath = $request->file('logo')->store('denoms', 'public');
            $data['logo'] = $logoPath;
        }

        // Update related fields
        $data['nama_produk'] = $data['nama_denom'];
        $data['harga'] = $data['harga_jual'];

        $priceList->update($data);
        
        return back()->with('success', 'Denom berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $priceList = PriceList::findOrFail($id);
        
        // Delete logo if exists
        if ($priceList->logo) {
            Storage::disk('public')->delete($priceList->logo);
        }
        
        $priceList->delete();
        
        return back()->with('success', 'Denom berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $priceList = PriceList::findOrFail($id);
        $priceList->status = $priceList->status === 'active' ? 'inactive' : 'active';
        $priceList->save();
        
        return back()->with('success', 'Status denom berhasil diubah!');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'denom_ids' => 'required|array',
            'denom_ids.*' => 'exists:price_lists,id',
            'action' => 'required|in:activate,deactivate,delete',
        ]);

        $denomIds = $request->denom_ids;
        $action = $request->action;

        switch ($action) {
            case 'activate':
                PriceList::whereIn('id', $denomIds)->update(['status' => 'active']);
                $message = 'Denom berhasil diaktifkan!';
                break;
            case 'deactivate':
                PriceList::whereIn('id', $denomIds)->update(['status' => 'inactive']);
                $message = 'Denom berhasil dinonaktifkan!';
                break;
            case 'delete':
                PriceList::whereIn('id', $denomIds)->delete();
                $message = 'Denom berhasil dihapus!';
                break;
        }

        return back()->with('success', $message);
    }
} 