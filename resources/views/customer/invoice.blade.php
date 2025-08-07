<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $trx->order_id ?? 'N/A' }}</title>
    @vite('resources/css/app.css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
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

        /* Invoice card styling */
        .invoice-card {
            background-color: var(--card-bg);
            border: 1px solid #374151;
            transition: all 0.2s ease;
        }
        .invoice-card:hover {
            border-color: var(--theme-accent);
        }

        .action-button {
            background: linear-gradient(135deg, var(--theme-accent) 0%, #B8A58C 100%);
            transition: all 0.3s ease;
        }
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(168, 149, 128, 0.3);
        }

        /* Status styling */
        .status-paid {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        .status-pending {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }
        .status-failed {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
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
                        <i class="fas fa-file-invoice text-2xl text-[#181820]"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Invoice</h1>
                    <p class="text-gray-300 text-lg">Order ID: {{ $trx->order_id ?? 'N/A' }}</p>
                    
                    <!-- Transaction Status Overview -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-[#2D2D2D] rounded-xl p-4 text-center">
                            <div class="text-2xl mb-2">
                                @if($trx->payment_status === 'paid')
                                    <i class="fas fa-check-circle text-green-400"></i>
                                @elseif($trx->payment_status === 'pending')
                                    <i class="fas fa-clock text-yellow-400"></i>
                                @else
                                    <i class="fas fa-times-circle text-red-400"></i>
                                @endif
                            </div>
                            <div class="text-white font-semibold">Payment</div>
                            <div class="text-sm text-gray-300">{{ ucfirst($trx->payment_status) }}</div>
                        </div>
                        
                        <div class="bg-[#2D2D2D] rounded-xl p-4 text-center">
                            <div class="text-2xl mb-2">
                                @if($trx->transaction_status === 'success')
                                    <i class="fas fa-check-circle text-green-400"></i>
                                @elseif($trx->transaction_status === 'processing')
                                    <i class="fas fa-spinner fa-spin text-blue-400"></i>
                                @elseif($trx->transaction_status === 'failed')
                                    <i class="fas fa-times-circle text-red-400"></i>
                                @else
                                    <i class="fas fa-clock text-gray-400"></i>
                                @endif
                            </div>
                            <div class="text-white font-semibold">Digiflazz</div>
                            <div class="text-sm text-gray-300">{{ ucfirst($trx->transaction_status ?? 'pending') }}</div>
                        </div>
                        
                        <div class="bg-[#2D2D2D] rounded-xl p-4 text-center">
                            <div class="text-2xl mb-2">
                                @if($trx->payment_status === 'paid' && $trx->transaction_status === 'success')
                                    <i class="fas fa-check-circle text-green-400"></i>
                                @elseif($trx->payment_status === 'paid' && $trx->transaction_status === 'processing')
                                    <i class="fas fa-spinner fa-spin text-blue-400"></i>
                                @elseif($trx->payment_status === 'paid' && $trx->transaction_status === 'failed')
                                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                                @else
                                    <i class="fas fa-clock text-gray-400"></i>
                                @endif
                            </div>
                            <div class="text-white font-semibold">Overall</div>
                            <div class="text-sm text-gray-300">
                                @if($trx->payment_status === 'paid' && $trx->transaction_status === 'success')
                                    Completed
                                @elseif($trx->payment_status === 'paid' && $trx->transaction_status === 'processing')
                                    Processing
                                @elseif($trx->payment_status === 'paid' && $trx->transaction_status === 'failed')
                                    Failed
                                @elseif($trx->payment_status === 'pending')
                                    Pending Payment
                                @else
                                    Unknown
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Card -->
                <div class="invoice-card rounded-2xl shadow-xl p-8 mb-8">
                    <!-- Payment Method Info -->
                    <div class="mb-6 p-4 bg-[#2D2D2D] rounded-xl border-l-4 border-[#A89580]">
                        <div class="flex items-center">
                            <i class="fas fa-credit-card text-[#A89580] text-xl mr-3"></i>
                            <div>
                                <h3 class="text-white font-semibold">Metode Pembayaran</h3>
                                <p class="text-gray-300 text-sm">Metode yang dipilih: <span class="font-semibold text-[#A89580]">{{ $trx->payment_method ?? $trx->metadata['payment_method'] ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="flex justify-between items-center border-b border-gray-600 pb-6 mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-white">Tuhu Shop</h2>
                            <p class="text-gray-300">{{ now()->format('d M Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="w-12 h-12 bg-[#A89580] rounded-full flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-[#181820]"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-[#A89580] rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-info-circle text-[#181820]"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Detail Transaksi</h3>
                        </div>
                        
                        <div class="bg-[#2D2D2D] rounded-xl p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                    <span class="text-gray-300 font-medium">Produk:</span>
                                    <span class="font-semibold text-white text-right max-w-xs">{{ $product->product_name ?? 'N/A' }}</span>
                                </div>
                                @if($selectedDenom)
                                <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                    <span class="text-gray-300 font-medium">Denom:</span>
                                    <span class="font-semibold text-white text-right max-w-xs">{{ $selectedDenom->nama_denom ?? $selectedDenom->nama_produk ?? 'N/A' }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                    <span class="text-gray-300 font-medium">User ID Game:</span>
                                    <span class="font-semibold text-white">{{ $trx->metadata['user_id_game'] ?? 'N/A' }}</span>
                                </div>
                                @if(isset($trx->metadata['server']))
                                <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                    <span class="text-gray-300 font-medium">Server:</span>
                                    <span class="font-semibold text-white">{{ $trx->metadata['server'] }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                    <span class="text-gray-300 font-medium">Metode Pembayaran:</span>
                                    <span class="font-semibold text-white">{{ $trx->payment_method ?? $trx->metadata['payment_method'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Status -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-[#A89580] rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-credit-card text-[#181820]"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Status Pembayaran</h3>
                        </div>
                        
                        <div class="rounded-xl p-6 {{ $trx->payment_status === 'paid' ? 'status-paid' : ($trx->payment_status === 'pending' ? 'status-pending' : 'status-failed') }} text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-lg font-bold mb-2">
                                        @if($trx->payment_status === 'paid')
                                            <i class="fas fa-check-circle mr-2"></i>Pembayaran Berhasil
                                        @elseif($trx->payment_status === 'pending')
                                            <i class="fas fa-clock mr-2"></i>Menunggu Pembayaran
                                        @else
                                            <i class="fas fa-times-circle mr-2"></i>Pembayaran Gagal
                                        @endif
                                    </h4>
                                    <p class="text-sm opacity-90">
                                        @if($trx->payment_status === 'pending')
                                            Silakan lakukan pembayaran untuk melanjutkan proses
                                        @elseif($trx->payment_status === 'paid')
                                            Pembayaran berhasil! Pesanan sedang diproses
                                        @else
                                            Pembayaran gagal. Silakan coba lagi
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold">{{ ucfirst($trx->payment_status) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Digiflazz Response -->
                    @if($trx->transaction_status === 'success' || $trx->transaction_status === 'failed' || $trx->transaction_status === 'processing')
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-[#A89580] rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-server text-[#181820]"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Status Digiflazz</h3>
                        </div>
                        
                        <div class="rounded-xl p-6 {{ $trx->transaction_status === 'success' ? 'status-paid' : ($trx->transaction_status === 'processing' ? 'status-pending' : 'status-failed') }} text-white">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h4 class="text-lg font-bold mb-2">
                                        @if($trx->transaction_status === 'success')
                                            <i class="fas fa-check-circle mr-2"></i>Produk Berhasil Dibeli
                                        @elseif($trx->transaction_status === 'processing')
                                            <i class="fas fa-spinner fa-spin mr-2"></i>Sedang Memproses
                                        @else
                                            <i class="fas fa-times-circle mr-2"></i>Gagal Membeli Produk
                                        @endif
                                    </h4>
                                    <p class="text-sm opacity-90">
                                        @if($trx->transaction_status === 'processing')
                                            Pesanan sedang diproses di Digiflazz
                                        @elseif($trx->transaction_status === 'success')
                                            Produk berhasil dibeli dari Digiflazz
                                        @else
                                            Gagal membeli produk dari Digiflazz
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold">{{ ucfirst($trx->transaction_status) }}</div>
                                </div>
                            </div>

                            @if(isset($trx->metadata['digiflazz_response']))
                            <div class="bg-black/20 rounded-lg p-4 mt-4">
                                <h5 class="font-semibold mb-3 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Response Digiflazz
                                </h5>
                                <div class="space-y-2 text-sm">
                                    @if(isset($trx->metadata['digiflazz_response']['ref_id']))
                                    <div class="flex justify-between">
                                        <span class="opacity-80">Ref ID:</span>
                                        <span class="font-mono">{{ $trx->metadata['digiflazz_response']['ref_id'] }}</span>
                                    </div>
                                    @endif
                                    @if(isset($trx->metadata['digiflazz_response']['customer_no']))
                                    <div class="flex justify-between">
                                        <span class="opacity-80">Customer No:</span>
                                        <span class="font-mono">{{ $trx->metadata['digiflazz_response']['customer_no'] }}</span>
                                    </div>
                                    @endif
                                    @if(isset($trx->metadata['digiflazz_response']['buyer_sku_code']))
                                    <div class="flex justify-between">
                                        <span class="opacity-80">SKU Code:</span>
                                        <span class="font-mono">{{ $trx->metadata['digiflazz_response']['buyer_sku_code'] }}</span>
                                    </div>
                                    @endif
                                    @if(isset($trx->metadata['digiflazz_response']['message']))
                                    <div class="flex justify-between">
                                        <span class="opacity-80">Message:</span>
                                        <span>{{ $trx->metadata['digiflazz_response']['message'] }}</span>
                                    </div>
                                    @endif
                                    @if(isset($trx->metadata['digiflazz_response']['status']))
                                    <div class="flex justify-between">
                                        <span class="opacity-80">Status:</span>
                                        <span class="font-semibold">{{ $trx->metadata['digiflazz_response']['status'] }}</span>
                                    </div>
                                    @endif
                                    @if(isset($trx->metadata['digiflazz_response']['rc']))
                                    <div class="flex justify-between">
                                        <span class="opacity-80">Response Code:</span>
                                        <span class="font-mono">{{ $trx->metadata['digiflazz_response']['rc'] }}</span>
                                    </div>
                                    @endif
                                    @if(isset($trx->metadata['digiflazz_response']['sn']))
                                    <div class="flex justify-between">
                                        <span class="opacity-80">Serial Number:</span>
                                        <span class="font-mono">{{ $trx->metadata['digiflazz_response']['sn'] }}</span>
                                    </div>
                                    @endif
                                    @if(isset($trx->metadata['digiflazz_response']['price']))
                                    <div class="flex justify-between">
                                        <span class="opacity-80">Price:</span>
                                        <span class="font-semibold">Rp {{ number_format($trx->metadata['digiflazz_response']['price'], 0, ',', '.') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if($trx->digiflazz_ref_id)
                            <div class="bg-green-900/20 border border-green-500/30 rounded-lg p-4 mt-4">
                                <h5 class="font-semibold mb-2 flex items-center text-green-300">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Digiflazz Reference ID
                                </h5>
                                <p class="font-mono text-green-200">{{ $trx->digiflazz_ref_id }}</p>
                            </div>
                            @endif

                            @if(isset($trx->metadata['error']))
                            <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-4 mt-4">
                                <h5 class="font-semibold mb-2 flex items-center text-red-300">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    Error Message
                                </h5>
                                <p class="text-red-200">{{ $trx->metadata['error'] }}</p>
                            </div>
                            @endif

                            <!-- Refresh Status Button -->
                            @if($trx->transaction_status === 'processing')
                            <div class="mt-4 text-center">
                                <button onclick="refreshStatus()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold flex items-center mx-auto">
                                    <i class="fas fa-sync-alt mr-2"></i>
                                    Refresh Status
                                </button>
                                <p class="text-xs text-gray-300 mt-2">Status akan diperbarui otomatis setiap 30 detik</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Price Details -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-[#A89580] rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-calculator text-[#181820]"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Rincian Harga</h3>
                        </div>
                        
                        <div class="bg-[#2D2D2D] rounded-xl p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-3 border-b border-gray-600">
                                    <span class="text-gray-300 font-medium">Harga Produk</span>
                                    <span class="font-semibold text-white">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-3">
                                    <span class="text-lg font-semibold text-white">Total</span>
                                    <span class="text-2xl font-bold text-[#A89580]">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @if($trx->payment_status === 'pending')
                    <div class="text-center mb-6">
                        <a href="{{ route('payment', ['orderId' => $trx->order_id]) }}" class="action-button text-white px-8 py-4 rounded-xl font-bold text-lg inline-flex items-center">
                            <i class="fas fa-credit-card mr-3"></i>
                            Lanjutkan Pembayaran
                        </a>
                    </div>
                    @endif

                    <!-- Additional Info -->
                    <div class="bg-[#2D2D2D] rounded-xl p-6">
                        <div class="flex items-center justify-center mb-4">
                            <i class="fas fa-info-circle text-[#A89580] text-xl mr-3"></i>
                            <span class="text-white font-semibold">Informasi Penting</span>
                        </div>
                        <div class="text-gray-300 text-sm space-y-3">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                                <p>Simpan invoice ini sebagai bukti pembayaran</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                                <p>Untuk bantuan hubungi customer service kami</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-shield-alt text-blue-400 mr-3 mt-0.5"></i>
                                <p>Transaksi aman dengan enkripsi SSL</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-credit-card text-[#A89580] mr-3 mt-0.5"></i>
                                <p>Metode pembayaran yang digunakan: <strong>{{ $trx->payment_method ?? $trx->metadata['payment_method'] ?? 'N/A' }}</strong></p>
                            </div>
                            @if(strtolower($trx->payment_method ?? $trx->metadata['payment_method'] ?? '') === 'qris')
                            <div class="flex items-start">
                                <i class="fas fa-qrcode text-purple-400 mr-3 mt-0.5"></i>
                                <p><strong>QRIS</strong> menggunakan channel <strong>GoPay</strong> untuk pembayaran</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Auto refresh untuk status processing
        @if($trx->transaction_status === 'processing')
        let refreshInterval;
        
        function startAutoRefresh() {
            refreshInterval = setInterval(function() {
                checkDigiflazzStatus();
            }, 30000); // Refresh setiap 30 detik
        }
        
        function checkDigiflazzStatus() {
            fetch('{{ route("check.digiflazz.status", ["orderId" => $trx->order_id]) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.status === 'success' || data.status === 'failed') {
                            // Stop auto refresh and reload page
                            clearInterval(refreshInterval);
                            location.reload();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error checking status:', error);
                });
        }
        
        function refreshStatus() {
            checkDigiflazzStatus();
        }
        
        // Start auto refresh when page loads
        document.addEventListener('DOMContentLoaded', function() {
            startAutoRefresh();
        });
        @endif
        
        // Manual refresh function
        function refreshStatus() {
            location.reload();
        }
    </script>
</body>
</html>
