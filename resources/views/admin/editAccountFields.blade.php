@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Struktur Form Akun: {{ $product->product_name }}</h1>
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('admin.admin.account_fields.update', $product->product_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="account_fields" class="block text-sm font-medium text-gray-700 mb-1">Struktur Form Akun (JSON)</label>
                <textarea id="account_fields" name="account_fields" rows="8" required class="w-full border border-gray-300 rounded-md px-3 py-2">{{ old('account_fields', json_encode($product->account_fields, JSON_PRETTY_PRINT)) }}</textarea>
                <small class="text-gray-500">Contoh: [ {"label": "ID", "name": "user_id", "type": "text"}, {"label": "Server", "name": "server", "type": "text"} ]</small>
            </div>
            <div class="flex justify-end">
                <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection 