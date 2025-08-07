<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran {{ $product->product_name ?? 'Produk' }}</title>
    @vite('resources/css/app.css')
    @if(config('midtrans.is_production'))
    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
    
    <!-- Meta token untuk CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Global scaling */
        html { font-size: 80%; }
        body { font-size: 1.25rem; }

        /* Layout & Background */
        body {
            background-color: #1F1F2B; /* Warna background utama */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Tema Warna Baru */
        :root {
            --theme-accent: #A89580;
            --theme-accent-contrast: #181820;
            --card-bg: #181820;
            --card-bg-secondary: #2D2D2D;
        }

        /* Payment card styling */
        .payment-card {
            background-color: var(--card-bg);
            border: 1px solid #374151;
            transition: all 0.2s ease;
        }
        .payment-card:hover {
            border-color: var(--theme-accent);
        }

        .payment-button {
            background: linear-gradient(135deg, var(--theme-accent) 0%, #B8A58C 100%);
            transition: all 0.3s ease;
        }
        .payment-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(168, 149, 128, 0.3);
        }

        .payment-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>
<body class="bg-[#1F1F2B]">
    <!-- Navbar -->
    <nav class="bg-[#181820] px-6 py-4 shadow-lg">
        <div class="flex items-center w-full gap-6">
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center">
                    <img src="/image/logo-baru.png" alt="Logo Tuhu Shop" class="h-8 w-8 object-contain">
                </a>
            </div>
            <div class="flex-1 relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </span>
                <input type="text" class="w-full bg-[#2D2D2D] text-white rounded-lg px-4 py-2.5 pl-11 focus:outline-none focus:ring-2 focus:ring-[#A89580]" placeholder="Cari Game atau Voucher">
            </div>
            <div class="flex-shrink-0">
                <div class="flex items-center bg-[#2D2D2D] rounded-lg px-3 py-1.5 gap-2 border border-gray-700">
                    <span class="inline-block w-6 h-4" style="background: linear-gradient(to bottom, #FF0000 50%, #FFFFFF 50%);"></span>
                    <span class="text-white font-semibold text-sm">ID / IDR</span>
                </div>
            </div>
        </div>
        <div class="w-full h-px bg-gray-700 my-3"></div>
        <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-8 text-gray-300">
                <a href="/topup" class="flex items-center gap-2 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg> Topup
                </a>
                <a href="/cekTransaksi" class="flex items-center gap-2 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg> Cek Transaksi
                </a>
                <a href="/leaderboard" class="flex items-center gap-2 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg> Leaderboard
                </a>
                <a href="/kalkulator" class="flex items-center gap-2 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg> Kalkulator
                </a>
            </div>
            <div class="flex items-center gap-8 text-gray-300">
                <a href="/login" class="flex items-center gap-2 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg> Masuk
                </a>
                <a href="/register" class="flex items-center gap-2 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg> Daftar
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-8 pb-8">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-[#A89580] rounded-full mb-4">
                        <i class="fas fa-credit-card text-2xl text-[#181820]"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pembayaran</h1>
                    <p class="text-gray-300 text-lg">{{ $product->product_name ?? 'Produk' }}</p>
                </div>

                <!-- Payment Card -->
                <div class="payment-card rounded-2xl shadow-xl p-8 mb-8">
                    <!-- Payment Method Info -->
                    <div class="mb-6 p-4 bg-[#2D2D2D] rounded-xl border-l-4 border-[#A89580]">
                        <div class="flex items-center">
                            <i class="fas fa-credit-card text-[#A89580] text-xl mr-3"></i>
                            <div>
                                <h3 class="text-white font-semibold">Metode Pembayaran Dipilih</h3>
                                <p class="text-gray-300 text-sm">Anda telah memilih: <span class="font-semibold text-[#A89580]">{{ $trx->payment_method ?? $trx->metadata['payment_method'] ?? 'N/A' }}</span></p>
                                @if(strtolower($trx->payment_method ?? $trx->metadata['payment_method'] ?? '') === 'qris')
                                <p class="text-yellow-300 text-xs mt-1">⚠️ Midtrans akan menampilkan beberapa opsi, pilih <strong>GoPay</strong> untuk QRIS</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-[#A89580] rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-receipt text-[#181820]"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-white">Ringkasan Pesanan</h2>
                        </div>
                        
                        <div class="bg-[#2D2D2D] rounded-xl p-6 space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                <span class="text-gray-300 font-medium">Order ID</span>
                                <span class="font-semibold text-white">{{ $trx->order_id }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                <span class="text-gray-300 font-medium">Produk</span>
                                <span class="font-semibold text-white text-right max-w-xs">{{ $product->product_name ?? 'Produk' }}</span>
                            </div>
                            @if($selectedDenom)
                            <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                <span class="text-gray-300 font-medium">Denom</span>
                                <span class="font-semibold text-white text-right max-w-xs">{{ $selectedDenom->nama_denom ?? $selectedDenom->nama_produk }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                <span class="text-gray-300 font-medium">User ID Game</span>
                                <span class="font-semibold text-white">{{ $trx->metadata['user_id_game'] ?? '-' }}</span>
                            </div>
                            @if(isset($trx->metadata['server']))
                            <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                <span class="text-gray-300 font-medium">Server</span>
                                <span class="font-semibold text-white">{{ $trx->metadata['server'] }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                <span class="text-gray-300 font-medium">Metode Pembayaran</span>
                                <span class="font-semibold text-white">{{ $trx->payment_method ?? $trx->metadata['payment_method'] ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-300 font-medium text-lg">Total Pembayaran</span>
                                <span class="text-2xl font-bold text-[#A89580]">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <div class="text-center">
                        @if(empty($snapToken))
                            <div class="bg-red-900/20 border border-red-500/30 text-red-300 p-6 rounded-xl mb-6">
                                <div class="flex items-center justify-center mb-3">
                                    <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                                    <span class="text-lg font-semibold">Gagal memuat pembayaran</span>
                                </div>
                                <p class="text-sm">Snap token tidak tersedia. Silakan refresh halaman atau hubungi admin.</p>
                                <div class="mt-3 text-xs text-gray-400">
                                    Token: <code class="bg-gray-800 px-2 py-1 rounded">{{ $snapToken }}</code>
                                </div>
                            </div>
                        @else
                            <button id="pay-button" class="payment-button text-white px-8 py-4 rounded-xl font-bold text-lg w-full max-w-md">
                                <i class="fas fa-credit-card mr-3"></i>
                                Bayar Sekarang
                            </button>
                            <div class="mt-4 text-xs text-gray-400">
                                Token: <code class="bg-gray-800 px-2 py-1 rounded">{{ $snapToken }}</code>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="mt-8 text-center">
                        <div class="bg-[#2D2D2D] rounded-xl p-6">
                            <div class="flex items-center justify-center mb-4">
                                <i class="fas fa-info-circle text-[#A89580] text-xl mr-3"></i>
                                <span class="text-white font-semibold">Informasi Pembayaran</span>
                            </div>
                            <div class="text-gray-300 text-sm space-y-3">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                                    <p>Metode pembayaran sudah dipilih di halaman sebelumnya</p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-400 mr-3 mt-0.5"></i>
                                    <p>Hanya metode <strong>{{ $trx->payment_method ?? $trx->metadata['payment_method'] ?? 'N/A' }}</strong> yang akan ditampilkan di popup pembayaran</p>
                                </div>
                                @if(strtolower($trx->payment_method ?? $trx->metadata['payment_method'] ?? '') === 'qris')
                                <div class="flex items-start">
                                    <i class="fas fa-qrcode text-purple-400 mr-3 mt-0.5"></i>
                                    <p><strong>QRIS</strong> akan menggunakan channel <strong>GoPay</strong> di popup pembayaran</p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-yellow-400 mr-3 mt-0.5"></i>
                                    <p><strong>Catatan:</strong> Midtrans mungkin menampilkan beberapa opsi pembayaran, silakan pilih <strong>GoPay</strong> untuk QRIS</p>
                                </div>
                                @endif
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                                    <p>Setelah pembayaran berhasil, pesanan Anda akan diproses secara otomatis</p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                                    <p>Invoice akan dikirim setelah pembayaran selesai</p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-shield-alt text-blue-400 mr-3 mt-0.5"></i>
                                    <p>Pembayaran aman dengan enkripsi SSL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script type="text/javascript">
        // Pastikan snap token tersedia
        const snapToken = '{{ $snapToken }}';
        if (!snapToken) {
            console.error('Snap token tidak tersedia');
            alert('Terjadi kesalahan dalam memuat halaman pembayaran. Silakan coba lagi.');
            window.location.href = '{{ route("produk.public", ["product_id" => $product->product_id ?? 1]) }}';
        }

        // Setup handler untuk tombol pembayaran
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.onclick = function() {
                // Nonaktifkan tombol untuk mencegah double-click
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Memproses...';
                
                try {
                    // Memulai transaksi Midtrans saat tombol diklik
                    snap.pay(snapToken, {
                        onSuccess: function(result) {
                            console.log('Pembayaran berhasil:', result);
                            window.location.href = '{{ route("payment.success", ["orderId" => $trx->order_id]) }}';
                        },
                        onPending: function(result) {
                            console.log('Pembayaran pending:', result);
                            window.location.href = '{{ route("invoice", ["orderId" => $trx->order_id]) }}';
                        },
                        onError: function(result) {
                            console.error('Pembayaran error:', result);
                            alert('Pembayaran gagal: ' + (result.status_message || 'Terjadi kesalahan'));
                            window.location.href = '{{ route("payment.failed", ["orderId" => $trx->order_id]) }}';
                        },
                        onClose: function() {
                            // Re-enable tombol jika popup ditutup
                            payButton.disabled = false;
                            payButton.innerHTML = '<i class="fas fa-credit-card mr-3"></i>Bayar Sekarang';
                            if (confirm('Apakah Anda yakin ingin membatalkan pembayaran?')) {
                                window.location.href = '{{ route("produk.public", ["product_id" => $product->product_id ?? 1]) }}';
                            }
                        }
                    });
                } catch (error) {
                    console.error('Error saat memulai pembayaran:', error);
                    alert('Terjadi kesalahan saat memulai pembayaran. Silakan coba lagi.');
                    // Re-enable tombol jika terjadi error
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fas fa-credit-card mr-3"></i>Bayar Sekarang';
                }
            };
        }
    </script>
</body>
</html>
