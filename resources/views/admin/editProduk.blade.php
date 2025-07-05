@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
            <a href="{{ route('admin.produk.show', $product->product_id) }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.produk.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Produk -->
                    <div>
                        <label for="product_name" class="block mb-2 font-semibold text-gray-700">Nama Produk *</label>
                        <input type="text" 
                               id="product_name" 
                               name="product_name" 
                               value="{{ old('product_name', $product->product_name) }}"
                               required 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori_id" class="block mb-2 font-semibold text-gray-700">Kategori *</label>
                        <select id="kategori_id" 
                                name="kategori_id" 
                                required 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $product->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Developer -->
                    <div>
                        <label for="developer" class="block mb-2 font-semibold text-gray-700">Developer</label>
                        <input type="text" 
                               id="developer" 
                               name="developer" 
                               value="{{ old('developer', $product->developer) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Kode Digiflazz -->
                    <div>
                        <label for="kode_digiflazz" class="block mb-2 font-semibold text-gray-700">Kode Digiflazz</label>
                        <input type="text" 
                               id="kode_digiflazz" 
                               name="kode_digiflazz" 
                               value="{{ old('kode_digiflazz', $product->kode_digiflazz) }}"
                               placeholder="Contoh: mlbb, freefire, pubgm"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Digunakan untuk sync denom dari Digiflazz</p>
                    </div>

                    <!-- Logo -->
                    <div class="md:col-span-2">
                        <label for="logo" class="block mb-2 font-semibold text-gray-700">Logo Produk</label>
                        <div class="flex items-center space-x-4">
                            @if($product->thumbnail_url)
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('image/' . $product->thumbnail_url) }}" 
                                         alt="Logo {{ $product->product_name }}" 
                                         class="w-16 h-16 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" 
                                   id="logo" 
                                   name="logo" 
                                   accept="image/*"
                                   class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                    </div>

                    <!-- Banner -->
                    <div class="md:col-span-2">
                        <label for="banner" class="block mb-2 font-semibold text-gray-700">Banner Produk</label>
                        <div class="flex items-center space-x-4">
                            @if($product->banner_url)
                                <div class="w-40 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <img src="{{ asset('image/' . $product->banner_url) }}" 
                                         alt="Banner {{ $product->product_name }}" 
                                         class="w-36 h-20 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" 
                                   id="banner" 
                                   name="banner" 
                                   accept="image/*"
                                   class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 4MB</p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="description" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="is_active" class="block mb-2 font-semibold text-gray-700">Status</label>
                        <select id="is_active" 
                                name="is_active" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="1" {{ old('is_active', $product->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $product->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <!-- Popular -->
                    <div>
                        <label for="is_popular" class="block mb-2 font-semibold text-gray-700">Produk Populer</label>
                        <select id="is_popular" 
                                name="is_popular" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="1" {{ old('is_popular', $product->is_popular) == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('is_popular', $product->is_popular) == 0 ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.produk.show', $product->product_id) }}" 
                       class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 