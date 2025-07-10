@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Denom Manual</h1>
    
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
        <p><strong>Catatan:</strong> API Apigames tidak dapat diakses saat ini. Silakan tambahkan denom secara manual atau hubungi support Apigames untuk mengaktifkan akses API.</p>
    </div>
    
    <form method="POST" action="{{ route('admin.denom.storeManual') }}" class="max-w-2xl">
        @csrf
        
        <div class="mb-4">
            <label for="product_id" class="block mb-2 font-semibold">Pilih Game/Produk</label>
            <select name="product_id" id="product_id" class="border rounded px-3 py-2 w-full" required>
                <option value="">-- Pilih Game --</option>
                @foreach($products as $product)
                    <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label for="kode_produk" class="block mb-2 font-semibold">Kode Produk</label>
            <input type="text" name="kode_produk" id="kode_produk" class="border rounded px-3 py-2 w-full" 
                   placeholder="Contoh: FF5, ML10, PUBG100" required>
        </div>
        
        <div class="mb-4">
            <label for="nama_produk" class="block mb-2 font-semibold">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" class="border rounded px-3 py-2 w-full" 
                   placeholder="Contoh: 5 Diamond Free Fire" required>
        </div>
        
        <div class="mb-4">
            <label for="denom" class="block mb-2 font-semibold">Denom (Opsional)</label>
            <input type="text" name="denom" id="denom" class="border rounded px-3 py-2 w-full" 
                   placeholder="Contoh: 5 Diamond, 100 UC">
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label for="harga_beli" class="block mb-2 font-semibold">Harga Beli</label>
                <input type="number" name="harga_beli" id="harga_beli" class="border rounded px-3 py-2 w-full" 
                       placeholder="0" required>
            </div>
            <div>
                <label for="harga_jual" class="block mb-2 font-semibold">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual" class="border rounded px-3 py-2 w-full" 
                       placeholder="0" required>
            </div>
        </div>
        
        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Tambah Denom
            </button>
            <a href="{{ route('admin.produk.index') }}" class="px-6 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Kembali
            </a>
        </div>
    </form>
    
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Contoh Denom Populer:</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border rounded p-4">
                <h3 class="font-bold text-green-600">Free Fire</h3>
                <ul class="text-sm mt-2">
                    <li>FF5 - 5 Diamond (Beli: 5000, Jual: 6000)</li>
                    <li>FF10 - 10 Diamond (Beli: 10000, Jual: 12000)</li>
                    <li>FF20 - 20 Diamond (Beli: 20000, Jual: 24000)</li>
                    <li>FF50 - 50 Diamond (Beli: 50000, Jual: 60000)</li>
                </ul>
            </div>
            <div class="border rounded p-4">
                <h3 class="font-bold text-blue-600">Mobile Legends</h3>
                <ul class="text-sm mt-2">
                    <li>ML10 - 10 Diamond (Beli: 10000, Jual: 12000)</li>
                    <li>ML20 - 20 Diamond (Beli: 20000, Jual: 24000)</li>
                    <li>ML50 - 50 Diamond (Beli: 50000, Jual: 60000)</li>
                    <li>ML100 - 100 Diamond (Beli: 100000, Jual: 120000)</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 