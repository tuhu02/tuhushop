@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Denom</h1>
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.denom.update', $denom->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="product_id" value="{{ $denom->product_id }}">
            <div class="mb-4">
                <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">Nama Denom *</label>
                <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $denom->nama_produk) }}" required class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="harga_beli" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli *</label>
                <input type="number" id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $denom->harga_beli) }}" required min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual *</label>
                <input type="number" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $denom->harga_jual) }}" required min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
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
                <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select id="kategori_id" name="kategori_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriDenoms as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $denom->kategori_id) == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo Denom</label>
                <input type="file" id="logo" name="logo" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2">
                @if($denom->logo)
                    <img src="{{ Storage::url($denom->logo) }}" alt="Logo Denom" class="h-12 mt-2">
                @endif
            </div>
            <div class="flex justify-end">
                <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Update Denom</button>
            </div>
        </form>
    </div>
</div>
@endsection 