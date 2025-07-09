<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApigamesService;
use Illuminate\Http\Request;

class DenomController extends Controller
{
    public function importFromApigames(ApigamesService $apigames)
    {
        $denoms = $apigames->getVoucherDetail();
        return view('admin.denom.import', compact('denoms'));
    }

    public function storeImport(Request $request)
    {
        $denoms = $request->input('denoms', []);
        dd($denoms); // Debug: cek apakah data dari form ada
        foreach ($denoms as $denomJson) {
            $denom = json_decode($denomJson, true);
            dd($denom); // Debug: tampilkan isi data denom dari Apigames
            if (!$denom) continue;
            \App\Models\PriceList::updateOrCreate(
                ['kode_produk' => $denom['id'] ?? null],
                [
                    'nama_produk'     => $denom['name'] ?? '',
                    'harga_beli'     => $denom['price'] ?? 0,
                    'provider'       => 'Apigames',
                    'logo'           => $denom['image'] ?? null,
                    'denom'          => $denom['denom'] ?? null,
                    'harga_jual'     => $denom['harga_jual'] ?? null,
                    'profit'         => $denom['profit'] ?? null,
                    'harga_member'   => $denom['harga_member'] ?? null,
                    'harga_platinum' => $denom['harga_platinum'] ?? null,
                    'harga_gold'     => $denom['harga_gold'] ?? null,
                    'provider_id'    => $denom['provider_id'] ?? null,
                    // Anda bisa tambahkan mapping lain jika field tersedia di response Apigames
                ]
            );
        }
        return redirect()->route('admin.produk.index')->with('success', 'Denom berhasil diimport!');
    }
} 