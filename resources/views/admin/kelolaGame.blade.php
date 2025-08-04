@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <h1 class="text-2xl font-bold mb-6">Kelola Produk</h1>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <table class="min-w-full text-left">
            <thead>
                <tr>
                    <th class="py-2">Thumbnail</th>
                    <th class="py-2">Nama Produk</th>
                    <th>Developer</th>
                    <th>Populer</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($games as $game)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                    <td class="py-2">
                        @if($game->thumbnail_url)
                            <img src="{{ asset('image/' . $game->thumbnail_url) }}" alt="Thumbnail" class="w-16 h-16 object-cover rounded shadow border" />
                        @else
                            <span class="text-gray-400 italic">No image</span>
                        @endif
                    </td>
                    <td class="py-2 font-semibold text-gray-900">{{ $game->product_name }}</td>
                    <td>{{ $game->developer }}</td>
                    <td>
                        <form action="{{ route('admin.games.togglePopular', $game->product_id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="checkbox" name="is_popular" onchange="this.form.submit()" {{ $game->is_popular ? 'checked' : '' }}>
                        </form>
                    </td>
                    <td class="flex gap-2 items-center">
                        <a href="{{ route('admin.games.edit', $game->product_id) }}" 
                           class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm">Edit</a>
                        <form action="{{ route('admin.games.destroy', $game->product_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm"
                                    onclick="return confirm('Yakin ingin menghapus game ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 