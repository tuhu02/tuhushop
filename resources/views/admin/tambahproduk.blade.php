<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Tambah Item Game</title>
    @vite('resources/css/app.css')
</head>
<body class="flex bg-gray-100 min-h-screen">
    <!-- Sidebar -->
    <x-admin-sidebar />

    <!-- Konten Utama -->
    <div class="flex-1 ml-64 p-5">
        <h1 class="text-2xl font-semibold mb-5">Tambah Item Game</h1>
        <form action="/game-items/store" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf <!-- Untuk keamanan Laravel -->

            <!-- Input Nama Game -->
            <div>
                <label for="game-name" class="block text-sm font-medium text-gray-700 mb-2">Nama Game</label>
                <input 
                    type="text" 
                    id="game-name" 
                    name="game_name" 
                    placeholder="Masukkan nama game, contoh: 'Mobile Legends'" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Input Nama Paket -->
            <div>
                <label for="package-name" class="block text-sm font-medium text-gray-700 mb-2">Nama Paket</label>
                <input 
                    type="text" 
                    id="package-name" 
                    name="package_name" 
                    placeholder="Masukkan nama paket, contoh: 'Diamond Paket A'" 
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Input Gambar -->
            <div>
                <label for="image-upload" class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar</label>
                <div class="w-40 h-40 border-2 border-dashed border-gray-300 flex items-center justify-center rounded-md hover:border-blue-500 cursor-pointer">
                    <label for="image-upload" class="flex flex-col items-center cursor-pointer">
                        <svg
                            class="w-12 h-12 text-gray-400 hover:text-blue-500"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16l5.586-5.586a1 1 0 011.414 0L16 17M16 17l5-5M5 18H19M10 6H4m16 0h-4M6 4v4m12-4v4" />
                        </svg>
                        <span class="mt-2 text-sm text-gray-500">Upload Image</span>
                    </label>
                </div>
                <input id="image-upload" name="image" type="file" accept="image/*" class="hidden" />
            </div>

            <!-- Input Denom atau Item -->
            <div id="item-container" class="space-y-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Item dan Harga</label>
                <div class="flex items-center space-x-4">
                    <input 
                        type="text" 
                        name="item[]" 
                        placeholder="Masukkan item, contoh: 100 Diamond / Skin Epic" 
                        class="w-1/2 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <input 
                        type="number" 
                        name="harga[]" 
                        placeholder="Masukkan harga, contoh: 15000" 
                        class="w-1/2 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button 
                        type="button" 
                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600" 
                        onclick="addItem()">
                        Tambah
                    </button>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div>
                <button 
                    type="submit" 
                    class="w-full bg-blue-500 text-white font-semibold py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
    
    <script>
        function addItem() {
            const container = document.getElementById('item-container');
            const newItem = document.createElement('div');
            newItem.className = 'flex items-center space-x-4 mt-2';

            newItem.innerHTML = `
                <input 
                    type="text" 
                    name="item[]" 
                    placeholder="Masukkan item, contoh: 100 Diamond / Skin Epic" 
                    class="w-1/2 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <input 
                    type="number" 
                    name="harga[]" 
                    placeholder="Masukkan harga, contoh: 15000" 
                    class="w-1/2 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button 
                    type="button" 
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600" 
                    onclick="removeItem(this)">
                    Hapus
                </button>
            `;
            container.appendChild(newItem);
        }

        function removeItem(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>
