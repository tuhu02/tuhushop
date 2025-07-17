<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApigamesService;
use Illuminate\Http\Request;

class DenomController extends Controller
{
    public function importFromApigames(Request $request, ApigamesService $apigames)
    {
        // Test connection first
        if ($request->has('test_connection')) {
            $connectionTest = $apigames->testConnection();
            dd($connectionTest);
        }
        
        // Test voucher detail parameters
        if ($request->has('test_voucher_params')) {
            $testResults = $apigames->testVoucherDetailParams(1); // Test with Free Fire ID
            echo "<h2>Voucher Detail Parameter Testing Results:</h2>";
            echo "<pre>";
            print_r($testResults);
            echo "</pre>";
            die();
        }
        
        // Check all available endpoints
        if ($request->has('check_endpoints')) {
            $endpointResults = $apigames->checkAvailableEndpoints();
            echo "<h2>Available Endpoints Check:</h2>";
            echo "<pre>";
            print_r($endpointResults);
            echo "</pre>";
            die();
        }
        
        // Test voucher detail with form data
        if ($request->has('test_voucher_form')) {
            $voucherTest = $apigames->getVoucherDetail(1); // Test with Free Fire ID
            echo "<h2>Voucher Detail Test with Form Data:</h2>";
            echo "<pre>";
            print_r($voucherTest);
            echo "</pre>";
            die();
        }
        
        // Test different API structures
        if ($request->has('test_api_structures')) {
            $structureTest = $apigames->testApiStructures();
            echo "<h2>API Structure Test:</h2>";
            echo "<pre>";
            print_r($structureTest);
            echo "</pre>";
            die();
        }
        
        // Comprehensive voucher test
        if ($request->has('comprehensive_test')) {
            $comprehensiveTest = $apigames->comprehensiveVoucherTest();
            echo "<h2>Comprehensive Voucher Test:</h2>";
            echo "<pre>";
            print_r($comprehensiveTest);
            echo "</pre>";
            die();
        }
        
        // Fetch project list from Apigames first
        $projectList = $apigames->getProductList();
        
        // If API fails, use fallback project list
        if (isset($projectList['error_msg']) || $projectList['status'] == 0) {
            $projectList = [
                'status' => 1,
                'data' => [
                    ['id' => '1', 'name' => 'Free Fire'],
                    ['id' => '2', 'name' => 'Mobile Legends'],
                    ['id' => '3', 'name' => 'PUBG Mobile'],
                    ['id' => '4', 'name' => 'Genshin Impact'],
                    ['id' => '5', 'name' => 'Call of Duty Mobile'],
                    // Add more as needed
                ]
            ];
        }
        
        // Debug: cek response project list
        if ($request->has('debug_projects')) {
            echo "<h2>Project List Response:</h2>";
            echo "<pre>";
            print_r($projectList);
            echo "</pre>";
            
            if (isset($projectList['data']) && is_array($projectList['data'])) {
                echo "<h2>Available Projects:</h2>";
                echo "<ul>";
                foreach ($projectList['data'] as $index => $project) {
                    echo "<li>Index {$index}: ";
                    print_r($project);
                    echo "</li>";
                }
                echo "</ul>";
            }
            die();
        }
        
        $projectid = $request->input('projectid');
        $denoms = null;
        
        if ($projectid) {
            $denoms = $apigames->getVoucherDetail($projectid);
            // Cari product_id berdasarkan nama game
            $gameName = '';
            foreach ($projectList['data'] as $project) {
                if ($project['id'] == $projectid) {
                    $gameName = $project['name'];
                    break;
                }
            }
            
            $product = \App\Models\Produk::where('product_name', $gameName)->first();
            $product_id = $product ? $product->product_id : null;
            // Simpan product_id ke session agar bisa dipakai di storeImport
            session(['import_product_id' => $product_id]);
            
            // Debug: cek response denom dari Apigames
            if ($request->has('debug_denoms')) {
                echo "<h2>Voucher Detail Response for Project ID: {$projectid} ({$gameName})</h2>";
                echo "<pre>";
                print_r($denoms);
                echo "</pre>";
                die();
            }
        }
        
        return view('admin.denom.import', [
            'projectList' => $projectList,
            'projectid' => $projectid,
            'denoms' => $denoms
        ]);
    }

