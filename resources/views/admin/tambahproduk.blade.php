@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h1>
            <a href="{{ route('admin.produk.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <p class="mb-6 text-gray-600">Gunakan form ini untuk menambah produk baru ke sistem. Untuk menambah denom/top up, silakan klik nama produk di halaman Kelola Produk.</p>

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
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Produk -->
                    <div>
                        <label for="product_name" class="block mb-2 font-semibold text-gray-700">Nama Produk *</label>
                        <input type="text" 
                               id="product_name" 
                               name="product_name" 
                               value="{{ old('product_name') }}"
                               placeholder="Contoh: Mobile Legends, Voucher Google Play, Pulsa Telkomsel" 
                               required 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori_id" class="block mb-2 font-semibold text-gray-700">Kategori Produk *</label>
                        <select id="kategori_id" 
                                name="kategori_id" 
                                required 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                               value="{{ old('developer') }}"
                               placeholder="Contoh: Moonton, Garena, Tencent" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Kode Digiflazz -->
                    <div>
                        <label for="kode_digiflazz" class="block mb-2 font-semibold text-gray-700">Kode Digiflazz</label>
                        <input type="text" 
                               id="kode_digiflazz" 
                               name="kode_digiflazz" 
                               value="{{ old('kode_digiflazz') }}"
                               placeholder="Contoh: mlbb, freefire, pubgm" 
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Digunakan untuk sync denom dari Digiflazz</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="is_active" class="block mb-2 font-semibold text-gray-700">Status</label>
                        <select id="is_active" 
                                name="is_active" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <!-- Popular -->
                    <div>
                        <label for="is_popular" class="block mb-2 font-semibold text-gray-700">Produk Populer</label>
                        <select id="is_popular" 
                                name="is_popular" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="1" {{ old('is_popular', '1') == '1' ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('is_popular') == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <!-- Logo -->
                    <div class="md:col-span-2">
                        <label for="logo" class="block mb-2 font-semibold text-gray-700">Logo Produk</label>
                        <div class="flex items-center space-x-4">
                            @if(isset($product) && $product->thumbnail_url)
                                <div class="w-32 h-32 border-2 border-dashed border-gray-300 flex items-center justify-center rounded-lg hover:border-blue-500 cursor-pointer">
                                    <img src="{{ asset('image/' . $product->thumbnail_url) }}" 
                                         alt="Logo {{ $product->product_name }}" 
                                         class="w-16 h-16 object-cover rounded">
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" 
                                       id="logo" 
                                       name="logo" 
                                       accept="image/*"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Banner Produk -->
                    <div class="md:col-span-2">
                        <label for="banner" class="block mb-2 font-semibold text-gray-700">Banner Produk</label>
                        <input type="file" 
                               id="banner" 
                               name="banner" 
                               accept="image/*"
                               class="flex-1 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 4MB</p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="description" class="block mb-2 font-semibold text-gray-700">Deskripsi</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Deskripsi singkat tentang produk..."
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <!-- Instruksi Akun -->
                    <div class="md:col-span-2">
                        <label for="account_instruction" class="block mb-2 font-semibold text-gray-700">Instruksi Akun (Akan tampil di halaman pembeli)</label>
                        <textarea id="account_instruction"
                                  name="account_instruction"
                                  rows="2"
                                  placeholder="Contoh: Masukkan User ID dan Server sesuai petunjuk di aplikasi."
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('account_instruction') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.produk.index') }}" 
                       class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
