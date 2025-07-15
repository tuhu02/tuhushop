@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
    <h3 class="text-2xl font-bold mb-6">Import Denom</h3>

    {{-- Tombol Import Utama --}}
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.denom.importDigiflazz') }}" class="px-4 py-2 bg-cyan-600 text-white rounded shadow hover:bg-cyan-700 transition">
            Import dari Digiflazz
        </a>
        <a href="{{ route('admin.denom.create') }}" class="px-4 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700 transition">
            Tambah Denom Manual
        </a>
    </div>

    {{-- Tombol Debug/Test --}}
    <div class="mb-8">
        <h5 class="text-lg font-semibold mb-2">Debug & Test API</h5>
        <div class="flex flex-wrap gap-2">
            <a href="#" class="px-3 py-1 bg-yellow-400 text-gray-900 rounded hover:bg-yellow-500 transition">Debug: Cek Project List dari API</a>
            <a href="#" class="px-3 py-1 bg-blue-400 text-white rounded hover:bg-blue-500 transition">Test: Cek Denom Free Fire (ID: 1)</a>
            <a href="#" class="px-3 py-1 bg-cyan-400 text-white rounded hover:bg-cyan-500 transition">Test: Struktur API Berbeda</a>
            <a href="#" class="px-3 py-1 bg-purple-400 text-white rounded hover:bg-purple-500 transition">Test: Cek Semua Parameter Voucher</a>
            <a href="#" class="px-3 py-1 bg-pink-500 text-white rounded hover:bg-pink-600 transition">Test: Comprehensive Voucher</a>
            <a href="#" class="px-3 py-1 bg-gray-700 text-white rounded hover:bg-gray-800 transition">Check: Semua Endpoint</a>
        </div>
    </div>

    {{-- Form/Dropdown Import Denom --}}
    <form>
        <div class="flex flex-wrap items-center gap-4 mb-4">
            <select class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option>Pilih Project/Game</option>
                {{-- Tambahkan opsi project/game di sini --}}
            </select>
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Tampilkan Denom</button>
        </div>
    </form>
</div>
@endsection 