    public function storeImport(Request $request)
    {
        $denoms = $request->input('denoms', []);
        $product_id = session('import_product_id');
        foreach ($denoms as $denomJson) {
            $denom = json_decode($denomJson, true);
            if (!$denom) continue;
            \App\Models\PriceList::updateOrCreate(
                [
                    'kode_produk' => $denom['id'] ?? null,
                    'product_id'  => $product_id,
                ],
                [
                    'nama_produk'     => $denom['name'] ?? '',
                    'harga_beli'      => $denom['price'] ?? 0,
                    'provider'        => 'Apigames',
                    'logo'            => $denom['image'] ?? null,
                    'denom'           => $denom['denom'] ?? null,
                    'harga_jual'      => $denom['harga_jual'] ?? null,
                    'profit'          => $denom['profit'] ?? null,
                    'harga_member'    => $denom['harga_member'] ?? null,
                    'harga_platinum'  => $denom['harga_platinum'] ?? null,
                    'harga_gold'      => $denom['harga_gold'] ?? null,
                    'provider_id'     => $denom['provider_id'] ?? null,
                ]
            );
        }
        return redirect()->route('admin.produk.index')->with('success', 'Denom berhasil diimport!');
    }

    public function importFromDigiflazz(Request $request)
    {
        $digiflazz = new \App\Services\DigiflazzService();
        
        // Test connection first
        if ($request->has('test_connection')) {
            $connectionTest = $digiflazz->checkConnection();
            dd($connectionTest);
        }
        
        // Import denoms
        if ($request->has('import')) {
            $gameName = $request->input('game_name');
            $importResult = $digiflazz->importDenoms($gameName);
            
            if ($request->has('debug')) {
                dd($importResult);
            }
            
            $message = "Berhasil import {$importResult['imported_count']} denom dari Digiflazz!";
            if (!empty($importResult['errors'])) {
                $message .= " Errors: " . implode(', ', $importResult['errors']);
            }
            
            return redirect()->route('admin.produk.index')->with('success', $message);
        }
        
        // Get available games from Digiflazz
        $priceList = $digiflazz->getPriceList();
        $games = [];
        foreach ($priceList as $item) {
            $games[] = $item['name'];
        }
        
        return view('admin.denom.importDigiflazz', compact('games'));
    }

    public function manualDenomForm()
    {
        $products = \App\Models\Produk::all();
        return view('admin.denom.manual', compact('products'));
    }

    public function storeManualDenom(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'kode_produk' => 'required|string',
            'nama_produk' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'denom' => 'nullable|string',
        ]);

        \App\Models\PriceList::create([
            'product_id' => $request->product_id,
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'denom' => $request->denom,
            'provider' => 'Manual',
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Denom berhasil ditambahkan secara manual!');
    }

    public function create()
    {
        return view('admin.denom.create');
    }

    public function importApigames()
    {
        $apigames = new ApigamesService();
        $result = $apigames->getProductList();

        if ($result['status'] !== 'sukses') {
            return back()->with('error', 'Gagal mengambil data dari Apigames: ' . ($result['error_msg'] ?? ''));
        }

        return view('admin.denom.importApigames', [
            'products' => $result['data']
        ]);
    }

    public function doImportApigames(Request $request)
    {
        $products = $request->input('products', []);
        $imported = 0;

        foreach ($products as $productJson) {
            $product = json_decode($productJson, true);
            if (!$product) continue;
            // Mapping dan simpan ke database, sesuaikan dengan struktur tabel Denom Anda
            \App\Models\Denom::updateOrCreate(
                ['kode' => $product['kode'] ?? $product['code'] ?? null],
                [
                    'nama' => $product['nama'] ?? $product['name'] ?? null,
                    'brand' => $product['brand'] ?? null,
                    'harga' => $product['harga'] ?? $product['price'] ?? null,
                    // tambahkan field lain sesuai kebutuhan
                ]
            );
            $imported++;
        }

        return redirect()->route('admin.denom.index')->with('success', "$imported denom berhasil diimport dari Apigames.");
    }

    public function update(Request $request, $id)
    {
        $denom = \App\Models\PriceList::findOrFail($id);

        // Validasi input lain sesuai kebutuhan...
        $request->validate([
            'nama_produk' => 'required|string',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            // Pastikan folder public/image/denoms sudah ada
            if (!file_exists(public_path('image/denoms'))) {
                mkdir(public_path('image/denoms'), 0777, true);
            }
            $file->move(public_path('image/denoms'), $filename); // simpan di public/image/denoms/
            $denom->logo = 'denoms/' . $filename; // simpan path folder di database
        }

        // Update field lain
        $denom->nama_produk = $request->nama_produk;
        $denom->harga_beli = $request->harga_beli;
        $denom->harga_jual = $request->harga_jual;
        $denom->denom = $request->denom;
        // tambahkan field lain sesuai kebutuhan

        $denom->save();

        return redirect()->back()->with('success', 'Denom berhasil diupdate!');
    }
} 