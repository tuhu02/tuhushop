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
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'nama_asc');
        $kategori_id = $request->query('kategori_id');
        $products = Produk::query();

        // Filter kategori jika dipilih
        if ($kategori_id) {
            $products->where('kategori_id', $kategori_id);
        }

        switch ($sort) {
            case 'nama_asc':
                $products->orderBy('product_name', 'asc');
                break;
            case 'nama_desc':
                $products->orderBy('product_name', 'desc');
                break;
            case 'populer':
                $products->orderBy('is_popular', 'desc');
                break;
            case 'aktif':
                $products->orderBy('is_active', 'desc');
                break;
            case 'kategori_asc':
                $products->orderBy('kategori_id', 'asc');
                break;
            case 'kategori_desc':
                $products->orderBy('kategori_id', 'desc');
                break;
            default:
                $products->orderBy('product_name', 'asc');
        }

        $products = $products->get();
        $kategoris = \App\Models\KategoriProduk::all();

        return view('admin.kelolaProdukList', compact('products', 'kategoris'));
    }

    public function show($product)
    {
        $product = Produk::with(['priceLists', 'kategori'])->findOrFail($product);
        $diamond = $product->priceLists->where('kategori', 'diamond');
        $nonDiamond = $product->priceLists->where('kategori', 'nondiamond');
        $kategoriDenoms = \App\Models\KategoriDenom::where('product_id', $product->product_id)->get();
        return view('admin.kelolaProduk', compact('product', 'diamond', 'nonDiamond', 'kategoriDenoms'));
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

    public function createDenom($product_id)
    {
        $kategoriDenoms = \App\Models\KategoriDenom::where('product_id', $product_id)->get();
        return view('admin.denom.create', compact('kategoriDenoms', 'product_id'));
    }

    public function editAccountFields($product_id)
    {
        $product = \App\Models\Produk::findOrFail($product_id);
        return view('admin.editAccountFields', compact('product'));
    }

    public function updateAccountFields(Request $request, $product_id)
    {
        $product = \App\Models\Produk::findOrFail($product_id);
        $request->validate([
            'account_fields' => 'required|string',
        ]);
        // Validasi JSON
        $json = $request->input('account_fields');
        try {
            $parsed = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            if (!is_array($parsed)) {
                throw new \Exception('Format JSON tidak valid.');
            }
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors(['account_fields' => 'Format JSON tidak valid: ' . $e->getMessage()]);
        }
        $product->account_fields = $parsed;
        $product->save();
        return back()->with('success', 'Struktur form akun berhasil diperbarui!');
    }
} 