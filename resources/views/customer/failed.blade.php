<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal - Tuhu Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .failed-animation {
            animation: failedShake 0.5s ease-in-out;
        }
        @keyframes failedShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
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
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Failed Message -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center mb-8">
                <div class="failed-animation w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-times text-red-600 text-3xl"></i>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Pembayaran Gagal</h1>
                <p class="text-lg text-gray-600 mb-6">Maaf, pembayaran Anda tidak dapat diproses</p>
                
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-red-800 font-medium">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Silakan coba lagi atau hubungi customer service kami
                    </p>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Detail Transaksi</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Order ID</span>
                        <span class="font-mono font-semibold text-gray-800">{{ $transaction->order_id }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Tanggal Transaksi</span>
                        <span class="font-semibold text-gray-800">{{ $transaction->created_at->format('d M Y H:i') }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Produk</span>
                        <span class="font-semibold text-gray-800">{{ $transaction->produk->product_name }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Nominal</span>
                        <span class="font-semibold text-gray-800">{{ $transaction->denom->nama_denom ?: $transaction->denom->nama_produk }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <span class="font-semibold text-gray-800 capitalize">{{ $transaction->payment_method }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-red-600">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Possible Issues -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Kemungkinan Penyebab</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Saldo Tidak Cukup</h3>
                            <p class="text-gray-600">Pastikan saldo e-wallet atau rekening Anda mencukupi</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Waktu Pembayaran Habis</h3>
                            <p class="text-gray-600">Pembayaran harus diselesaikan dalam waktu 24 jam</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-network-wired text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Masalah Jaringan</h3>
                            <p class="text-gray-600">Koneksi internet yang tidak stabil dapat menyebabkan kegagalan</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-lock text-red-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Pembatasan Transaksi</h3>
                            <p class="text-gray-600">Akun Anda mungkin memiliki pembatasan untuk transaksi tertentu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Solutions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Solusi</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-redo text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Coba Lagi</h3>
                            <p class="text-gray-600">Coba lakukan pembayaran ulang dengan metode yang sama atau berbeda</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-credit-card text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Ganti Metode Pembayaran</h3>
                            <p class="text-gray-600">Coba dengan metode pembayaran lain yang tersedia</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-headset text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Hubungi Customer Service</h3>
                            <p class="text-gray-600">Tim kami siap membantu menyelesaikan masalah Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Support -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-headset text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Butuh Bantuan?</h3>
                        <p class="text-gray-600 mb-4">Tim customer service kami siap membantu Anda 24/7</p>
                        
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-envelope text-blue-600"></i>
                                <span class="text-gray-700">support@tuhushop.com</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-phone text-blue-600"></i>
                                <span class="text-gray-700">+62 812-3456-7890</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fab fa-whatsapp text-green-600"></i>
                                <span class="text-gray-700">WhatsApp Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('customer.product', $transaction->product_id) }}" 
                   class="flex-1 bg-purple-600 text-white py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors text-center font-semibold">
                    <i class="fas fa-redo mr-2"></i>Coba Lagi
                </a>
                
                <a href="{{ route('customer.index') }}" 
                   class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors text-center font-semibold">
                    <i class="fas fa-shopping-cart mr-2"></i>Lihat Produk Lain
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Tuhu Shop. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 