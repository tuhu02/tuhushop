@extends('layouts.admin')

@section('content')
<div class="ml-64 p-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Bundling Produk</h1>
        <a href="{{ route('admin.bundles.create') }}" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition-colors">
            + Tambah Bundling
        </a>
    </div>
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="py-2">Nama Bundling</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bundles as $bundle)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 font-semibold text-gray-900">{{ $bundle->name }}</td>
                        <td>Rp {{ number_format($bundle->price) }}</td>
                        <td>
                            <span class="px-2 py-1 text-xs rounded-full {{ $bundle->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($bundle->status) }}
                            </span>
                        </td>
                        <td>{{ $bundle->products->count() }}</td>
                        <td>
                            <a href="{{ route('admin.bundles.edit', $bundle) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('admin.bundles.destroy', $bundle) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus bundling ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-gray-500 py-6">Belum ada bundling.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $bundles->links() }}</div>
    </div>
</div>
@endsection 