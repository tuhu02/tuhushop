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

        /* Typography adjustments */
        .text-2xl { font-size: 1.5rem !important; }
        .text-3xl { font-size: 1.875rem !important; }
        .text-4xl { font-size: 2.25rem !important; }
        .text-lg { font-size: 1.125rem !important; }
        .text-base { font-size: 1rem !important; }
        .text-sm { font-size: 0.875rem !important; }
        
        /* Denom cards adjustments */
        .denom-card {
            transition: all 0.3s ease;
            padding: 1rem !important;
            min-height: 100px !important;
        }
        .denom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .denom-card.selected {
            border-color: #22d3ee !important;
        }
        
        /* Payment option selection */
        .payment-option.selected {
            border-color: #22d3ee !important;
        }
        
        /* Price styling */
        .payment-price {
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            color: #93c5fd !important;
        }
        
        /* Hide scrollbar */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Layout Optimization */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        footer { margin-top: auto; }

        /* ------ Accordion Payment CSS ------ */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .accordion-item.active .accordion-arrow {
            transform: rotate(180deg);
        }
        .accordion-item.active .logos-preview {
            display: none; /* Sembunyikan preview logo saat accordion terbuka */
        }

        /* ------ Disabled State CSS ------ */
        #payment-options-wrapper.disabled {
            cursor: not-allowed;
        }
        #payment-options-wrapper.disabled .accordion-header {
             pointer-events: none;
             opacity: 0.5;
        }
        #payment-options-wrapper.disabled .payment-option {
            pointer-events: none;
            opacity: 0.5;
        }
        #payment-options-wrapper.disabled .payment-option img {
            filter: grayscale(100%);
        }
        /* Placeholder lebih kecil dari input */
        .placeholder-small::placeholder {
            font-size: 0.71rem !important;
            color: #b0b0b0;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-[#23272f] min-h-screen overflow-x-hidden pt-20">
    <nav class="sticky top-0 left-0 w-full z-50">
        <x-navbar />
    </nav>

    <div class="w-full h-80 md:h-96 relative">
        <img src="{{ $product->banner_url ? asset('image/' . $product->banner_url) : asset('image/banner-mlbb.jpg') }}"
             alt="Banner {{ $product->product_name }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#23272f]/80 to-transparent"></div>
    </div>

    <div class="w-full max-w-screen-xl flex flex-col md:flex-row items-start md:items-start gap-8 justify-start -mt-24 mb-8 z-20 relative px-2 md:ml-8 ml-2">
        <div class="relative w-56 h-56 rounded-2xl overflow-hidden shadow-lg border-4 border-white bg-white flex-shrink-0">
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
                <span class="inline-flex items-center bg-orange-400 text-gray-900 font-semibold px-4 py-1 rounded-full text-base shadow whitespace-nowrap"><i class="fas fa-shield-alt mr-2"></i>Pembayaran yang Aman</span>
            </div>
            <div class="text-gray-200 text-base md:text-lg font-normal text-left">
                {{ $product->description ?? 'Beli Top Up ML Diamond Mobile Legends dan Weekly Diamond Pass MLBB Harga Termurah Se-Indonesia, Dijamin Aman, Cepat dan Terpercaya hanya ada di Tuhu Shop.' }}
            </div>
        </div>
    </div>

    @php
        $isMLBB = strtolower($product->product_name) === 'mobile legends' || strtolower($product->product_name) === 'mobile legends bang bang';
    @endphp

    <div class="w-full max-w-screen-xl mx-auto px-2 mt-8 flex flex-col md:flex-row md:items-start gap-4 layout-container">

        <div class="w-full md:w-2/3 flex flex-col gap-4 main-content">
            <div class="bg-[#181820] rounded-lg shadow-md">
                <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2">
                    <span class="font-bold text-2xl mr-2">1</span>
                    <span class="font-bold text-lg">Pilih Nominal</span>
                </div>
                <div class="p-4">
                    <div class="flex gap-4 mb-3">
                        @foreach($kategoriDenoms as $kategori)
                            <a href="?kategori={{ $kategori->slug }}" class="flex-1 text-center py-4 rounded-lg font-bold text-lg transition-all duration-200 {{ $kategoriAktif == $kategori->slug ? 'bg-cyan-400 text-white' : 'bg-[#23232a] text-cyan-400' }}">
                                {{ $kategori->nama }}
                            </a>
                        @endforeach
                    </div>
                    @if($filteredDenoms->count() > 0)
                    <div class="has-content">
                        <h3 class="text-lg font-semibold text-cyan-400 mb-4 flex items-center">
                            {{ ucfirst($kategoriAktif) }}
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 denom-grid">
                            @foreach($filteredDenoms as $denom)
                            <div class="bg-[#23232a] rounded-xl p-0 flex overflow-hidden shadow hover:shadow-lg transition cursor-pointer denom-card border-2 border-transparent hover:border-cyan-400 select-none"
                                 onclick="selectDenom(event, {{ $denom->id }}, '{{ $denom->nama_denom ?: $denom->nama_produk }}', {{ $denom->harga_jual ?: $denom->harga }})">
                                <div class="flex-1 flex flex-col justify-center px-4 py-3">
                                    <div class="text-white font-bold text-sm mb-2">
                                        {{ $denom->nama_produk ?? $denom->denom ?? $denom->desc ?? '-' }}
                                    </div>
                                    <div class="text-cyan-300 font-semibold text-base">
                                        Rp{{ number_format($denom->harga_jual ?: $denom->harga, 0, ',', '.') }}
                                    </div>
                                </div>
                                @if(!empty($denom->logo))
                                <div class="flex items-center justify-center bg-[#23232a] px-4">
                                    <img src="{{ asset('storage/' . $denom->logo) }}" alt="Logo" class="w-12 h-12 object-contain rounded">
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="text-center py-6 denom-grid">
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

        <div class="w-full md:w-1/3 flex flex-col gap-4 md:sticky md:top-24 h-fit">
            <div class="bg-[#181820] rounded-lg shadow-md">
                <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2">
                    <span class="font-bold text-2xl mr-2">2</span>
                    <span class="font-bold text-lg">Masukan Detail Akun</span>
                </div>
                <div class="p-4 space-y-4">
                    @if(!empty($accountFields) && is_array($accountFields))
                        <div class="grid grid-cols-1 {{ count($accountFields) > 1 ? 'md:grid-cols-2' : '' }} gap-4">
                            @foreach($accountFields as $field)
                                <div class="mb-2">
                                    @php $name = $field['name'] ?? 'field'; @endphp
                                    <label for="preview_{{ $name }}" class="block mb-2 font-semibold text-white">{{ $field['label'] ?? $name }}</label>
                                    <input type="text" name="{{ $name }}" id="preview_{{ $name }}" class="w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white placeholder-small" value="{{ old($name) }}" placeholder="{{ $field['placeholder'] ?? '' }}">
                                </div>
                            @endforeach
                        </div>
    
                        @if($isMLBB)
                            <div id="nickname-result" class="text-cyan-400 font-bold mt-2 min-h-[1.2em]"></div>
                        @endif
                    @else
                        <input type="text" name="account" id="preview_account" class="w-full bg-gray-700 border border-gray-600 rounded-md px-3 py-2 text-white" placeholder="Masukkan data akun">
                    @endif
                    <div class="text-xs text-gray-400">{{ $product->account_instruction ?? '' }}</div>
                </div>
            </div>

            <div class="bg-[#181820] rounded-lg shadow-md">
                 <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2">
                     <span class="font-bold text-2xl mr-2">3</span>
                     <span class="font-bold text-lg">Pilih Pembayaran</span>
                 </div>
                 <div class="p-4" id="payment-options-wrapper">
                    @php
                        // Data ini idealnya datang dari Controller Anda.
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
                        <div class="accordion-item bg-[#23232a] rounded-lg overflow-hidden">
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
                                        <div class="payment-option bg-[#181820] rounded-lg p-3 flex items-center justify-between cursor-pointer border-2 border-transparent"
                                                onclick="selectPayment(this, '{{ $channel['code'] }}')"
                                                data-channel="{{ $channel['code'] }}"
                                                data-fee-flat="{{ $channel['fee_flat'] }}"
                                                data-fee-percent="{{ $channel['fee_percent'] }}">
                                            <div class="flex items-center">
                                                <img src="{{ asset('image/payment/' . $channel['logo']) }}" alt="{{ $channel['name'] }}" class="h-6 w-auto mr-4 object-contain transition-all duration-300">
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
                <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2">
                     <span class="font-bold text-2xl mr-2">4</span>
                     <span class="font-bold text-lg">Beli</span>
                </div>
                <div class="p-4">
                    <form id="pay-form" class="w-full" method="POST" action="{{ route('checkout') }}">
                        @csrf
                        <input type="hidden" name="denom_id" id="denom_id">
                        <input type="hidden" name="payment_method" id="payment_method">
                        
                        {{-- Input tersembunyi ini akan diisi oleh JavaScript sebelum form disubmit --}}
                        @if(!empty($accountFields) && is_array($accountFields))
                            @foreach($accountFields as $field)
                                @php $name = $field['name'] ?? 'field'; @endphp
                                <input type="hidden" name="{{ $name }}" id="form_{{ $name }}">
                            @endforeach
                        @else
                            <input type="hidden" name="account" id="form_account">
                        @endif
                        
                        <input type="email" name="email" id="email" class="rounded-lg px-4 py-2 bg-[#23232a] text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 w-full mb-4" placeholder="Masukkan Email Anda" required>
                        <button type="submit" id="submit-btn" class="bg-cyan-400 hover:bg-cyan-500 text-white font-bold py-3 px-8 rounded-lg text-lg shadow transition w-full">
                            Beli Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="relative bg-gray-900 pt-8 pb-6">
        <div class="container mx-auto px-4">
            <div class="text-center text-white">
                Copyright © <span id="get-current-year">{{ date('Y') }}</span> Tuhu Shop.
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
                nicknameResultDiv.style.color = '#67e8f9';

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
                        nicknameResultDiv.style.color = '#22d3ee';
                    } else {
                        nicknameResultDiv.textContent = data.message || 'Nickname tidak ditemukan.';
                        nicknameResultDiv.style.color = '#fb7185';
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
                        accountFields.forEach(field => {
                            const fieldName = field.name || 'field';
                            const visibleInput = document.getElementById(`preview_${fieldName}`);
                            const hiddenInput = document.getElementById(`form_${fieldName}`);
                            if (visibleInput && hiddenInput) {
                                hiddenInput.value = visibleInput.value;
                            }
                        });
                    } else {
                        const visibleInput = document.getElementById('preview_account');
                        const hiddenInput = document.getElementById('form_account');
                        if(visibleInput && hiddenInput) {
                            hiddenInput.value = visibleInput.value;
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>