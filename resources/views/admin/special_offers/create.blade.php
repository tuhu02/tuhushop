@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <h1 class="text-2xl font-bold mb-4">Tambah Promo/Offer untuk {{ $product->product_name ?? 'Produk' }}</h1>
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.special-offers.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
        <div>
            <label class="block font-semibold">Tipe</label>
            <input type="text" name="type" class="border rounded px-2 py-1 w-full" required>
        </div>
        <div>
            <label class="block font-semibold">Judul</label>
            <input type="text" name="title" class="border rounded px-2 py-1 w-full" required>
        </div>
        <div>
            <label class="block font-semibold">Icon (opsional)</label>
            <input type="text" name="icon" class="border rounded px-2 py-1 w-full">
        </div>
        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" name="active" class="mr-2" checked>
                Aktif
            </label>
        </div>
        <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('admin.special-offers.index', ['product_id' => $product->product_id]) }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </form>
</div>
@endsection 