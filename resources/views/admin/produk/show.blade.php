@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="flex items-center mb-6">
        <img src="{{ asset('image/' . $game->thumbnail_url) }}" alt="{{ $game->game_name }}" class="w-16 h-16 object-cover rounded mr-4 border shadow">
        <div>
            <h1 class="text-2xl font-bold mb-1">{{ $game->game_name }}</h1>
            <div class="text-gray-500">{{ $game->developer }}</div>
        </div>
        <a href="{{ route('admin.kelolaProduk') }}" class="ml-auto bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Kembali</a>
    </div>
    <div class="mb-6">
        <form action="{{ route('admin.denom.store') }}" method="POST" class="flex gap-2 items-center bg-gray-50 p-3 rounded">
            @csrf
            <input type="hidden" name="game_id" value="{{ $game->game_id }}">
            <input type="text" name="kode_produk" placeholder="Kode Produk" required class="border rounded px-2 py-1 w-24">
            <input type="text" name="nama_produk" placeholder="Nama Produk" required class="border rounded px-2 py-1 w-32">
            <input type="text" name="denom" placeholder="Denom" required class="border rounded px-2 py-1 w-20">
            <input type="number" name="harga" placeholder="Harga" required class="border rounded px-2 py-1 w-24">
            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Tambah Denom</button>
        </form>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($game->priceLists as $denom)
            <div class="bg-white border rounded shadow-sm p-4 flex flex-col justify-between">
                <div>
                    <div class="font-semibold text-base mb-1">{{ $denom->denom ?? $denom->nama_produk ?? '-' }}</div>
                    <div class="text-xs text-gray-500 mb-1">Kode: {{ $denom->kode_produk ?? '-' }}</div>
                    <div class="text-teal-600 font-bold text-lg mb-2">Rp {{ number_format($denom->harga ?? 0) }}</div>
                </div>
                <div class="flex gap-2 mt-2">
                    <button class="flex-1 bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 text-xs" disabled>Edit</button>
                    <form action="{{ route('admin.denom.destroy', $denom->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus denom ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 text-xs">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection 