@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Denom</h1>
        <form action="{{ route('admin.denom.update', $denom->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">Nama Denom *</label>
                <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $denom->nama_produk) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
                <input type="number" id="harga" name="harga" value="{{ old('harga', $denom->harga) }}" required min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="harga_member" class="block text-sm font-medium text-gray-700 mb-1">Harga Member</label>
                <input type="number" id="harga_member" name="harga_member" value="{{ old('harga_member', $denom->harga_member) }}" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="profit" class="block text-sm font-medium text-gray-700 mb-1">Profit</label>
                <input type="number" id="profit" name="profit" value="{{ old('profit', $denom->profit) }}" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="provider" class="block text-sm font-medium text-gray-700 mb-1">Provider</label>
                <input type="text" id="provider" name="provider" value="{{ old('provider', $denom->provider) }}" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select id="kategori" name="kategori" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="diamond" {{ old('kategori', $denom->kategori) == 'diamond' ? 'selected' : '' }}>Diamond</option>
                    <option value="nondiamond" {{ old('kategori', $denom->kategori) == 'nondiamond' ? 'selected' : '' }}>Non Diamond</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo Denom</label>
                @if($denom->logo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $denom->logo) }}" alt="Logo Denom" class="w-16 h-16 object-cover rounded">
                    </div>
                @endif
                <input type="file" id="logo" name="logo" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="flex justify-end">
                <a href="{{ route('admin.produk.show', $denom->product_id) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection 