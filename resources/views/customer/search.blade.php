<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - Tuhu Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('customer.index') }}" class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-gamepad text-purple-600 text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">Tuhu Shop</h1>
                            <p class="text-sm opacity-90">Game Voucher & Top Up</p>
                        </div>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('customer.index') }}" class="hover:text-purple-200 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Shop
                    </a>
                    @auth
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="hover:text-purple-200 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-purple-200 transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Search Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-search text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Hasil Pencarian</h1>
                    <p class="text-gray-600">
                        @if($products->count() > 0)
                            Ditemukan {{ $products->count() }} produk untuk "{{ $query }}"
                        @else
                            Tidak ada produk ditemukan untuk "{{ $query }}"
                        @endif
                    </p>
                </div>
            </div>
            
            <!-- Search Form -->
            <form action="{{ route('customer.search') }}" method="GET" class="max-w-md">
                <div class="relative">
                    <input type="text" 
                           name="q" 
                           value="{{ $query }}"
                           placeholder="Cari produk..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <button type="submit" class="absolute left-3 top-3 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Results -->
        @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="product-card bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative">
                    @if($product->logo)
                        <img src="{{ Storage::url($product->logo) }}" 
                             alt="{{ $product->product_name }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    
                    @if($product->is_popular)
                        <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-star mr-1"></i>Populer
                        </div>
                    @endif
                    
                    @if($product->is_active == 0)
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                Tidak Tersedia
                            </span>
                        </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->product_name }}</h3>
                    
                    @if($product->kategori)
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full mb-2">
                            {{ $product->kategori->nama }}
                        </span>
                    @endif
                    
                    @if($product->developer)
                        <p class="text-sm text-gray-600 mb-3">
                            <i class="fas fa-building mr-1"></i>{{ $product->developer }}
                        </p>
                    @endif
                    
                    @if($product->description)
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>
                    @endif
                    
                    <!-- Features -->
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-bolt text-green-600 text-xs"></i>
                            <span class="text-xs text-gray-600">Instan</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-shield-alt text-blue-600 text-xs"></i>
                            <span class="text-xs text-gray-600">Aman</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <i class="fas fa-headset text-purple-600 text-xs"></i>
                            <span class="text-xs text-gray-600">24/7</span>
                        </div>
                    </div>
                    
                    @if($product->is_active)
                        <a href="{{ route('customer.product', $product->product_id) }}" 
                           class="block w-full bg-purple-600 text-white text-center py-2 rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </a>
                    @else
                        <button disabled 
                                class="block w-full bg-gray-400 text-white text-center py-2 rounded-lg cursor-not-allowed">
                            <i class="fas fa-times mr-2"></i>Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- No Results -->
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-search text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada hasil ditemukan</h3>
            <p class="text-gray-600 mb-6">Coba kata kunci lain atau lihat produk populer kami</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('customer.index') }}" 
                   class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Shop
                </a>
                <button onclick="clearSearch()" 
                        class="inline-block bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-times mr-2"></i>Hapus Pencarian
                </button>
            </div>
        </div>
        @endif

        <!-- Popular Searches -->
        @if($products->count() == 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pencarian Populer</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('customer.search', ['q' => 'mobile legends']) }}" 
                   class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow text-center">
                    <i class="fas fa-mobile-alt text-purple-600 text-2xl mb-2"></i>
                    <p class="font-semibold text-gray-800">Mobile Legends</p>
                </a>
                
                <a href="{{ route('customer.search', ['q' => 'pubg']) }}" 
                   class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow text-center">
                    <i class="fas fa-gamepad text-blue-600 text-2xl mb-2"></i>
                    <p class="font-semibold text-gray-800">PUBG Mobile</p>
                </a>
                
                <a href="{{ route('customer.search', ['q' => 'free fire']) }}" 
                   class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow text-center">
                    <i class="fas fa-fire text-orange-600 text-2xl mb-2"></i>
                    <p class="font-semibold text-gray-800">Free Fire</p>
                </a>
                
                <a href="{{ route('customer.search', ['q' => 'diamond']) }}" 
                   class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow text-center">
                    <i class="fas fa-gem text-cyan-600 text-2xl mb-2"></i>
                    <p class="font-semibold text-gray-800">Diamond</p>
                </a>
            </div>
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Tuhu Shop</h3>
                    <p class="text-gray-400">Platform terpercaya untuk pembelian game voucher dan top up dengan harga terbaik.</p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Produk</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Game Voucher</a></li>
                        <li><a href="#" class="hover:text-white">Top Up</a></li>
                        <li><a href="#" class="hover:text-white">Pulsa</a></li>
                        <li><a href="#" class="hover:text-white">E-Money</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Cara Beli</a></li>
                        <li><a href="#" class="hover:text-white">Metode Pembayaran</a></li>
                        <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i>support@tuhushop.com</li>
                        <li><i class="fas fa-phone mr-2"></i>+62 812-3456-7890</li>
                        <li><i class="fab fa-whatsapp mr-2"></i>WhatsApp Support</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Tuhu Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function clearSearch() {
            window.location.href = "{{ route('customer.index') }}";
        }
    </script>
</body>
</html> 