<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <style>
        /* Global scaling to match 80% zoom preference */
        html {
            font-size: 80%; /* This will scale everything down to match 80% zoom */
        }
        
        /* Ensure body maintains proper scaling */
        body {
            font-size: 1.25rem; /* Compensate for the 80% html scaling */
        }
        
        /* Specific adjustments for better proportions */
        .text-2xl { font-size: 1.5rem !important; }
        .text-3xl { font-size: 1.875rem !important; }
        .text-4xl { font-size: 2.25rem !important; }
        .text-lg { font-size: 1.125rem !important; }
        .text-base { font-size: 1rem !important; }
        .text-sm { font-size: 0.875rem !important; }
        
        /* Game cards adjustments */
        .game-item {
            min-height: 120px !important;
        }
        
        /* Carousel adjustments */
        .carousel-container {
            max-height: 300px !important;
        }
        
        /* Navigation adjustments */
        .nav-link {
            font-size: 0.9rem !important;
        }
        
        /* Button adjustments */
        .btn-primary {
            padding: 0.5rem 1rem !important;
            font-size: 0.9rem !important;
        }
        
        .hover-effect::after {
            display: none !important;
            background: none !important;
            content: none !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            html {
                font-size: 85%; /* Slightly larger on mobile */
            }
        }
        
        @media (min-width: 1200px) {
            html {
                font-size: 75%; /* Slightly smaller on large screens */
            }
        }

            /* Kategori Produk Modern Responsive */
        .kategori-group {
            margin-bottom: 0.5rem;
        }
        .kategori-btn {
            background: #181820;
            border: 2px solid #22d3ee;
            color: #fff;
            font-weight: bold;
            font-size: 1.15rem;
            border-radius: 0.75rem;
            padding: 0.75rem 2.2rem;
            margin: 0;
            box-shadow: 0 2px 8px rgba(34,211,238,0.08);
            transition: background 0.2s, color 0.2s, border 0.2s, box-shadow 0.2s;
            outline: none;
            min-width: 120px;
            display: inline-block;
        }
        .kategori-btn:hover, .kategori-btn.active {
            background: #22d3ee;
            color: #181820;
            border-color: #22d3ee;
            box-shadow: 0 4px 16px rgba(34,211,238,0.18);
        }
        @media (max-width: 600px) {
            .kategori-btn {
                font-size: 1rem;
                padding: 0.6rem 1.2rem;
                min-width: 90px;
            }
        }
    </style>
