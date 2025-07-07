@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <h1 class="text-2xl font-bold mb-4">Kelola Promo/Offer untuk {{ $product->product_name ?? 'Produk' }}</h1>
    @if(isset($product))
        <a href="{{ route('admin.special-offers.create', ['product_id' => $product->product_id]) }}" class="bg-teal-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Promo/Offer</a>
    @else
        <form action="" method="GET" class="mb-4 flex gap-2">
            <select name="product_id" class="border rounded px-2 py-1" required>
                <option value="">Pilih Produk</option>
                @foreach($products as $prod)
                    <option value="{{ $prod->product_id }}">{{ $prod->product_name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded">Lihat Promo/Offer</button>
        </form>
    @endif
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
    @endif
    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="px-4 py-2">Tipe</th>
                <th class="px-4 py-2">Judul</th>
                <th class="px-4 py-2">Icon</th>
                <th class="px-4 py-2">Aktif</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offers as $offer)
            <tr>
                <td class="border px-4 py-2">{{ $offer->type }}</td>
                <td class="border px-4 py-2">{{ $offer->title }}</td>
                <td class="border px-4 py-2"><i class="{{ $offer->icon }}"></i> {{ $offer->icon }}</td>
                <td class="border px-4 py-2">{{ $offer->active ? 'Ya' : 'Tidak' }}</td>
                <td class="border px-4 py-2">
                    <a href="{{ route('admin.special-offers.edit', $offer->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.special-offers.destroy', $offer->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 