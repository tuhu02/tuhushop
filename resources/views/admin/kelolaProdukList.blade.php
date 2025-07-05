{{-- resources/views/admin/kelolaProdukList.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
        <a href="{{ route('admin.produk.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-box text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Produk</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Aktif</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->where('is_active', 1)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Populer</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->where('is_popular', 1)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-tags text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kategori</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $products->unique('kategori_id')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Produk</h2>
        </div>  
        
        <div class="p-6">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start space-x-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    @if($product->thumbnail_url)
                                    <img src="{{ asset('storage/'.$product->thumbnail_url) }}" 
                                        alt="{{ $product->product_name }}" 
                                        class="w-16 h-16 object-cover rounded-lg border">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">
                                        <a href="{{ route('admin.produk.show', $product->product_id) }}" 
                                           class="hover:text-blue-600">
                                            {{ $product->product_name }}
                                        </a>
                                    </h3>
                                    
                                    @if($product->kategori)
                                        <p class="text-sm text-gray-600 mb-1">
                                            <i class="fas fa-tag mr-1"></i>{{ $product->kategori->nama }}
                                        </p>
                                    @endif
                                    
                                    @if($product->developer)
                                        <p class="text-sm text-gray-600 mb-1">
                                            <i class="fas fa-building mr-1"></i>{{ $product->developer }}
                                        </p>
                                    @endif

                                    <!-- Status Badges -->
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @if($product->is_active)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>Nonaktif
                                            </span>
                                        @endif

                                        @if($product->is_popular)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-star mr-1"></i>Populer
                                            </span>
                                        @endif

                                        @if($product->kode_digiflazz)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-sync mr-1"></i>Digiflazz
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2 mt-3">
                                        <a href="{{ route('admin.produk.show', $product->product_id) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fas fa-eye mr-1"></i>Detail
                                        </a>
                                        <a href="{{ route('admin.produk.edit', $product->product_id) }}" 
                                           class="text-green-600 hover:text-green-800 text-sm font-medium">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.produk.destroy', $product->product_id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                <i class="fas fa-trash mr-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-box text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
                    <p class="text-gray-600 mb-4">Mulai dengan menambahkan produk pertama Anda</p>
                    <a href="{{ route('admin.produk.create') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 