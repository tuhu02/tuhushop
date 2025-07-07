@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Denom</h1>
        <form action="{{ route('admin.denom.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
            <div class="mb-4">
                <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">Nama Denom *</label>
                <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
                <input type="number" id="harga" name="harga" value="{{ old('harga') }}" required min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="harga_member" class="block text-sm font-medium text-gray-700 mb-1">Harga Member</label>
                <input type="number" id="harga_member" name="harga_member" value="{{ old('harga_member') }}" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="profit" class="block text-sm font-medium text-gray-700 mb-1">Profit</label>
                <input type="number" id="profit" name="profit" value="{{ old('profit') }}" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="provider" class="block text-sm font-medium text-gray-700 mb-1">Provider</label>
                <select id="provider" name="provider" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="Digiflazz">Digiflazz</option>
                    <option value="DuniaGames">DuniaGames</option>
                    <option value="Unipin">Unipin</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select id="kategori" name="kategori" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    @foreach($kategoriDenoms as $kategori)
                        <option value="{{ $kategori->slug }}" {{ old('kategori') == $kategori->slug ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo Denom</label>
                <input type="file" id="logo" name="logo" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="flex justify-end">
                <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Batal</a>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Tambah Denom</button>
            </div>
        </form>
    </div>
</div>
@endsection 