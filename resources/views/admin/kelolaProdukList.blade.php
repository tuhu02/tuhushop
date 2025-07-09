{{-- resources/views/admin/kelolaProdukList.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="ml-64 bg-gray-50 min-h-screen">
    <div class="p-8">
        {{-- Header Halaman --}}
        <div class="flex items-center justify-between pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Produk</h1>
            <a href="{{ route('admin.produk.create') }}" 
               class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                <span>Tambah Produk</span>
            </a>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="mt-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-200 flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-600"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200 flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-red-600"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 my-8">
            @php
                $stats = [
                    ['icon' => 'fa-box', 'color' => 'blue', 'title' => 'Total Produk', 'value' => $products->count()],
                    ['icon' => 'fa-check-circle', 'color' => 'green', 'title' => 'Aktif', 'value' => $products->where('is_active', 1)->count()],
                    ['icon' => 'fa-star', 'color' => 'yellow', 'title' => 'Populer', 'value' => $products->where('is_popular', 1)->count()],
                    ['icon' => 'fa-tags', 'color' => 'purple', 'title' => 'Kategori Unik', 'value' => $products->unique('kategori_id')->count()],
                ];
            @endphp

            @foreach ($stats as $stat)
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-600">
                        <i class="fas {{ $stat['icon'] }} text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">{{ $stat['title'] }}</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Kontainer Daftar Produk --}}
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Daftar Produk</h2>
                    <form method="GET" class="flex items-center gap-2">
                        <label for="kategori_id" class="text-sm text-gray-700">Filter Kategori:</label>
                        <select name="kategori_id" id="kategori_id" class="border rounded px-2 py-1" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @isset($kategoris)
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <label for="sort" class="text-sm text-gray-700">Urutkan:</label>
                        <select name="sort" id="sort" class="border rounded px-2 py-1" onchange="this.form.submit()">
                            <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                            <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Populer</option>
                            <option value="aktif" {{ request('sort') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="kategori_asc" {{ request('sort') == 'kategori_asc' ? 'selected' : '' }}>Kategori A-Z</option>
                            <option value="kategori_desc" {{ request('sort') == 'kategori_desc' ? 'selected' : '' }}>Kategori Z-A</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="p-6">
                @if($products->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1 flex flex-col">
                                <div class="p-5 flex-grow">
                                    <div class="flex items-start space-x-4">
                                        {{-- Gambar Produk --}}
                                        <div class="flex-shrink-0">
                                            @if($product->thumbnail_url)
                                                <img src="{{ asset('image/'.$product->thumbnail_url) }}" alt="{{ $product->product_name }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                                            @else
                                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center border">
                                                    <i class="fas fa-image text-gray-400 text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Info Produk --}}
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-bold text-gray-800 truncate leading-tight">
                                                <a href="{{ route('admin.produk.show', $product->product_id) }}" class="hover:text-blue-600 transition-colors">
                                                    {{ $product->product_name }}
                                                </a>
                                            </h3>
                                            
                                            @if($product->kategori)
                                                <p class="text-sm text-gray-500 mt-1 flex items-center">
                                                    <i class="fas fa-tag mr-2 text-gray-400"></i>{{ $product->kategori->nama }}
                                                </p>
                                            @endif
                                            
                                            @if($product->developer)
                                                <p class="text-sm text-gray-500 mt-1 flex items-center">
                                                    <i class="fas fa-building mr-2 text-gray-400"></i>{{ $product->developer }}
                                                </p>
                                            @endif

                                            {{-- Badge Status --}}
                                            <div class="flex flex-wrap gap-2 mt-3">
                                                <span @class([
                                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                    'bg-green-100 text-green-800' => $product->is_active,
                                                    'bg-red-100 text-red-800' => !$product->is_active,
                                                ])>
                                                    <i @class(['fas mr-1.5', 'fa-check-circle' => $product->is_active, 'fa-times-circle' => !$product->is_active])></i>
                                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>

                                                @if($product->is_popular)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-star mr-1.5"></i>Populer
                                                    </span>
                                                @endif

                                                @if($product->kode_digiflazz)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        <i class="fas fa-sync-alt mr-1.5"></i>Digiflazz
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Tombol Aksi --}}
                                <div class="px-5 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.produk.show', $product->product_id) }}" class="text-gray-500 hover:text-blue-600 transition-colors" title="Detail">
                                        <i class="fas fa-eye fa-fw"></i>
                                    </a>
                                    <a href="{{ route('admin.produk.edit', $product->product_id) }}" class="text-gray-500 hover:text-green-600 transition-colors" title="Edit">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $product->product_id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-500 hover:text-red-600 transition-colors" title="Hapus">
                                            <i class="fas fa-trash fa-fw"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Kondisi Jika Produk Kosong --}}
                    <div class="text-center py-16">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-box-open fa-4x"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Produk</h3>
                        <p class="text-gray-500 mb-6">Mulai dengan menambahkan produk pertama Anda.</p>
                        <a href="{{ route('admin.produk.create') }}" class="inline-flex items-center bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-transform transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>
                            <span>Tambah Produk</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection