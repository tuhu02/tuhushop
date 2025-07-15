@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Import Denom dari Digiflazz</h1>
    
    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6">
        <p><strong>Info:</strong> Digiflazz API sudah terkonfigurasi. Anda dapat mengimport denom langsung dari Digiflazz.</p>
    </div>
    
    <!-- Test Connection Button -->
    <div class="mb-6">
        <a href="{{ route('admin.denom.importDigiflazz', ['test_connection' => 1]) }}" 
           class="px-4 py-2 bg-green-600 text-white rounded mr-2">
            Test: Cek Koneksi Digiflazz
        </a>
    </div>
    
    <!-- Import Form -->
    <form method="GET" action="{{ route('admin.denom.importDigiflazz') }}" class="mb-6">
        <div class="mb-4">
            <label for="game_name" class="block mb-2 font-semibold">Filter Game (Opsional)</label>
            <input type="text" name="game_name" id="game_name" class="border rounded px-3 py-2 w-full max-w-md" 
                   placeholder="Contoh: Free Fire, Mobile Legends" value="{{ request('game_name') }}">
            <p class="text-sm text-gray-600 mt-1">Kosongkan untuk import semua game</p>
        </div>
        
        <div class="flex gap-4">
            <button type="submit" name="import" value="1" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Import Denom
            </button>
            <button type="submit" name="debug" value="1" class="px-6 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                Debug Import
            </button>
        </div>
    </form>
    
    <!-- Available Games List -->
    @if(!empty($games))
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Game yang Tersedia di Digiflazz:</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach(array_slice($games, 0, 20) as $game)
            <div class="border rounded p-3 bg-gray-50">
                <span class="text-sm">{{ $game }}</span>
            </div>
            @endforeach
            @if(count($games) > 20)
            <div class="border rounded p-3 bg-gray-50">
                <span class="text-sm text-gray-600">... dan {{ count($games) - 20 }} game lainnya</span>
            </div>
            @endif
        </div>
    </div>
    @endif
    
    <!-- Alternative Options -->
    <div class="mt-8 pt-6 border-t">
        <h2 class="text-xl font-bold mb-4">Opsi Lainnya:</h2>
        <div class="flex gap-4">
            <a href="{{ route('admin.denom.manual') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Tambah Manual
            </a>
        </div>
    </div>
</div>
@endsection 