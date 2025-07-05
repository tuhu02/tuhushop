@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Bundling Produk</h1>
        <form action="{{ route('admin.bundles.update', $bundle) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-medium text-gray-700 mb-1">Nama Bundling</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required value="{{ old('name', $bundle->name) }}">
                @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $bundle->description) }}</textarea>
                @error('description')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Gambar Bundling</label>
                @if($bundle->image)
                    <img src="{{ asset('storage/'.$bundle->image) }}" alt="Gambar" class="h-20 mb-2 rounded">
                @endif
                <input type="file" name="image" class="w-full border rounded px-3 py-2">
                @error('image')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Harga Bundling</label>
                <input type="number" name="price" class="w-full border rounded px-3 py-2" required min="0" value="{{ old('price', $bundle->price) }}">
                @error('price')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="active" {{ old('status', $bundle->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ old('status', $bundle->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block font-medium text-gray-700 mb-1">Pilih Produk (dan Jumlah per Produk)</label>
                <div class="space-y-2">
                    @foreach($products as $product)
                    @php
                        $checked = $bundle->products->contains($product->id);
                        $qty = $checked ? $bundle->products->find($product->id)->pivot->quantity : 1;
                    @endphp
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="products[]" value="{{ $product->id }}" id="product-{{ $product->id }}" {{ $checked ? 'checked' : '' }}>
                        <label for="product-{{ $product->id }}" class="flex-1">
                            {{ $product->game ? $product->game->name : '-' }} - {{ $product->name }} <span class="text-gray-500">(Rp {{ number_format($product->price) }})</span>
                        </label>
                        <input type="number" name="quantities[]" min="1" value="{{ $qty }}" class="w-20 border rounded px-2 py-1" placeholder="Qty">
                    </div>
                    @endforeach
                </div>
                @error('products')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
                @error('quantities')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="pt-4">
                <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Update Bundling</button>
                <a href="{{ route('admin.bundles.index') }}" class="ml-3 text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection 