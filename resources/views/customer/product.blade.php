<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->product_name }} - Tuhu Shop</title>
    @vite('resources/css/app.css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        .denom-card {
            transition: all 0.3s ease;
        }
        .denom-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .denom-card.selected {
            border-color: #22d3ee !important; /* cyan-400 */
            /* background-color: #cffafe !important;  HAPUS agar background tidak berubah saat selected */
            /* color: #164e63 !important;  HAPUS agar warna text tidak berubah saat selected */
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .hide-scrollbar::-webkit-scrollbar {
          display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .hide-scrollbar {
          -ms-overflow-style: none;  /* IE and Edge */
          scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-[#23272f] min-h-screen overflow-x-hidden pt-20">
    <nav class="sticky top-0 left-0 w-full z-50">
        <x-navbar />
    </nav>
    <!-- BANNER PRODUK -->
    <div class="w-full h-80 md:h-96 relative">
        <img src="{{ $product->banner_url ? asset('image/' . $product->banner_url) : asset('image/banner-mlbb.jpg') }}"
             alt="Banner {{ $product->product_name }}"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-[#23272f]/80 to-transparent"></div>
    </div>
    <!-- END BANNER PRODUK -->
    <!-- INFO PRODUK FLEX -->
    <div class="w-full max-w-screen-xl flex flex-col md:flex-row items-start md:items-start gap-8 justify-start -mt-24 mb-8 z-20 relative px-2 md:ml-8 ml-2">
        <!-- Card Gambar Produk -->
        <div class="relative w-56 h-56 rounded-2xl overflow-hidden shadow-lg border-4 border-white bg-white flex-shrink-0">
            <img src="{{ asset('image/' . $product->thumbnail_url) }}"
                 alt="{{ $product->product_name }}"
                 class="w-full h-full object-cover">
            <!-- Logo kecil di bawah -->
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2">
                <img src="{{ asset('image/logo-baru.png') }}" alt="Logo" class="h-7 rounded bg-white px-1 py-1 shadow">
            </div>
        </div>
        <!-- Info Produk di kanan -->
        <div class="flex-1 w-full min-w-0">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-1 text-left">{{ $product->product_name }}</h1>
            <p class="text-lg text-gray-300 mb-3 font-medium flex items-center text-left"><i class="fas fa-building mr-2"></i>{{ $product->developer }}</p>
            <div class="flex flex-wrap gap-x-4 gap-y-2 mb-4">
                <span class="inline-flex items-center bg-yellow-400 text-gray-900 font-semibold px-4 py-1 rounded-full text-base shadow whitespace-nowrap"><i class="fas fa-star mr-2"></i>Layanan Terbaik</span>
                <span class="inline-flex items-center bg-orange-400 text-gray-900 font-semibold px-4 py-1 rounded-full text-base shadow whitespace-nowrap"><i class="fas fa-shield-alt mr-2"></i>Pembayaran yang Aman</span>
                <span class="inline-flex items-center bg-blue-400 text-gray-900 font-semibold px-4 py-1 rounded-full text-base shadow whitespace-nowrap"><i class="fas fa-headset mr-2"></i>Layanan Pelanggan 24/7</span>
                <span class="inline-flex items-center bg-yellow-500 text-gray-900 font-semibold px-4 py-1 rounded-full text-base shadow whitespace-nowrap"><i class="fas fa-bolt mr-2"></i>Pengiriman Cepat</span>
            </div>
            <div class="text-gray-200 text-base md:text-lg font-normal text-left">
                {{ $product->description ?? 'Beli Top Up ML Diamond Mobile Legends dan Weekly Diamond Pass MLBB Harga Termurah Se-Indonesia, Dijamin Aman, Cepat dan Terpercaya hanya ada di Tuhu Shop.' }}
            </div>
        </div>
    </div>
    <!-- END INFO PRODUK FLEX -->
    <!-- PILIH NOMINAL + FORM & PEMBAYARAN GRID -->
    <div class="w-full px-2 mt-8 flex flex-col md:flex-row gap-4 min-h-[600px]">
        <!-- KIRI: Denom, deskripsi, rekomendasi -->
        <div class="w-full md:w-2/3">
            <!-- Header Step -->
            <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2 mb-4">
                <span class="font-bold text-2xl mr-2">1</span>
                <span class="font-bold text-lg">Pilih Nominal</span>
            </div>
            <!-- Tab Pilihan Kategori -->
            <div class="flex gap-4 mb-4">
                @foreach($kategoriDenoms as $kategori)
                    <a href="?kategori={{ $kategori->slug }}" class="flex-1 text-center py-4 rounded-lg font-bold text-lg transition-all duration-200 {{ $kategoriAktif == $kategori->slug ? 'bg-cyan-400 text-white' : 'bg-[#23232a] text-cyan-400' }}">
                        {{ $kategori->nama }}
                    </a>
                @endforeach
            </div>
            <!-- Denom Selection Modern -->
            <div class="bg-[#181820] rounded-lg shadow-md p-6">
    @if($filteredDenoms->count() > 0)
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-cyan-400 mb-4 flex items-center">
            {{ ucfirst($kategoriAktif) }}
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($filteredDenoms as $denom)
            <div class="bg-[#23232a] rounded-xl p-0 flex overflow-hidden shadow hover:shadow-lg transition cursor-pointer denom-card border-2 border-transparent hover:border-cyan-400 min-h-[100px] select-none"
                 onclick="selectDenom(event, {{ $denom->id }}, '{{ $denom->nama_denom ?: $denom->nama_produk }}', {{ $denom->harga_jual ?: $denom->harga }})">
                <!-- Gaya Layout Baru -->
                <div class="flex-1 flex flex-col justify-center px-4 py-3">
                    <!-- Nama Denom -->
                    <div class="text-white font-bold text-sm mb-2">
                        {{ $denom->nama_produk ?? $denom->denom ?? $denom->desc ?? '-' }}
                    </div>
                    <!-- Harga -->
                    <div class="text-cyan-300 font-semibold text-base">
                        Rp{{ number_format($denom->harga_jual ?: $denom->harga, 0, ',', '.') }}
                    </div>
                </div>
                <!-- Gambar Logo -->
                <div class="flex items-center justify-center bg-[#23232a] px-4">
                    @if(!empty($denom->logo))
                        <img src="{{ asset('storage/' . $denom->logo) }}" alt="Logo {{ $denom->nama_denom ?? $denom->nama_produk }}" class="w-12 h-12 object-contain rounded">
                    @else
                        
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-coins text-6xl"></i>
        </div>
        <h3 class="text-lg font-medium text-white mb-2">Belum ada denom tersedia</h3>
        <p class="text-gray-300">Produk ini sedang dalam maintenance</p>
    </div>
    @endif
</div>


            <!-- DESKRIPSI & REKOMENDASI TOPUP GAME -->
            <div class="mt-8">
                <!-- Deskripsi Game -->
                <div class="bg-[#181820] rounded-lg p-6 mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Deskripsi {{ $product->product_name }}</h2>
                    <p class="text-gray-200 mb-2">
                        {{ $product->description ?? ''}}
                    </p>
                    @if(!empty($product->description) && strlen(strip_tags($product->description)) > 120)
                        <button class="text-cyan-400 font-semibold hover:underline text-left">Show more</button>
                    @endif
                </div>
                <!-- Rekomendasi Topup Game -->
                <h2 class="text-2xl font-bold text-white mb-4">Rekomendasi Topup Game</h2>
                <div id="rekomendasi-carousel" class="flex gap-8 overflow-x-auto pb-2 hide-scrollbar max-h-72 overflow-y-hidden">
                    @foreach($allGame as $game)
                        <a href="{{ route('produk.public', $game->product_id) }}" class="block">
                            <div class="rounded-2xl overflow-hidden bg-[#23272f] w-60 h-60 flex-shrink-0">
                                <img src="{{ asset('image/' . $game->thumbnail_url) }}" alt="{{ $game->product_name }}" class="w-full h-full object-cover">
                            </div>
                        </a>
                    @endforeach
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const carousel = document.getElementById('rekomendasi-carousel');
                    if (!carousel) return;
                    const card = carousel.querySelector('div');
                    if (!card) return;
                    const cardWidth = card.offsetWidth + 32; // 32px gap-8
                    let scrollAmount = 0;
                    let maxScroll = carousel.scrollWidth - carousel.clientWidth;
                    let autoScrollInterval;
                    let autoScrollDelayTimeout;

                    function startAutoScroll() {
                        clearInterval(autoScrollInterval);
                        autoScrollInterval = setInterval(() => {
                            maxScroll = carousel.scrollWidth - carousel.clientWidth;
                            if (scrollAmount + cardWidth >= maxScroll) {
                                scrollAmount = 0;
                            } else {
                                scrollAmount += cardWidth;
                            }
                            carousel.scrollTo({ left: scrollAmount, behavior: 'smooth' });
                        }, 2500);
                    }

                    function pauseAutoScroll() {
                        clearInterval(autoScrollInterval);
                        clearTimeout(autoScrollDelayTimeout);
                        autoScrollDelayTimeout = setTimeout(() => {
                            startAutoScroll();
                        }, 10000);
                    }

                    ['pointerdown', 'touchstart', 'wheel', 'mousedown'].forEach(evt => {
                        carousel.addEventListener(evt, pauseAutoScroll, { passive: true });
                    });
                    ['pointerup', 'touchend', 'mouseup'].forEach(evt => {
                        carousel.addEventListener(evt, () => {
                            clearTimeout(autoScrollDelayTimeout);
                            autoScrollDelayTimeout = setTimeout(() => {
                                startAutoScroll();
                            }, 10000);
                        }, { passive: true });
                    });

                    startAutoScroll();
                });
                </script>
            </div>
            <!-- END DESKRIPSI & REKOMENDASI -->
        </div>
        <!-- KANAN: Form & Pembayaran -->
        <div class="w-full md:w-1/3 flex flex-col gap-6 md:sticky md:top-24 h-fit">
            <!-- Step 2: Masukan Detil Akun -->
            <div class="bg-[#181820] rounded-lg shadow-md">
                <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2 mb-4">
                    <span class="font-bold text-2xl mr-2">2</span>
                    <span class="font-bold text-lg">Masukan Detil Akun <i class='fas fa-question-circle text-base ml-1'></i></span>
                </div>
                <form class="p-4" method="POST" action="#">
                    @csrf
                    <input type="hidden" name="denom_id" id="denom_id">
                    @if(!empty($accountFields) && is_array($accountFields))
                        @if(count($accountFields) === 1)
                            @foreach($accountFields as $field)
                                <div class="mb-4">
                                    @php $name = $field['name'] ?? $field['label'] ?? 'field'; @endphp
                                    <label for="{{ $name }}" class="block mb-2 font-semibold">{{ $field['label'] ?? $name }}</label>
                                    <input type="text" name="{{ $name }}" id="{{ $name }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old($name) }}" placeholder="{{ $field['placeholder'] ?? '' }}">
                                </div>
                            @endforeach
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                @foreach($accountFields as $field)
                                    <div>
                                        @php $name = $field['name'] ?? $field['label'] ?? 'field'; @endphp
                                        <label for="{{ $name }}" class="block mb-2 font-semibold text-gray-700">{{ $field['label'] ?? $name }}</label>
                                        <input type="text" name="{{ $name }}" id="{{ $name }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ old($name) }}" placeholder="{{ $field['placeholder'] ?? '' }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div>
                            <input type="text" name="account" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan data akun">
                        </div>
                    @endif
                    <div class="text-xs text-gray-400 mt-2">
                        {{ $product->account_instruction ?? '' }}
                    </div>
                </form>
            </div>
            <!-- Step 3: Pilih Pembayaran -->
            <div class="bg-[#181820] rounded-lg shadow-md">
                <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2 mb-4">
                    <span class="font-bold text-2xl mr-2">3</span>
                    <span class="font-bold text-lg">Pilih Pembayaran</span>
                </div>
                <div class="space-y-4 p-4">
                    <div class="bg-white rounded-lg p-4 flex items-center justify-between cursor-pointer hover:shadow-lg transition payment-method border-2 border-transparent">
                        <span class="font-semibold text-gray-800">QRIS & Dompet Digital</span>
                        <div class="flex gap-2">
                            <i class="fab fa-cc-visa text-2xl text-gray-600"></i>
                            <i class="fab fa-cc-mastercard text-2xl text-gray-600"></i>
                            <i class="fab fa-cc-paypal text-2xl text-gray-600"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 flex items-center justify-between cursor-pointer hover:shadow-lg transition payment-method border-2 border-transparent">
                        <span class="font-semibold text-gray-800">Retail</span>
                        <div class="flex gap-2">
                            <i class="fas fa-store text-2xl text-gray-600"></i>
                            <i class="fas fa-store-alt text-2xl text-gray-600"></i>
                        </div>
                    </div>
                    <!-- Tambahkan metode pembayaran lain sesuai kebutuhan -->
                </div>
            </div>
            <!-- STEP 4: Kode Promo -->
            <div class="w-full px-2 mt-8">
                <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2 mb-4 max-w-xl">
                    <span class="font-bold text-2xl mr-2">4</span>
                    <span class="font-bold text-lg">Kode Promo</span>
                </div>
                <div class="bg-[#181820] rounded-lg shadow-md p-6 max-w-xl">
                    <input type="text" class="rounded-lg px-4 py-2 bg-[#23232a] text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 w-full" placeholder="Masukkan Kode Promo">
                </div>
            </div>
            <!-- STEP 5: Selesaikan Pembayaran (Email/WhatsApp) -->
            <div class="w-full px-2 mt-8 max-w-xl">
                <div class="flex items-center bg-cyan-400 rounded-t-lg px-4 py-2 mb-4">
                    <span class="font-bold text-2xl mr-2">5</span>
                    <span class="font-bold text-lg">Selesaikan Pembayaran</span>
                </div>
                <div class="bg-[#181820] rounded-lg shadow-md p-6">
                    <form class="space-y-4">
                        <div>
                            <label class="block text-white mb-1">Email (untuk notifikasi pembayaran)</label>
                            <input type="email" class="w-full rounded-lg px-4 py-2 bg-[#23232a] text-white focus:outline-none focus:ring-2 focus:ring-cyan-400" placeholder="Masukkan Email">
                        </div>
                        <div>
                            <label class="block text-white mb-1">WhatsApp (opsional)</label>
                            <input type="text" class="w-full rounded-lg px-4 py-2 bg-[#23232a] text-white focus:outline-none focus:ring-2 focus:ring-cyan-400" placeholder="08xxxxxxxxxx">
                        </div>
                        <button type="submit" class="w-full bg-cyan-400 text-gray-900 font-bold py-2 rounded-lg hover:bg-cyan-500 transition">Selesaikan Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PILIH NOMINAL + FORM & PEMBAYARAN GRID -->
     <!-- Footer -->
     <footer class="relative bg-blueGray-200 pt-8">
        <div class="mx-auto px-4 pt-2 text-white" style="background-color: #393E46;">
            <div class="flex flex-wrap text-left lg:text-left">
                <div class="w-full lg:w-6/12 px-4">
                    <h4 class="text-2xl fonat-semibold text-blueGray-700 font-bold">TUHU SHOP</h4>
                    <h5 class="text-sm mt-0 mb-2 text-blueGray-600">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Saepe non, deserunt ipsum voluptatem sunt veniam consequatur delectus explicabo libero omnis vel nihil ipsam ex fugit aliquam quaerat impedit? Dignissimos, architecto.
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
                            <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Useful Links</span>
                            <ul class="list-unstyled">
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800 block pb-2 text-sm" href="https://www.creative-tim.com/presentation?ref=njs-profile">About Us</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800  block pb-2 text-sm" href="https://blog.creative-tim.com?ref=njs-profile">Blog</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800 block pb-2 text-sm" href="https://www.github.com/creativetimofficial?ref=njs-profile">Github</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800  block pb-2 text-sm" href="https://www.creative-tim.com/bootstrap-themes/free?ref=njs-profile">Free Products</a>
                                </li>
                            </ul>
                        </div>
                        <div class="w-full lg:w-4/12 px-4">
                            <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Other Resources</span>
                            <ul class="list-unstyled">
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800 block pb-2 text-sm" href="https://github.com/creativetimofficial/notus-js/blob/main/LICENSE.md?ref=njs-profile">MIT License</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800 block pb-2 text-sm" href="https://creative-tim.com/terms?ref=njs-profile">Terms &amp; Conditions</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800 block pb-2 text-sm" href="https://creative-tim.com/privacy?ref=njs-profile">Privacy Policy</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800 block pb-2 text-sm" href="https://creative-tim.com/contact-us?ref=njs-profile">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-6 border-blueGray-300">
            <div class="flex flex-wrap items-center md:justify-between justify-center">
                <div class="w-full md:w-4/12 px-4 mx-auto text-center">
                    <div class="text-sm text-blueGray-500 py-1">
                        Copyright © <span id="get-current-year">2024</span><a href="https://www.creative-tim.com/product/notus-js" class="text-blueGray-500 hover:text-gray-800" target="_blank"> Tuhu Shop
                        <a href="https://www.creative-tim.com?ref=njs-profile" class="text-blueGray-500 hover:text-blueGray-800">|| Tuhu Pangestu</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>   
    <script>
        function selectDenom(event, denomId, denomName, price) {
            // Remove previous selection
            document.querySelectorAll('.denom-card').forEach(card => {
                card.classList.remove('selected');
            });
            // Add selection to clicked card
            event.currentTarget.classList.add('selected');
            // Update form
            document.getElementById('denom_id').value = denomId;
            if(document.getElementById('selected-denom-name'))
                document.getElementById('selected-denom-name').textContent = denomName;
            if(document.getElementById('selected-denom-price'))
                document.getElementById('selected-denom-price').textContent = 'Rp' + price.toLocaleString('id-ID');
            // Show checkout form
            if(document.getElementById('checkout-form'))
                document.getElementById('checkout-form').classList.remove('hidden');
            // Scroll to checkout form
            if(document.getElementById('checkout-form'))
                document.getElementById('checkout-form').scrollIntoView({ behavior: 'smooth' });
        }

        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                // Remove previous selection
                document.querySelectorAll('.payment-method').forEach(m => {
                    m.classList.remove('border-purple-500', 'bg-purple-50');
                });
                
                // Add selection to clicked method
                this.classList.add('border-purple-500', 'bg-purple-50');
            });
        });
    </script>
</body>
</html> 