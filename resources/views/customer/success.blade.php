<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Tuhu Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .success-animation {
            animation: successPulse 2s ease-in-out;
        }
        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
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
            <!-- Success Message -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center mb-8">
                <div class="success-animation w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check text-green-600 text-3xl"></i>
                </div>
                
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Pembayaran Berhasil!</h1>
                <p class="text-lg text-gray-600 mb-6">Terima kasih telah berbelanja di Tuhu Shop</p>
                
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-green-800 font-medium">
                        <i class="fas fa-info-circle mr-2"></i>
                        Produk akan dikirim ke akun Anda dalam waktu 5-10 menit
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
                        <span class="text-2xl font-bold text-purple-600">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Langkah Selanjutnya</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Proses Pengiriman</h3>
                            <p class="text-gray-600">Tim kami akan memproses pesanan Anda dalam waktu 5-10 menit</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Notifikasi Email</h3>
                            <p class="text-gray-600">Anda akan menerima email konfirmasi dengan detail produk yang dibeli</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-gamepad text-purple-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">Produk Dikirim</h3>
                            <p class="text-gray-600">Produk akan dikirim langsung ke akun game atau email Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Support -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-headset text-blue-600 text-xl"></i>
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
                <a href="{{ route('customer.index') }}" 
                   class="flex-1 bg-purple-600 text-white py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors text-center font-semibold">
                    <i class="fas fa-shopping-cart mr-2"></i>Beli Lagi
                </a>
                
                <a href="{{ route('dashboard') }}" 
                   class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors text-center font-semibold">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
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