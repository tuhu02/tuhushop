@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Produk</h1>
        <div class="flex items-start space-x-6">
            <div>
                <img src="{{ asset('image/' . $product->thumbnail_url) }}" alt="{{ $product->product_name }}" class="w-32 h-32 object-cover rounded-lg border">
            </div>
            <div>
                <h2 class="text-xl font-semibold">{{ $product->product_name }}</h2>
                <p class="text-gray-600 mb-2">Developer: {{ $product->developer }}</p>
                <p class="text-gray-600 mb-2">Kategori: {{ $product->kategori->nama ?? '-' }}</p>
                <p class="text-gray-600 mb-2">Deskripsi: {{ $product->description ?? '-' }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.produk.edit', $product->product_id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mr-2">Edit</a>
                    <a href="{{ route('admin.kelolaProduk') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Form Tambah Denom -->
    <div class="bg-white rounded-lg shadow p-6 mt-8">
        <h2 class="text-lg font-semibold mb-4">Tambah Denom</h2>
        <form action="{{ route('admin.denom.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-1">Nama Denom *</label>
                    <input type="text" id="nama_produk" name="nama_produk" required class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga *</label>
                    <input type="number" id="harga" name="harga" required min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="harga_member" class="block text-sm font-medium text-gray-700 mb-1">Harga Member</label>
                    <input type="number" id="harga_member" name="harga_member" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="profit" class="block text-sm font-medium text-gray-700 mb-1">Profit</label>
                    <input type="number" id="profit" name="profit" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label for="provider" class="block text-sm font-medium text-gray-700 mb-1">Provider</label>
                    <select id="provider" name="provider" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="Digiflazz">Digiflazz</option>
                        <option value="DuniaGames">DuniaGames</option>
                        <option value="Unipin">Unipin</option>
                    </select>
                </div>
                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="kategori" name="kategori" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="diamond">Diamond</option>
                        <option value="nondiamond">Non Diamond</option>
                    </select>
                </div>
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo Denom</label>
                    <input type="file" id="logo" name="logo" accept="image/*" class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Tambah Denom</button>
            </div>
        </form>
    </div>
    <!-- Tabel Daftar Denom -->
    @if($product->priceLists->count())
        <div class="bg-white rounded-lg shadow p-6 mt-8">
            <h2 class="text-lg font-semibold mb-4">Daftar Denom</h2>
            <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Nama Denom</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Harga</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Harga Member</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Kategori</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Provider</th>
                        <th class="px-4 py-2 border text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($product->priceLists as $denom)
                        <tr class="even:bg-gray-50 hover:bg-blue-50">
                            <td class="px-4 py-2 border text-sm font-medium text-gray-900 text-center whitespace-nowrap">{{ $denom->nama_produk }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->harga) }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">Rp{{ number_format($denom->harga_member) }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">{{ $denom->kategori }}</td>
                            <td class="px-4 py-2 border text-sm text-gray-900 text-center whitespace-nowrap">{{ $denom->provider }}</td>
                            <td class="px-4 py-2 border text-sm font-medium text-center whitespace-nowrap">
                                <a href="{{ route('admin.denom.edit', $denom->id) }}" class="text-green-600 hover:text-green-800 mr-2">Edit</a>
                                <form action="{{ route('admin.denom.destroy', $denom->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus denom ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-6 mt-8">
            <p class="text-gray-500">Belum ada denom untuk produk ini.</p>
        </div>
    @endif
</div>
@endsection 