</head>
<body>
    <nav class="bg-[#181820] px-6 py-4 sticky top-0 z-50 shadow-lg">
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
                <input type="text" class="w-full bg-[#2D2D2D] text-white rounded-lg px-4 py-2.5 pl-11 focus:outline-none focus:ring-2 focus:ring-[#e5c07b]" placeholder="Cari Game atau Voucher">
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
                <a href="/topup" class="flex items-center gap-2 text-white font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Topup
                </a>
                <a href="/cekTransaksi" class="flex items-center gap-2 font-semibold hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    Cek Transaksi
                </a>
                <a href="/leaderboard" class="flex items-center gap-2 font-semibold hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Leaderboard
                </a>
                <a href="/kalkulator" class="flex items-center gap-2 font-semibold hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                    Kalkulator
                </a>
            </div>
            <div class="flex items-center gap-8 text-gray-300">
                <a href="/login" class="flex items-center gap-2 font-semibold hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    Masuk
                </a>
                <a href="/register" class="flex items-center gap-2 font-semibold hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Daftar
                </a>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto mt-20 p-5">
        <!-- Carousel Section -->
        <div class="relative w-full max-w-4xl mx-auto overflow-hidden rounded-lg shadow-lg">
            <!-- Slides -->
            <div class="flex transition-transform duration-500 ease-in-out" id="carousel-slides">
                <!-- Slide 1 -->
                <div class="min-w-full">
                    <img src="{{ asset('image/pokemon.jpg') }}" alt="Slide 1" class="w-full h-96 object-cover">
                </div>
                <!-- Slide 2 -->
                <div class="min-w-full">
                    <img src="https://fastcdn.hoyoverse.com/content-v2/plat/127049/f6dfee9a74478eccbe59c547277241df_9046600959592478924.jpeg?x-oss-process=image/resize,w_800/quality,q_80" alt="Slide 2" class="w-full h-96 object-cover">
                </div>
                <!-- Slide 3 -->
                <div class="min-w-full">
                    <img src="https://imgsrv2.voi.id/-IAsGkRlvNPY263nJJy5I-WKedgLYiCgshcw7tTcW7s/auto/1200/675/sm/1/bG9jYWw6Ly8vcHVibGlzaGVycy80MTI2NTIvMjAyNDA4MzExMzExLW1haW4uY3JvcHBlZF8xNzI1MDg0NzE1LmpwZWc.jpg" alt="Slide 3" class="w-full h-96 object-cover">
                </div>
            </div>
            <!-- Controls -->
            <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition duration-200">
                &#10094;
            </button>
            <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition duration-200">
                &#10095;
            </button>
            <!-- Indicators -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <div class="w-3 h-3 bg-white rounded-full cursor-pointer indicator" onclick="goToSlide(0)"></div>
                <div class="w-3 h-3 bg-white rounded-full cursor-pointer indicator" onclick="goToSlide(1)"></div>
                <div class="w-3 h-3 bg-white rounded-full cursor-pointer indicator" onclick="goToSlide(2)"></div>
            </div>
        </div>

        <!-- Bagian POPULER (Tetap Seperti Semula) -->
        <h1 class="text-white font-bold text-2xl mb-3 mt-5">POPULER</h1>
        <div class="grid grid-cols-4 gap-4">
            @foreach($populerGames as $game)
            <a href="{{ route('produk.public', $game->product_id) }}" class="block">
                <div class="p-3 rounded-lg bg-charcoal flex items-center hover:bg-aqua hover:shadow-lg transition duration-200">
                    <img src="{{ asset('image/' . $game->thumbnail_url) }}" alt="" class="w-24 h-24 rounded-lg object-cover">
                    <div class="pl-3">
                        <h1 class="text-white text-lg font-bold leading-tight mb-1">
                            {{ $game->game_name ?? $game->product_name ?? 'Tanpa Nama' }}
                        </h1>
                        <p class="text-gray-300 text-sm">{{ $game->developer ?? '-' }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Kategori Produk -->
        <div class="flex gap-2 my-7">
            <div class="flex flex-wrap gap-4 justify-start kategori-group">
                <button id="topup" class="kategori-btn active">Topup</button>
                <button id="voucher" class="kategori-btn">Voucher</button>
                <button id="joki" class="kategori-btn">Joki</button>
                <button id="tagihan" class="kategori-btn">Tagihan</button>
            </div>
        </div>
        <!-- Daftar Produk Berdasarkan Kategori -->
        <div id="topup-products" class="grid grid-cols-5 gap-7">
            @foreach($allGame as $index => $game)
                <a href="{{ route('produk.public', $game->product_id) }}" class="block">
                    <div class="hover-effect game-item relative group"
                        style="background-image: url('{{ asset('image/' . $game->thumbnail_url) }}');"
                        data-index="{{ $index }}"
                        {{ $index >= 10 ? 'hidden' : '' }}>
                        <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <h3 class="text-white text-lg font-bold mb-1">{{ $game->game_name ?? $game->product_name ?? 'Tanpa Nama' }}</h3>
                            <p class="text-gray-300 text-sm">{{ $game->developer ?? '-' }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if(count($allGame) > 10)
        <div class="text-center mt-4">
            <button id="loadMore" class="bg-gray-700 border-2 border-aqua text-white px-4 py-2 rounded-lg hover:bg-aqua">Tampilkan Lainnya...</button>
        </div>
        @endif

        <div id="voucher-products" class="grid grid-cols-5 gap-7 hidden">
            <!-- Produk Voucher -->
            <div class="hover-effect" style="background-image: url('https://beebom.com/wp-content/uploads/2024/07/mavuika-hands-outstretched-genshin-impact.jpg?w=1024');" data-text="Voucher Mobile Legends"></div>
            <div class="hover-effect" style="background-image: url('https://beebom.com/wp-content/uploads/2024/07/mavuika-hands-outstretched-genshin-impact.jpg?w=1024');" data-text="Voucher Genshin Impact"></div>
            <div class="hover-effect" style="background-image: url('https://assetsio.gnwcdn.com/star-rail-header_ZFCrdUs.jpg?width=1600&height=900&fit=crop&quality=100&format=png&enable=upscale&auto=webp');" data-text="Voucher Honkai Star Rail"></div>
            <div class="hover-effect" style="background-image: url('https://cdn1-production-images-kly.akamaized.net/i9YUtTNuIlxxvGBgDd6qzODLffw=/1200x900/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4875198/original/043115600_1719380858-1_Free_Fire_7th_Anniversay_-_Login_key_visual.jpeg');" data-text="Voucher Free Fire"></div>
            <div class="hover-effect" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiTWZvs1TLI--wNThxVTu4Yjuejwc99I_5Ew&s');" data-text="Voucher Minecraft"></div>
        </div>

        <div id="joki-products" class="grid grid-cols-5 gap-7 hidden">
            <!-- Produk Joki -->
            <div class="hover-effect" style="background-image: url('https://cdn.vcgamers.com/news/wp-content/uploads/2022/11/aldous-Wallpaper-Mobile-Legends-HD.-Sumber-uhdpaper.com_.jpg');" data-text="Joki Mobile Legends"></div>
            <div class="hover-effect" style="background-image: url('https://beebom.com/wp-content/uploads/2024/07/mavuika-hands-outstretched-genshin-impact.jpg?w=1024');" data-text="Joki Genshin Impact"></div>
            <div class="hover-effect" style="background-image: url('https://assetsio.gnwcdn.com/star-rail-header_ZFCrdUs.jpg?width=1600&height=900&fit=crop&quality=100&format=png&enable=upscale&auto=webp');" data-text="Joki Honkai Star Rail"></div>
            <div class="hover-effect" style="background-image: url('https://cdn1-production-images-kly.akamaized.net/i9YUtTNuIlxxvGBgDd6qzODLffw=/1200x900/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4875198/original/043115600_1719380858-1_Free_Fire_7th_Anniversay_-_Login_key_visual.jpeg');" data-text="Joki Free Fire"></div>
            <div class="hover-effect" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiTWZvs1TLI--wNThxVTu4Yjuejwc99I_5Ew&s');" data-text="Joki Minecraft"></div>
        </div>

        <div id="tagihan-products" class="grid grid-cols-5 gap-7 hidden">
            <!-- Produk Tagihan -->
            <div class="hover-effect" style="background-image: url('https://cdn.vcgamers.com/news/wp-content/uploads/2022/11/aldous-Wallpaper-Mobile-Legends-HD.-Sumber-uhdpaper.com_.jpg');" data-text="Tagihan Mobile Legends"></div>
            <div class="hover-effect" style="background-image: url('https://beebom.com/wp-content/uploads/2024/07/mavuika-hands-outstretched-genshin-impact.jpg?w=1024');" data-text="Tagihan Genshin Impact"></div>
            <div class="hover-effect" style="background-image: url('https://assetsio.gnwcdn.com/star-rail-header_ZFCrdUs.jpg?width=1600&height=900&fit=crop&quality=100&format=png&enable=upscale&auto=webp');" data-text="Tagihan Honkai Star Rail"></div>
            <div class="hover-effect" style="background-image: url('https://cdn1-production-images-kly.akamaized.net/i9YUtTNuIlxxvGBgDd6qzODLffw=/1200x900/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/4875198/original/043115600_1719380858-1_Free_Fire_7th_Anniversay_-_Login_key_visual.jpeg');" data-text="Tagihan Free Fire"></div>
            <div class="hover-effect" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSiTWZvs1TLI--wNThxVTu4Yjuejwc99I_5Ew&s');" data-text="Tagihan Minecraft"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="relative bg-blueGray-200 pt-8">
        <div class="mx-auto px-4 pt-2 text-white" style="background-color: #393E46;">
            <div class="flex flex-wrap text-left lg:text-left">
                <div class="w-full lg:w-6/12 px-4">
                    <h4 class="text-2xl fonat-semibold text-blueGray-700 font-bold">TUHU SHOP</h4>
                    <h5 class="text-sm mt-0 mb-2 text-blueGray-600">
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
        // JavaScript untuk Carousel
        let currentSlide = 0;
        const slides = document.querySelectorAll('#carousel-slides > div');
        const indicators = document.querySelectorAll('.indicator');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.transform = `translateX(-${index * 100}%)`;
            });
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('bg-white', i === index);
                indicator.classList.toggle('bg-gray-500', i !== index);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        }

        function goToSlide(index) {
            currentSlide = index;
            showSlide(currentSlide);
        }

        document.getElementById('next').addEventListener('click', nextSlide);
        document.getElementById('prev').addEventListener('click', prevSlide);

        setInterval(nextSlide, 5000); // Auto-slide every 5 seconds

        // JavaScript untuk Menampilkan Produk Berdasarkan Kategori & efek active
        const kategoriButtons = document.querySelectorAll('.kategori-btn');
        const topupProducts = document.getElementById('topup-products');
        const voucherProducts = document.getElementById('voucher-products');
        const jokiProducts = document.getElementById('joki-products');
        const tagihanProducts = document.getElementById('tagihan-products');

        function hideAllProducts() {
            topupProducts.classList.add('hidden');
            voucherProducts.classList.add('hidden');
            jokiProducts.classList.add('hidden');
            tagihanProducts.classList.add('hidden');
        }

        // Tampilkan produk topup secara default
        hideAllProducts();
        topupProducts.classList.remove('hidden');

        kategoriButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                kategoriButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                hideAllProducts();
                if(this.id === 'topup') topupProducts.classList.remove('hidden');
                if(this.id === 'voucher') voucherProducts.classList.remove('hidden');
                if(this.id === 'joki') jokiProducts.classList.remove('hidden');
                if(this.id === 'tagihan') tagihanProducts.classList.remove('hidden');
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
        let games = document.querySelectorAll(".game-item");
        let loadMoreBtn = document.getElementById("loadMore");
        let visibleCount = 10; // Game yang ditampilkan pertama kali
        let increment = 10; // Jumlah game yang ditampilkan setiap kali tombol ditekan

        loadMoreBtn.addEventListener("click", function() {
            for (let i = visibleCount; i < visibleCount + increment && i < games.length; i++) {
                games[i].hidden = false; // Tampilkan game yang tersembunyi
            }
            visibleCount += increment; // Update jumlah game yang sudah ditampilkan

            // Sembunyikan tombol jika semua game sudah tampil
            if (visibleCount >= games.length) {
                loadMoreBtn.style.display = "none";
            }
        });
    });
    </script>
</body>
</html>