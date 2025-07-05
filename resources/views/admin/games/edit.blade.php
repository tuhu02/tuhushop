@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <h1 class="text-2xl font-bold mb-6">Edit Game</h1>
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-lg">
        <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama Game</label>
                <input type="text" name="product_name" value="{{ $product->product_name }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Developer</label>
                <input type="text" name="developer" value="{{ $product->developer }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Thumbnail</label>
                @if($product->thumbnail_url)
                    <img src="{{ asset('image/' . $product->thumbnail_url) }}" alt="Current thumbnail" class="w-20 h-20 object-cover rounded border">
                @endif
                <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                <small class="text-gray-500">Biarkan kosong jika tidak ingin mengubah thumbnail.</small>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kelolaGame') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection 