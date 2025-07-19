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
        \Log::info('Store denom called', $request->all());
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'nama_denom' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'harga_member' => 'nullable|numeric|min:0',
            'profit' => 'nullable|numeric|min:0',
            'provider' => 'nullable|string|max:255',
            'kategori_id' => 'required|exists:kategori_denoms,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        \Log::info('Harga jual dari form:', ['harga_jual' => $request->harga_jual]);

        try {
            $data = [
                'product_id'    => $request->product_id,
                'nama_produk'   => $request->nama_denom,
                'harga_beli'    => $request->harga_beli,
                'harga_jual'    => $request->harga_jual,
                'harga_member'  => $request->harga_member,
                'profit'        => $request->profit,
                'provider'      => $request->provider,
                'kategori_id'   => $request->kategori_id,
            ];
            // Handle logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('denoms', 'public');
                $data['logo'] = $logoPath;
            }
            PriceList::create($data);
            return back()->with('success', 'Denom berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambahkan denom: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $denom = PriceList::findOrFail($id);
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'harga_member' => 'nullable|numeric|min:0',
            'profit' => 'nullable|numeric|min:0',
            'provider' => 'nullable|string|max:255',
            'kategori_id' => 'required|exists:kategori_denoms,id',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->only(['nama_produk','harga_beli','harga_jual','harga_member','profit','provider','kategori_id']);
        if ($request->hasFile('logo')) {
            if ($denom->logo) {
                \Storage::disk('public')->delete($denom->logo);
            }
            $logoPath = $request->file('logo')->store('denoms', 'public');
            $data['logo'] = $logoPath;
        }
        $denom->update($data);
        return redirect()->route('admin.produk.show', $denom->product_id)->with('success', 'Denom berhasil diperbarui!');
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

    public function edit($id)
    {
        $denom = PriceList::findOrFail($id);
        $kategoriDenoms = \App\Models\KategoriDenom::where('product_id', $denom->product_id)->get();
        return view('admin.denom.edit', compact('denom', 'kategoriDenoms'));
    }

    public function create(Request $request)
    {
        $product_id = $request->get('product_id');
        $kategoriDenoms = \App\Models\KategoriDenom::where('product_id', $product_id)->get();
        return view('admin.denom.create', compact('product_id', 'kategoriDenoms'));
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:price_lists,id',
            'order.*.sort_order' => 'required|integer|min:1',
        ]);

        try {
            foreach ($request->order as $item) {
                PriceList::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan denom berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan urutan: ' . $e->getMessage()
            ], 500);
        }
    }
} 