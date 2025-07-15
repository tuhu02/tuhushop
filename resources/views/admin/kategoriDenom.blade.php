@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Kelola Kategori Denom</h1>
        <p class="text-gray-600 mb-6">Halaman ini untuk mengelola kategori denom seperti Weekly, Membership, Diamond, dsb.</p>
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
        @endif
        <!-- Add/Edit Category Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                {{ isset($kategoriDenom) ? 'Edit Kategori Denom' : 'Tambah Kategori Denom Baru' }}
            </h2>
            <form action="{{ isset($kategoriDenom) ? route('admin.kategori-denom.update', $kategoriDenom->id) : route('admin.kategori-denom.store') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                @csrf
                @if(isset($kategoriDenom))
                    @method('PUT')
                @endif
                <div class="flex-1 min-w-[180px]">
                    <input type="text" name="nama" placeholder="Nama Kategori (misal: Weekly, Membership)" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('nama', $kategoriDenom->nama ?? '') }}">
                </div>
                <div class="flex-1 min-w-[180px]">
                    <input type="text" name="slug" placeholder="Slug unik (misal: weekly, membership)" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old('slug', $kategoriDenom->slug ?? '') }}">
                </div>
                <div class="flex-1 min-w-[180px]">
                    <select name="product_id" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->product_id }}" {{ old('product_id', $kategoriDenom->product_id ?? '') == $product->product_id ? 'selected' : '' }}>{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>{{ isset($kategoriDenom) ? 'Update' : 'Tambah' }}
                </button>
                @if(isset($kategoriDenom))
                    <a href="{{ route('admin.kategori-denom.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                @endif
            </form>
        </div>
        <!-- Categories List -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Kategori Denom</h2>
            </div>
            <div class="p-6">
                @if($kategoriDenoms->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($kategoriDenoms as $kategori)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $kategori->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kategori->slug }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $kategori->product->product_name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.kategori-denom.edit', $kategori->id) }}" class="text-blue-600 hover:text-blue-900 mr-2"><i class="fas fa-edit mr-1"></i>Edit</a>
                                        <form action="{{ route('admin.kategori-denom.destroy', $kategori->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash mr-1"></i>Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-tags text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada kategori denom</h3>
                        <p class="text-gray-600">Mulai dengan menambahkan kategori denom pertama</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 