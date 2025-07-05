<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <x-admin-sidebar />
    <div class="ml-64">
        <!-- Seluruh konten produk mulai di sini -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
                        <p class="text-sm text-gray-600">Manajemen semua produk game</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.tambahProduk') }}" 
                           class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Tambah Produk
                        </a>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>Sync Digiflazz
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                <!-- Filters and Search -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                            <div class="relative">
                                <input type="text" 
                                       placeholder="Cari berdasarkan nama game atau kategori..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <option value="">Semua Kategori</option>
                                <option value="mobile-legends">Mobile Legends</option>
                                <option value="pubg-mobile">PUBG Mobile</option>
                                <option value="free-fire">Free Fire</option>
                                <option value="genshin-impact">Genshin Impact</option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Produk</p>
                                <p class="text-2xl font-bold text-gray-900">156</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-gamepad text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Aktif</p>
                                <p class="text-2xl font-bold text-green-600">142</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Tidak Aktif</p>
                                <p class="text-2xl font-bold text-red-600">14</p>
                            </div>
                            <div class="p-3 bg-red-100 rounded-full">
                                <i class="fas fa-times-circle text-red-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Kategori</p>
                                <p class="text-2xl font-bold text-purple-600">8</p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full">
                                <i class="fas fa-tags text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Daftar Produk</h3>
                            <div class="flex items-center space-x-2">
                                <button class="p-2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button class="p-2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            <!-- Product Card 1 -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                <div class="relative">
                                    <img src="{{ asset('image/mlbb.png') }}" alt="Mobile Legends" class="w-full h-48 object-cover rounded-t-xl">
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Mobile Legends</h4>
                                    <p class="text-sm text-gray-600 mb-3">100 Diamonds</p>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-lg font-bold text-teal-600">Rp 50,000</span>
                                        <span class="text-sm text-gray-500">Stok: 999</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button class="flex-1 bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Card 2 -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                <div class="relative">
                                    <img src="{{ asset('image/pubgm.jpg') }}" alt="PUBG Mobile" class="w-full h-48 object-cover rounded-t-xl">
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">PUBG Mobile</h4>
                                    <p class="text-sm text-gray-600 mb-3">500 UC</p>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-lg font-bold text-teal-600">Rp 100,000</span>
                                        <span class="text-sm text-gray-500">Stok: 500</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button class="flex-1 bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Card 3 -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                <div class="relative">
                                    <img src="{{ asset('image/freefire.jpg') }}" alt="Free Fire" class="w-full h-48 object-cover rounded-t-xl">
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Tidak Aktif
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Free Fire</h4>
                                    <p class="text-sm text-gray-600 mb-3">1000 Diamonds</p>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-lg font-bold text-teal-600">Rp 150,000</span>
                                        <span class="text-sm text-gray-500">Stok: 0</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button class="flex-1 bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Card 4 -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                <div class="relative">
                                    <img src="{{ asset('image/genshin.jpeg') }}" alt="Genshin Impact" class="w-full h-48 object-cover rounded-t-xl">
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Genshin Impact</h4>
                                    <p class="text-sm text-gray-600 mb-3">648 Genesis Crystals</p>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-lg font-bold text-teal-600">Rp 200,000</span>
                                        <span class="text-sm text-gray-500">Stok: 100</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button class="flex-1 bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Card 5 -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                <div class="relative">
                                    <img src="{{ asset('image/cod.jpg') }}" alt="Call of Duty Mobile" class="w-full h-48 object-cover rounded-t-xl">
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Call of Duty Mobile</h4>
                                    <p class="text-sm text-gray-600 mb-3">1000 CP</p>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-lg font-bold text-teal-600">Rp 120,000</span>
                                        <span class="text-sm text-gray-500">Stok: 250</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button class="flex-1 bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Card 6 -->
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                <div class="relative">
                                    <img src="{{ asset('image/valorant.jpg') }}" alt="Valorant" class="w-full h-48 object-cover rounded-t-xl">
                                    <div class="absolute top-2 right-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Maintenance
                                        </span>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Valorant</h4>
                                    <p class="text-sm text-gray-600 mb-3">1000 VP</p>
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-lg font-bold text-teal-600">Rp 180,000</span>
                                        <span class="text-sm text-gray-500">Stok: 75</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <button class="flex-1 bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-700">Show</span>
                                <select class="text-sm border border-gray-300 rounded px-2 py-1">
                                    <option>12</option>
                                    <option>24</option>
                                    <option>48</option>
                                </select>
                                <span class="text-sm text-gray-700">entries</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">Previous</button>
                                <button class="px-3 py-1 text-sm bg-teal-600 text-white rounded">1</button>
                                <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">2</button>
                                <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">3</button>
                                <button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
