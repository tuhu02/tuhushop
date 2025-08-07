<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->product_name }} - Tuhu Shop</title>
    @vite('resources/css/app.css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{-- Font Awesome untuk ikon --}}
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

        nav {
            position: sticky; /* Membuat navbar menempel */
            top: 0;
            z-index: 50;
        }

        footer { margin-top: auto; }
        
        /* Tema Warna Baru */
        :root {
            --theme-accent: #A89580;
            --theme-accent-contrast: #181820;
            --card-bg: #181820;
            --card-bg-secondary: #2D2D2D;
        }
        
        /* Denom cards adjustments */
        .denom-card {
            transition: all 0.2s ease;
            padding: 1rem !important;
            min-height: 80px !important;
            background-color: var(--card-bg-secondary);
        }
        .denom-card:hover {
            transform: translateY(-2px);
            border-color: var(--theme-accent) !important;
        }
        .denom-card.selected {
            border-color: var(--theme-accent) !important;
            background-color: #3f3f46;
        }
        .denom-card .denom-price {
            color: var(--theme-accent);
        }

        /* Payment option selection */
        .payment-option.selected {
            border-color: var(--theme-accent) !important;
        }
        .payment-option {
            background-color: var(--card-bg-secondary);
        }
        .payment-price {
            font-weight: 600 !important;
            color: var(--theme-accent) !important;
        }
        
        /* Hide scrollbar */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Accordion Payment CSS */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .accordion-item.active .accordion-arrow {
            transform: rotate(180deg);
        }
        .accordion-item.active .logos-preview {
            display: none;
        }

        /* Disabled State CSS */
        #payment-options-wrapper.disabled { cursor: not-allowed; }
        #payment-options-wrapper.disabled .accordion-header,
        #payment-options-wrapper.disabled .payment-option {
             pointer-events: none;
             opacity: 0.5;
        }
        #payment-options-wrapper.disabled .payment-option img {
            filter: grayscale(100%);
        }
        
        /* Placeholder lebih kecil */
        .placeholder-small::placeholder {
            font-size: 0.8rem !important;
            color: #a0a0a0;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-[#1F1F2B]">

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

    <main class="pt-5">
        <div class="w-full h-80 md:h-96 relative">
            <img src="{{ $product->banner_url ? asset('image/' . $product->banner_url) : asset('image/banner-mlbb.jpg') }}"
                 alt="Banner {{ $product->product_name }}"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-[#1F1F2B]/90 to-transparent"></div>
        </div>

        <div class="w-full max-w-screen-xl flex flex-col md:flex-row items-start md:items-center gap-8 justify-start -mt-24 mb-8 z-20 relative px-4">
            <div class="relative w-56 h-56 rounded-2xl overflow-hidden shadow-lg bg-white flex-shrink-0 -rotate-6 transition-transform hover:rotate-0">
                <img src="{{ asset('image/' . $product->thumbnail_url) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                <div class="absolute bottom-2 left-1/2 -translate-x-1/2">
                    <img src="{{ asset('image/logo-baru.png') }}" alt="Logo" class="h-7 rounded bg-white px-1 py-1 shadow">
                </div>
            </div>
            <div class="flex-1 w-full min-w-0">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-1 text-left">{{ $product->product_name }}</h1>
                <p class="text-lg text-gray-300 mb-3 font-medium flex items-center text-left"><i class="fas fa-building mr-2"></i>{{ $product->developer }}</p>
                <div class="flex flex-wrap gap-x-4 gap-y-2 mb-4">
                    <span class="inline-flex items-center bg-yellow-400 text-gray-900 font-semibold px-4 py-1 rounded-full text-base shadow whitespace-nowrap"><i class="fas fa-star mr-2"></i>Layanan Terbaik</span>
                    <span class="inline-flex items-center bg-orange-400 text-gray-900 font-semibold px-4 py-1 rounded-full text-base shadow whitespace-nowrap"><i class="fas fa-shield-alt mr-2"></i>Pembayaran Aman</span>
                </div>
                <div class="text-gray-200 text-base md:text-lg font-normal text-left">
                    {{ $product->description ?? 'Beli Top Up ML Diamond Mobile Legends dan Weekly Diamond Pass MLBB Harga Termurah Se-Indonesia, Dijamin Aman, Cepat dan Terpercaya hanya ada di Tuhu Shop.' }}
                </div>
            </div>
        </div>

        @php
            $isMLBB = strtolower($product->product_name) === 'mobile legends' || strtolower($product->product_name) === 'mobile legends bang bang';
        @endphp

        <div class="w-full max-w-screen-xl mx-auto px-4 mt-8 flex flex-col md:flex-row md:items-start gap-6 layout-container">

            <div class="w-full md:w-2/3 flex flex-col gap-6 main-content">
                <div class="bg-[#181820] rounded-lg shadow-md">
                    <div class="flex items-center bg-[#A89580] rounded-t-lg px-4 py-2 text-[#181820]">
                        <span class="font-bold text-2xl mr-2">1</span>
                        <span class="font-bold text-lg">Pilih Nominal</span>
                    </div>
                    <div class="p-4">
                        <div class="flex gap-4 mb-4">
                            @foreach($kategoriDenoms as $kategori)
                                <a href="?kategori={{ $kategori->slug }}" class="flex-1 text-center py-3 rounded-lg font-bold text-lg transition-all duration-200 {{ $kategoriAktif == $kategori->slug ? 'bg-[#A89580] text-[#181820]' : 'bg-[#2D2D2D] text-[#A89580]' }}">
                                    {{ $kategori->nama }}
                                </a>
                            @endforeach
                        </div>
                        @if($filteredDenoms->count() > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-[#A89580] mb-4 flex items-center">
                                {{ ucfirst($kategoriAktif) }}
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($filteredDenoms as $denom)
                                <div class="rounded-xl flex flex-col justify-center text-center overflow-hidden shadow hover:shadow-lg transition cursor-pointer denom-card border-2 border-transparent select-none"
                                     onclick="selectDenom(event, {{ $denom->id }}, '{{ $denom->nama_denom ?: $denom->nama_produk }}', {{ $denom->harga_jual ?: $denom->harga }})">
                                    <div class="text-white font-bold text-base mb-2">
                                        {{ $denom->nama_produk ?? $denom->denom ?? $denom->desc ?? '-' }}
                                    </div>
                                    <div class="denom-price font-semibold text-lg">
                                        Rp{{ number_format($denom->harga_jual ?: $denom->harga, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="text-center py-6">
                            <div class="text-gray-400 mb-3"><i class="fas fa-coins text-4xl"></i></div>
                            <h3 class="text-lg font-medium text-white mb-2">Belum ada denom tersedia</h3>
                            <p class="text-gray-300">Produk ini sedang dalam maintenance</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-[#181820] rounded-lg shadow-md p-4">
                    <h2 class="text-2xl font-bold text-white mb-2">Deskripsi {{ $product->product_name }}</h2>
                    <p class="text-gray-200 mb-4">{{ $product->description ?? ''}}</p>
                    
                    <h2 class="text-2xl font-bold text-white mb-3">Rekomendasi Topup Game</h2>
                    <div id="rekomendasi-carousel" class="flex gap-4 overflow-x-auto hide-scrollbar">
                        @foreach($allGame as $game)
                            <a href="{{ route('produk.public', $game->product_id) }}" class="block flex-shrink-0">
                                <div class="rounded-xl overflow-hidden w-40 h-40">
                                    <img src="{{ asset('image/' . $game->thumbnail_url) }}" alt="{{ $game->product_name }}" class="w-full h-full object-cover">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/3 flex flex-col gap-6 md:sticky md:top-24 h-fit">
                <div class="bg-[#181820] rounded-lg shadow-md">
                    <div class="flex items-center bg-[#A89580] rounded-t-lg px-4 py-2 text-[#181820]">
                        <span class="font-bold text-2xl mr-2">2</span>
                        <span class="font-bold text-lg">Masukan Detail Akun</span>
                    </div>
                    <div class="p-4 space-y-4">
                        @if(!empty($accountFields) && is_array($accountFields))
                            <div class="grid grid-cols-1 {{ count($accountFields) > 1 ? 'md:grid-cols-2' : '' }} gap-4">
                                @foreach($accountFields as $field)
                                    <div>
                                        @php $name = $field['name'] ?? 'field'; @endphp
                                        <label for="preview_{{ $name }}" class="block mb-2 font-semibold text-white">{{ $field['label'] ?? $name }}</label>
                                        <input type="text" name="{{ $name }}" id="preview_{{ $name }}" class="w-full bg-[#2D2D2D] border border-gray-600 rounded-md px-3 py-2 text-white placeholder-small focus:ring-2 focus:ring-[#A89580] focus:outline-none" value="{{ old($name) }}" placeholder="{{ $field['placeholder'] ?? '' }}">
                                    </div>
                                @endforeach
                            </div>
    
                            @if($isMLBB)
                                <div id="nickname-result" class="text-[#A89580] font-bold mt-2 min-h-[1.2em]"></div>
                            @endif
                        @else
                            <input type="text" name="account" id="preview_account" class="w-full bg-[#2D2D2D] border border-gray-600 rounded-md px-3 py-2 text-white focus:ring-2 focus:ring-[#A89580] focus:outline-none" placeholder="Masukkan data akun">
                        @endif
                        <div class="text-xs text-gray-400">{{ $product->account_instruction ?? '' }}</div>
                    </div>
                </div>

                <div class="bg-[#181820] rounded-lg shadow-md">
                     <div class="flex items-center bg-[#A89580] rounded-t-lg px-4 py-2 text-[#181820]">
                         <span class="font-bold text-2xl mr-2">3</span>
                         <span class="font-bold text-lg">Pilih Pembayaran</span>
                     </div>
                     <div class="p-4" id="payment-options-wrapper">
                         @php
                            $paymentGroups = [
                                'QRIS & Dompet Digital' => [
                                    'logos' => ['qris.png', 'dana.png', 'shopeepay.png', 'gopay.png'],
                                    'channels' => [
                                        ['code' => 'qris', 'name' => 'QRIS (semua e-wallet)', 'logo' => 'qris.png', 'fee_flat' => 0, 'fee_percent' => 0.7],
                                        ['code' => 'gopay', 'name' => 'GoPay', 'logo' => 'gopay.png', 'fee_flat' => 0, 'fee_percent' => 2.0],
                                        ['code' => 'shopeepay', 'name' => 'ShopeePay', 'logo' => 'shopeepay.png', 'fee_flat' => 0, 'fee_percent' => 2.0],
                                    ]
                                ],
                                'Virtual Account' => [
                                    'logos' => ['bca.png', 'bni.png', 'mandiri.png', 'permata.png'],
                                    'channels' => [
                                        ['code' => 'bca_va', 'name' => 'BCA Virtual Account', 'logo' => 'bca.png', 'fee_flat' => 4000, 'fee_percent' => 0],
                                        ['code' => 'bni_va', 'name' => 'BNI Virtual Account', 'logo' => 'bni.png', 'fee_flat' => 4000, 'fee_percent' => 0],
                                        ['code' => 'mandiri_va', 'name' => 'Mandiri Virtual Account', 'logo' => 'mandiri.png', 'fee_flat' => 4000, 'fee_percent' => 0],
                                        ['code' => 'permata_va', 'name' => 'Permata Virtual Account', 'logo' => 'permata.png', 'fee_flat' => 4000, 'fee_percent' => 0],
                                    ]
                                ],
                                'Retail' => [
                                    'logos' => ['indomaret.png', 'alfamart.png'],
                                    'channels' => [
                                        ['code' => 'indomaret', 'name' => 'Indomaret', 'logo' => 'indomaret.png', 'fee_flat' => 5000, 'fee_percent' => 0],
                                        ['code' => 'alfamart', 'name' => 'Alfamart', 'logo' => 'alfamart.png', 'fee_flat' => 5000, 'fee_percent' => 0],
                                    ]
                                ]
                            ];
                         @endphp

                         <div class="space-y-3 payment-accordion">
                             @foreach ($paymentGroups as $groupName => $groupData)
                             <div class="accordion-item bg-[#2D2D2D] rounded-lg overflow-hidden">
                                 <button type="button" class="accordion-header w-full p-4 flex justify-between items-center">
                                     <span class="text-white font-semibold text-base">{{ $groupName }}</span>
                                     <div class="flex items-center">
                                         <div class="flex items-center space-x-3 mr-4 logos-preview">
                                             @foreach($groupData['logos'] as $logo)
                                             <img src="{{ asset('image/payment/' . $logo) }}" alt="logo" class="h-4">
                                             @endforeach
                                         </div>
                                         <i class="fas fa-chevron-down text-white accordion-arrow transition-transform duration-300"></i>
                                     </div>
                                 </button>
                                 <div class="accordion-content">
                                     <div class="px-4 pb-4 space-y-2">
                                         @foreach ($groupData['channels'] as $channel)
                                             <div class="payment-option rounded-lg p-3 flex items-center justify-between cursor-pointer border-2 border-transparent"
                                                  onclick="selectPayment(this, '{{ $channel['code'] }}')"
                                                  data-channel="{{ $channel['code'] }}" data-fee-flat="{{ $channel['fee_flat'] }}" data-fee-percent="{{ $channel['fee_percent'] }}">
                                                 <div class="flex items-center">
                                                     <img src="{{ asset('image/payment/' . $channel['logo']) }}" alt="{{ $channel['name'] }}" class="h-6 w-auto mr-4 object-contain">
                                                     <span class="text-white font-medium text-sm">{{ $channel['name'] }}</span>
                                                 </div>
                                                 <span class="payment-price"></span>
                                             </div>
                                         @endforeach
                                     </div>
                                 </div>
                             </div>
                             @endforeach
                         </div>
                     </div>
                </div>

                <div class="bg-[#181820] rounded-lg shadow-md">
                    <div class="flex items-center bg-[#A89580] rounded-t-lg px-4 py-2 text-[#181820]">
                         <span class="font-bold text-2xl mr-2">4</span>
                         <span class="font-bold text-lg">Beli</span>
                    </div>
                    <div class="p-4">
                        <form id="pay-form" class="w-full" method="POST" action="{{ route('checkout') }}">
                            @csrf
                            <input type="hidden" name="denom_id" id="denom_id">
                            <input type="hidden" name="payment_method" id="payment_method">
                            
                            @if(!empty($accountFields) && is_array($accountFields))
                                @foreach($accountFields as $field)
                                    @php $name = $field['name'] ?? 'field'; @endphp
                                    <input type="hidden" name="{{ $name }}" id="form_{{ $name }}">
                                @endforeach
                            @else
                                <input type="hidden" name="account" id="form_account">
                            @endif
                            
                            <input type="email" name="email" id="email" class="rounded-lg px-4 py-2 bg-[#2D2D2D] text-white focus:outline-none focus:ring-2 focus:ring-[#A89580] w-full mb-4" placeholder="Masukkan Email Anda" required>
                            <button type="submit" id="submit-btn" class="bg-[#A89580] hover:bg-opacity-90 text-[#181820] font-bold py-3 px-8 rounded-lg text-lg shadow transition w-full">
                                Beli Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <footer class="relative pt-8" style="background-color: #393E46;">
        <div class="mx-auto px-4 pt-2 text-white">
            <div class="flex flex-wrap text-left lg:text-left">
                <div class="w-full lg:w-6/12 px-4">
                    <h4 class="text-2xl fonat-semibold font-bold text-white">TUHU SHOP</h4>
                    <h5 class="text-sm mt-2 mb-2 text-gray-300">
                        Tuhu Shop adalah tempat top up games yang aman, murah dan terpercaya. Proses cepat 1-3 Detik. Open 24 jam. Payment terlengkap. Jika ada kendala silahkan klik logo CS pada kanan bawah di website ini.
                    </h5>
                    <div class="mt-6 lg:mb-0 mb-6">
                        <button class="bg-white text-lightBlue-400 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2" type="button">
                            <i class="fab fa-twitter text-blue-600"></i></button><button class="bg-white text-lightBlue-600 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2" type="button">
                            <i class="fab fa-facebook-square text-blue-600"></i></button><button class="bg-white text-pink-400 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2" type="button">
                            <i class="fab fa-dribbble"></i></button><button class="bg-white text-blueGray-800 shadow-lg font-normal h-10 w-10 items-center justify-center align-center rounded-full outline-none focus:outline-none mr-2" type="button">
                            <i class="fab fa-github text-black"></i>
                        </button>
                    </div>
                </div>
                <div class="w-full lg:w-6/12 px-4">
                    <div class="flex flex-wrap items-top mb-6">
                        <div class="w-full lg:w-4/12 px-4 ml-auto">
                            <span class="block uppercase text-white text-sm font-semibold mb-2">Useful Links</span>
                            <ul class="list-unstyled">
                                <li><a class="text-gray-300 hover:text-white block pb-2 text-sm" href="#">About Us</a></li>
                                <li><a class="text-gray-300 hover:text-white block pb-2 text-sm" href="#">Blog</a></li>
                                <li><a class="text-gray-300 hover:text-white block pb-2 text-sm" href="#">Github</a></li>
                                <li><a class="text-gray-300 hover:text-white block pb-2 text-sm" href="#">Free Products</a></li>
                            </ul>
                        </div>
                        <div class="w-full lg:w-4/12 px-4">
                            <span class="block uppercase text-white text-sm font-semibold mb-2">Other Resources</span>
                            <ul class="list-unstyled">
                                <li><a class="text-gray-300 hover:text-white block pb-2 text-sm" href="#">MIT License</a></li>
                                <li><a class="text-gray-300 hover:text-white block pb-2 text-sm" href="#">Terms &amp; Conditions</a></li>
                                <li><a class="text-gray-300 hover:text-white block pb-2 text-sm" href="#">Privacy Policy</a></li>
                                <li><a class="text-gray-300 hover:text-white block pb-2 text-sm" href="#">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-gray-600">
            <div class="flex flex-wrap items-center md:justify-between justify-center pb-6">
                <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                    <div class="text-sm text-gray-400 py-1">
                        Copyright © <span id="get-current-year">{{ date('Y') }}</span> Tuhu Shop || Tuhu Pangestu
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        let selectedPrice = 0;

        function selectDenom(event, denomId, denomName, price) {
            document.querySelectorAll('.denom-card').forEach(card => card.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            document.getElementById('denom_id').value = denomId;
            selectedPrice = price;
            updatePaymentPrices(price);
        }

        function selectPayment(element, channel) {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
            element.classList.add('selected');
            document.getElementById('payment_method').value = channel;
        }
        
        function updatePaymentPrices(basePrice) {
            const paymentWrapper = document.getElementById('payment-options-wrapper');
            if (!basePrice || basePrice <= 0) {
                paymentWrapper.classList.add('disabled');
                document.querySelectorAll('.payment-price').forEach(priceEl => priceEl.textContent = '');
                document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
                document.getElementById('payment_method').value = '';
                return;
            }
            
            paymentWrapper.classList.remove('disabled');
            const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
            document.querySelectorAll('.payment-option').forEach(option => {
                const feeFlat = parseFloat(option.dataset.feeFlat) || 0;
                const feePercent = parseFloat(option.dataset.feePercent) || 0;
                let finalPrice = basePrice;
                if (feePercent > 0) finalPrice = basePrice / (1 - (feePercent / 100));
                finalPrice += feeFlat;
                option.querySelector('.payment-price').textContent = formatter.format(Math.ceil(finalPrice));
            });
        }
        
        async function checkNickname() {
            const userIdInput = document.querySelector('input[name="user_id"]');
            const serverInput = document.querySelector('input[name="server"]');
            const nicknameResultDiv = document.getElementById('nickname-result');

            if (!userIdInput || !serverInput || !nicknameResultDiv) return;

            const userId = userIdInput.value.trim();
            const serverId = serverInput.value.trim();

            if (userId && serverId) {
                nicknameResultDiv.textContent = 'Mengecek...';
                nicknameResultDiv.style.color = '#A89580'; // Sesuai tema

                try {
                    const response = await fetch('/api/mlbb-nickname', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ user_id: userId, server: serverId })
                    });
                    const data = await response.json();
                    if (response.ok && data.success) {
                        nicknameResultDiv.textContent = data.nickname;
                        nicknameResultDiv.style.color = '#86efac'; // Hijau untuk sukses
                    } else {
                        nicknameResultDiv.textContent = data.message || 'Nickname tidak ditemukan.';
                        nicknameResultDiv.style.color = '#fb7185'; // Merah untuk error
                    }
                } catch (error) {
                    nicknameResultDiv.textContent = 'Terjadi kesalahan.';
                    nicknameResultDiv.style.color = '#fb7185';
                }
            } else {
                nicknameResultDiv.textContent = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const accordionItems = document.querySelectorAll('.accordion-item');
            accordionItems.forEach(item => {
                const header = item.querySelector('.accordion-header');
                const content = item.querySelector('.accordion-content');
                header.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    accordionItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            otherItem.querySelector('.accordion-content').style.maxHeight = '0px';
                        }
                    });
                    if (!isActive) {
                        item.classList.add('active');
                        content.style.maxHeight = content.scrollHeight + 'px';
                    } else {
                        item.classList.remove('active');
                        content.style.maxHeight = '0px';
                    }
                });
            });

            updatePaymentPrices(0);

            const userIdInput = document.querySelector('input[name="user_id"]');
            const serverInput = document.querySelector('input[name="server"]');
            if(userIdInput && serverInput) {
                // Mencegah checkNickname berjalan terlalu sering
                let timeout = null;
                const debouncedCheck = () => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        checkNickname();
                    }, 500); // Tunggu 500ms setelah user berhenti mengetik
                };
                userIdInput.addEventListener('keyup', debouncedCheck);
                serverInput.addEventListener('keyup', debouncedCheck);
            }

            const payForm = document.getElementById('pay-form');
            if(payForm) {
                payForm.addEventListener('submit', function(event) {
                    if (!document.getElementById('denom_id').value) {
                        alert('Silakan pilih nominal.');
                        event.preventDefault(); return;
                    }
                    if (!document.getElementById('payment_method').value) {
                        alert('Silakan pilih metode pembayaran.');
                        event.preventDefault(); return;
                    }
                    if (!document.getElementById('email').value) {
                        alert('Silakan masukkan email Anda.');
                        event.preventDefault(); return;
                    }

                    const accountFields = @json($accountFields ?? []);
                    if(Array.isArray(accountFields) && accountFields.length > 0) {
                        let allFieldsValid = true;
                        accountFields.forEach(field => {
                            const fieldName = field.name || 'field';
                            const visibleInput = document.getElementById(`preview_${fieldName}`);
                            const hiddenInput = document.getElementById(`form_${fieldName}`);
                            if (visibleInput && hiddenInput) {
                                if(!visibleInput.value) allFieldsValid = false;
                                hiddenInput.value = visibleInput.value;
                            }
                        });
                         if (!allFieldsValid) {
                            alert('Harap lengkapi semua detail akun.');
                            event.preventDefault(); return;
                        }
                    } else {
                        const visibleInput = document.getElementById('preview_account');
                        const hiddenInput = document.getElementById('form_account');
                        if(visibleInput && hiddenInput) {
                            if(!visibleInput.value) {
                                alert('Harap masukkan data akun.');
                                event.preventDefault(); return;
                            }
                            hiddenInput.value = visibleInput.value;
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>