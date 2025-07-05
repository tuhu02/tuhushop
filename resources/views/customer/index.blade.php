<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuhu Shop - Beli Game Voucher & Top Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-gamepad text-purple-600 text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Tuhu Shop</h1>
                        <p class="text-sm opacity-90">Game Voucher & Top Up</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <form action="{{ route('customer.search') }}" method="GET" class="relative">
                        <input type="text" 
                               name="q" 
                               placeholder="Cari produk..." 
                               class="w-64 px-4 py-2 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-white">
                        <button type="submit" class="absolute right-3 top-2 text-gray-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    
                    <!-- Navigation -->
                    <nav class="flex items-center space-x-6">
                        <a href="{{ route('dashboard') }}" class="hover:text-purple-200 transition-colors">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                        <a href="{{ route('customer.index') }}" class="hover:text-purple-200 transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>Shop
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
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Selamat Datang di Tuhu Shop</h2>
            <p class="text-xl text-gray-600 mb-8">Temukan berbagai produk game, voucher, dan top up dengan harga terbaik</p>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <i class="fas fa-gamepad text-3xl text-purple-600 mb-3"></i>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $popularProducts->count() }}</h3>
                    <p class="text-gray-600">Produk Populer</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <i class="fas fa-tags text-3xl text-blue-600 mb-3"></i>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $kategoris->count() }}</h3>
                    <p class="text-gray-600">Kategori</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <i class="fas fa-users text-3xl text-green-600 mb-3"></i>
                    <h3 class="text-2xl font-bold text-gray-800">1000+</h3>
                    <p class="text-gray-600">Pelanggan Puas</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <i class="fas fa-clock text-3xl text-orange-600 mb-3"></i>
                    <h3 class="text-2xl font-bold text-gray-800">24/7</h3>
                    <p class="text-gray-600">Layanan</p>
                </div>
            </div>
        </div>

        <!-- Popular Products -->
        @if($popularProducts->count() > 0)
        <section class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-star text-yellow-500 mr-2"></i>
                    Produk Populer
                </h2>
                <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($popularProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
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
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $product->product_name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ $product->developer }}</p>
                        @if($product->kategori)
                            <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full mb-2">
                                {{ $product->kategori->nama }}
                            </span>
                        @endif
                        <a href="{{ route('customer.product', $product->product_id) }}" 
                           class="block w-full bg-purple-600 text-white text-center py-2 rounded-lg hover:bg-purple-700 transition-colors mt-2">
                            <i class="fas fa-shopping-cart mr-2"></i>Beli Sekarang
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Categories -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-th-large text-purple-600 mr-2"></i>
                Kategori Produk
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kategoris as $kategori)
                @if($kategori->produks->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-tag text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ $kategori->nama }}</h3>
                            <p class="text-sm text-gray-600">{{ $kategori->produks->count() }} produk</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($kategori->produks->take(4) as $product)
                            <div class="flex items-center space-x-2">
                                @if($product->logo)
                                    <img src="{{ Storage::url($product->logo) }}" 
                                         alt="{{ $product->product_name }}" 
                                         class="w-8 h-8 object-cover rounded">
                                @else
                                    <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-xs"></i>
                                    </div>
                                @endif
                                <span class="text-sm text-gray-700 truncate">{{ $product->product_name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <a href="{{ route('customer.category', $kategori->id) }}" 
                       class="block w-full bg-gray-100 text-gray-800 text-center py-2 rounded-lg hover:bg-gray-200 transition-colors">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                @endif
                @endforeach
            </div>
        </section>

        <!-- Features -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Mengapa Memilih Tuhu Shop?
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Proses Cepat</h3>
                    <p class="text-gray-600">Transaksi selesai dalam hitungan menit, produk langsung dikirim ke akun Anda</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">100% Aman</h3>
                    <p class="text-gray-600">Transaksi aman dengan sistem pembayaran terpercaya dan garansi uang kembali</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Layanan 24/7</h3>
                    <p class="text-gray-600">Customer service siap membantu Anda kapan saja, 24 jam sehari</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
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
</body>
</html> 