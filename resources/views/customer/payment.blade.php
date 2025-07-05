<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Tuhu Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .payment-card {
            transition: all 0.3s ease;
        }
        .payment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
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
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Order ID</p>
                        <p class="font-mono font-bold text-gray-800">{{ $transaction->order_id }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Info -->
                    <div class="flex items-start space-x-4">
                        @if($transaction->produk->logo)
                            <img src="{{ Storage::url($transaction->produk->logo) }}" 
                                 alt="{{ $transaction->produk->product_name }}" 
                                 class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                        @endif
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $transaction->produk->product_name }}</h3>
                            <p class="text-gray-600">{{ $transaction->denom->nama_denom ?: $transaction->denom->nama_produk }}</p>
                            @if($transaction->produk->kategori)
                                <span class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full mt-1">
                                    {{ $transaction->produk->kategori->nama }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="text-right">
                        <p class="text-3xl font-bold text-purple-600">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600">Total Pembayaran</p>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="font-semibold text-gray-800 mb-4">Informasi Pembeli</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium text-gray-800">{{ $transaction->user_email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nomor Telepon</p>
                            <p class="font-medium text-gray-800">{{ $transaction->user_phone }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Instruksi Pembayaran</h2>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-yellow-800 mb-2">Penting!</h3>
                            <ul class="text-yellow-700 text-sm space-y-1">
                                <li>• Selesaikan pembayaran dalam waktu 24 jam</li>
                                <li>• Pastikan nominal pembayaran sesuai dengan yang tertera</li>
                                <li>• Simpan bukti pembayaran sebagai bukti transaksi</li>
                                <li>• Produk akan dikirim setelah pembayaran berhasil</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Specific Instructions -->
                @if($transaction->payment_method == 'dana')
                <div class="payment-card bg-white border-2 border-blue-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="https://cdn1.codashop.com/S/content/common/images/mno/DANA_ID_CHNL_LOGO.webp" 
                             alt="DANA" class="h-8 mr-3">
                        <h3 class="text-lg font-semibold text-gray-800">Pembayaran via DANA</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="font-semibold text-gray-800 mb-2">Nomor DANA:</p>
                            <p class="text-2xl font-mono font-bold text-blue-600">0812-3456-7890</p>
                            <p class="text-sm text-gray-600">a.n. Tuhu Shop</p>
                        </div>
                        
                        <div class="space-y-2">
                            <h4 class="font-semibold text-gray-800">Cara Pembayaran:</h4>
                            <ol class="list-decimal list-inside text-gray-700 space-y-1">
                                <li>Buka aplikasi DANA</li>
                                <li>Pilih menu "Kirim"</li>
                                <li>Masukkan nomor 0812-3456-7890</li>
                                <li>Masukkan nominal Rp{{ number_format($transaction->amount, 0, ',', '.') }}</li>
                                <li>Tambahkan catatan: {{ $transaction->order_id }}</li>
                                <li>Konfirmasi dan kirim pembayaran</li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                @elseif($transaction->payment_method == 'ovo')
                <div class="payment-card bg-white border-2 border-purple-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="https://cdn1.codashop.com/S/content/common/images/mno/OVO_ID_CHNL_LOGO.webp" 
                             alt="OVO" class="h-8 mr-3">
                        <h3 class="text-lg font-semibold text-gray-800">Pembayaran via OVO</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="font-semibold text-gray-800 mb-2">Nomor OVO:</p>
                            <p class="text-2xl font-mono font-bold text-purple-600">0812-3456-7890</p>
                            <p class="text-sm text-gray-600">a.n. Tuhu Shop</p>
                        </div>
                        
                        <div class="space-y-2">
                            <h4 class="font-semibold text-gray-800">Cara Pembayaran:</h4>
                            <ol class="list-decimal list-inside text-gray-700 space-y-1">
                                <li>Buka aplikasi OVO</li>
                                <li>Pilih menu "Transfer"</li>
                                <li>Masukkan nomor 0812-3456-7890</li>
                                <li>Masukkan nominal Rp{{ number_format($transaction->amount, 0, ',', '.') }}</li>
                                <li>Tambahkan pesan: {{ $transaction->order_id }}</li>
                                <li>Konfirmasi dan kirim pembayaran</li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                @elseif($transaction->payment_method == 'gopay')
                <div class="payment-card bg-white border-2 border-green-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="https://cdn1.codashop.com/S/content/common/images/mno/GO_PAY_ID_CHNL_LOGO.webp" 
                             alt="GoPay" class="h-8 mr-3">
                        <h3 class="text-lg font-semibold text-gray-800">Pembayaran via GoPay</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="font-semibold text-gray-800 mb-2">Nomor GoPay:</p>
                            <p class="text-2xl font-mono font-bold text-green-600">0812-3456-7890</p>
                            <p class="text-sm text-gray-600">a.n. Tuhu Shop</p>
                        </div>
                        
                        <div class="space-y-2">
                            <h4 class="font-semibold text-gray-800">Cara Pembayaran:</h4>
                            <ol class="list-decimal list-inside text-gray-700 space-y-1">
                                <li>Buka aplikasi GoJek</li>
                                <li>Pilih menu "GoPay"</li>
                                <li>Pilih "Transfer"</li>
                                <li>Masukkan nomor 0812-3456-7890</li>
                                <li>Masukkan nominal Rp{{ number_format($transaction->amount, 0, ',', '.') }}</li>
                                <li>Tambahkan catatan: {{ $transaction->order_id }}</li>
                                <li>Konfirmasi dan kirim pembayaran</li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                @elseif($transaction->payment_method == 'qris')
                <div class="payment-card bg-white border-2 border-blue-200 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <img src="https://cdn1.codashop.com/S/content/common/images/mno/QRIS_ID_CHNL_LOGO.webp" 
                             alt="QRIS" class="h-8 mr-3">
                        <h3 class="text-lg font-semibold text-gray-800">Pembayaran via QRIS</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <div class="w-48 h-48 bg-gray-200 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <i class="fas fa-qrcode text-gray-400 text-6xl"></i>
                            </div>
                            <p class="text-sm text-gray-600">Scan QR Code di atas dengan aplikasi e-wallet atau mobile banking</p>
                        </div>
                        
                        <div class="space-y-2">
                            <h4 class="font-semibold text-gray-800">Cara Pembayaran:</h4>
                            <ol class="list-decimal list-inside text-gray-700 space-y-1">
                                <li>Buka aplikasi e-wallet atau mobile banking</li>
                                <li>Pilih menu "Scan QR" atau "Pay QRIS"</li>
                                <li>Scan QR Code di atas</li>
                                <li>Masukkan nominal Rp{{ number_format($transaction->amount, 0, ',', '.') }}</li>
                                <li>Konfirmasi dan lakukan pembayaran</li>
                            </ol>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('customer.index') }}" 
                   class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors text-center font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Shop
                </a>
                
                <button onclick="checkPaymentStatus()" 
                        class="flex-1 bg-purple-600 text-white py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                    <i class="fas fa-check mr-2"></i>Saya Sudah Bayar
                </button>
            </div>
        </div>
    </main>

    <!-- Payment Status Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md mx-4">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Memverifikasi Pembayaran</h3>
                <p class="text-gray-600 mb-6">Mohon tunggu sebentar, kami sedang memverifikasi pembayaran Anda...</p>
                
                <div class="flex space-x-4">
                    <button onclick="closePaymentModal()" 
                            class="flex-1 bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition-colors">
                        Tutup
                    </button>
                    <button onclick="checkPaymentStatus()" 
                            class="flex-1 bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700 transition-colors">
                        Cek Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkPaymentStatus() {
            // Show modal
            document.getElementById('payment-modal').classList.remove('hidden');
            document.getElementById('payment-modal').classList.add('flex');
            
            // Simulate payment verification (in real app, this would call an API)
            setTimeout(() => {
                // For demo purposes, redirect to success page
                window.location.href = "{{ route('customer.payment.success', $transaction->order_id) }}";
            }, 3000);
        }
        
        function closePaymentModal() {
            document.getElementById('payment-modal').classList.add('hidden');
            document.getElementById('payment-modal').classList.remove('flex');
        }
        
        // Auto-check payment status every 30 seconds
        setInterval(() => {
            // In real app, this would make an API call to check payment status
            console.log('Checking payment status...');
        }, 30000);
    </script>
</body>
</html> 