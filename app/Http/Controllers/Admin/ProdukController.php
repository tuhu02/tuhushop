<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\PriceList;
use App\Models\KategoriProduk;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Produk::with('kategori')->get();
        return view('admin.kelolaProdukList', compact('products'));
    }

    public function show($product)
    {
        $product = Produk::with(['priceLists', 'kategori'])->findOrFail($product);
        $diamond = $product->priceLists->where('kategori', 'diamond');
        $nonDiamond = $product->priceLists->where('kategori', 'nondiamond');
        return view('admin.produk.show', compact('product', 'diamond', 'nonDiamond'));
    }

    public function create()
    {
        $kategoris = KategoriProduk::all();
        return view('admin.tambahproduk', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produks,id',
            'developer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kode_digiflazz' => 'nullable|string|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $data = $request->all();
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists (untuk update)
            if (isset($product) && $product->thumbnail_url && file_exists(public_path('image/' . $product->thumbnail_url))) {
                unlink(public_path('image/' . $product->thumbnail_url));
            }
            $thumbFile = $request->file('thumbnail');
            $thumbName = time() . '_' . $thumbFile->getClientOriginalName();
            $thumbFile->move(public_path('image'), $thumbName);
            $data['thumbnail_url'] = $thumbName;
        }
        // Handle banner upload
        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($product->banner_url && file_exists(public_path('image/' . $product->banner_url))) {
                unlink(public_path('image/' . $product->banner_url));
            }
            $bannerFile = $request->file('banner');
            $bannerName = time() . '_' . $bannerFile->getClientOriginalName();
            $bannerFile->move(public_path('image'), $bannerName);
            $data['banner_url'] = $bannerName;
        }

        Produk::create($data);
        
        return redirect()->route('admin.kelolaProduk')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($product)
    {
        $product = Produk::findOrFail($product);
        $kategoris = KategoriProduk::all();
        return view('admin.editProduk', compact('product', 'kategoris'));
    }

    public function update(Request $request, $product)
    {
        $product = Produk::findOrFail($product);
        
        $request->validate([
            'product_name' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_produks,id',
            'developer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kode_digiflazz' => 'nullable|string|max:255',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $data = $request->all();
        
        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists (untuk update)
            if (isset($product) && $product->thumbnail_url && file_exists(public_path('image/' . $product->thumbnail_url))) {
                unlink(public_path('image/' . $product->thumbnail_url));
            }
            $thumbFile = $request->file('thumbnail');
            $thumbName = time() . '_' . $thumbFile->getClientOriginalName();
            $thumbFile->move(public_path('image'), $thumbName);
            $data['thumbnail_url'] = $thumbName;
        }
        // Handle banner upload
        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($product->banner_url && file_exists(public_path('image/' . $product->banner_url))) {
                unlink(public_path('image/' . $product->banner_url));
            }
            $bannerFile = $request->file('banner');
            $bannerName = time() . '_' . $bannerFile->getClientOriginalName();
            $bannerFile->move(public_path('image'), $bannerName);
            $data['banner_url'] = $bannerName;
        }

        $product->update($data);
        
        return redirect()->route('admin.produk.show', $product->product_id)->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($product)
    {
        $product = Produk::findOrFail($product);
        
        // Delete thumbnail if exists
        if ($product->thumbnail_url && file_exists(public_path('image/' . $product->thumbnail_url))) {
            unlink(public_path('image/' . $product->thumbnail_url));
        }
        
        $product->delete();
        
        return redirect()->route('admin.kelolaProduk')->with('success', 'Produk berhasil dihapus!');
    }

    public function syncDigiflazzDenom(Request $request, $product)
    {
        $product = Produk::findOrFail($product);
        
        if (!$product->kode_digiflazz) {
            return back()->with('error', 'Kode Digiflazz belum diatur untuk produk ini!');
        }

        try {
            // Call Digiflazz API
            $response = Http::post('https://api.digiflazz.com/v1/price-list', [
                'cmd' => 'prepaid',
                'username' => config('services.digiflazz.username'),
                'sign' => md5(config('services.digiflazz.username') . config('services.digiflazz.api_key') . 'pricelist'),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data'])) {
                    $imported = 0;
                    
                    foreach ($data['data'] as $item) {
                        // Filter berdasarkan kode produk
                        if (str_contains(strtolower($item['brand']), strtolower($product->kode_digiflazz)) ||
                            str_contains(strtolower($item['category']), strtolower($product->kode_digiflazz))) {
                            
                            // Check if denom already exists
                            $existingDenom = PriceList::where('kode_digiflazz', $item['buyer_sku_code'])
                                                     ->where('product_id', $product->product_id)
                                                     ->first();
                            
                            if (!$existingDenom) {
                                PriceList::create([
                                    'product_id' => $product->product_id,
                                    'nama_produk' => $item['product_name'],
                                    'kode_digiflazz' => $item['buyer_sku_code'],
                                    'nama_denom' => $item['desc'],
                                    'harga_modal' => $item['price'],
                                    'harga_jual' => $item['price'] + 1000, // Add profit
                                    'harga_member' => $item['price'] + 500, // Member price
                                    'profit' => 1000,
                                    'provider' => $item['brand'],
                                    'status' => 'active',
                                    'kategori' => 'nondiamond',
                                ]);
                                $imported++;
                            }
                        }
                    }
                    
                    return back()->with('success', "Berhasil mengimpor {$imported} denom dari Digiflazz!");
                }
            }
            
            return back()->with('error', 'Gagal mengambil data dari Digiflazz!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
} 