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
            font-size: 80%;
        }
        
        /* Ensure body maintains proper scaling and is a positioning context */
        body {
            font-size: 1.25rem;
            background-color: #1F1F2B;
            position: relative; /* Diperlukan untuk z-index */
            overflow-x: hidden; /* Mencegah scroll horizontal karena animasi */
        }
        
        /* === CSS UNTUK ANIMASI BINTANG JATUH (BACKGROUND) === */
        .shooting-stars-background {
            position: fixed; /* Tetap di posisi viewport */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none; /* Tidak bisa diklik */
            z-index: 0; /* Diletakkan di paling belakang */
            overflow: hidden;
        }

        .shooting-stars-background .star {
            position: absolute;
            background: #FFF;
            border-radius: 50%;
            animation: shoot linear infinite;
        }
        
        @keyframes shoot {
            0% {
                transform: translate(0, 0) rotate(-45deg);
                opacity: 1;
            }
            100% {
                /* Bergerak melintasi layar secara diagonal */
                transform: translate(-120vw, 120vh) rotate(-45deg);
                opacity: 0;
            }
        }

        .shooting-stars-background .star::before {
             content: '';
             position: absolute;
             width: 150px; /* Panjang ekor bintang */
             height: 1px;
             background: linear-gradient(90deg, rgba(255,255,255,0.7), transparent);
             transform: translateY(-50%);
        }

        /* Variasi untuk setiap bintang agar terlihat natural */
        .shooting-stars-background .star:nth-child(1) { top: 10%; right: 0; width: 1px; height: 1px; animation-delay: 0s; animation-duration: 3.5s; }
        .shooting-stars-background .star:nth-child(2) { top: 30%; right: 100px; width: 2px; height: 2px; animation-delay: 1.2s; animation-duration: 4s; }
        .shooting-stars-background .star:nth-child(3) { top: 80%; right: 50px; width: 1px; height: 1px; animation-delay: 2.1s; animation-duration: 5.1s; }
        .shooting-stars-background .star:nth-child(4) { top: 5%; right: 250px; width: 2px; height: 2px; animation-delay: 3.5s; animation-duration: 3s; }
        .shooting-stars-background .star:nth-child(5) { top: 55%; right: 400px; width: 1px; height: 1px; animation-delay: 4.8s; animation-duration: 4.5s; }
        .shooting-stars-background .star:nth-child(6) { top: 90%; right: 200px; width: 2px; height: 2px; animation-delay: 6.2s; animation-duration: 5.5s; }
        .shooting-stars-background .star:nth-child(7) { top: 45%; right: 600px; width: 1px; height: 1px; animation-delay: 7.5s; animation-duration: 2.8s; }
        .shooting-stars-background .star:nth-child(8) { top: 25%; right: 800px; width: 1px; height: 1px; animation-delay: 8.1s; animation-duration: 4.2s; }

        /* Pastikan semua konten utama berada di atas background animasi */
        nav, .container, footer {
            position: relative;
            z-index: 1;
        }

        /* Specific adjustments for better proportions */
        .text-2xl { font-size: 1.5rem !important; }
        .text-3xl { font-size: 1.875rem !important; }
        .text-4xl { font-size: 2.25rem !important; }
        .text-lg { font-size: 1.125rem !important; }
        .text-base { font-size: 1rem !important; }
        .text-sm { font-size: 0.875rem !important; }
        
        .game-item {
            min-height: 120px !important;
            height: 250px;
            background-size: cover;
        }
                
        .carousel-container {
            max-height: 300px !important;
        }
        
        .nav-link {
            font-size: 0.9rem !important;
        }
        
        .btn-primary {
            padding: 0.5rem 1rem !important;
            font-size: 0.9rem !important;
        }
        
        .hover-effect::after {
            display: none !important;
            background: none !important;
            content: none !important;
        }
        
        @media (max-width: 768px) {
            html { font-size: 85%; }
        }
        
        @media (min-width: 1200px) {
            html { font-size: 75%; }
        }

        .kategori-btn {
            background-color: #3A3A3A;
            color: #FFFFFF;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 0.5rem;
            padding: 0.6rem 1.2rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
            outline: none;
            white-space: nowrap;
        }

        .kategori-btn:hover:not(.active) {
            background-color: #4F4F4F;
        }

        .kategori-btn.active {
            background-color: #A89580;
            color: #181820;
            font-weight: 600;
            cursor: default;
        }

        .kategori-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .kategori-container::-webkit-scrollbar {
            display: none;
        }
        
        @media (max-width: 768px) {
            .kategori-btn {
                font-size: 0.85rem;
                padding: 0.5rem 1rem;
            }
        }

        .btn-load-more {
            background-color: #3A3A3A;
            color: #FFFFFF;
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease-in-out;
            border: none;
            font-weight: 500;
        }

        .btn-load-more:hover {
            background-color: #4F4F4F;
        }
    </style>
</head>
<body class="bg-[#1F1F2B]">

    <div class="shooting-stars-background">
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
        <span class="star"></span>
    </div>
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
                <a href="/topup" class="flex items-center gap-2 transition-colors pb-1 {{ request()->is('topup') ? 'text-[#e5c07b] border-b-2 border-[#e5c07b]' : 'text-white hover:text-[#e5c07b]' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Topup
                </a>
                <a href="/cekTransaksi" class="flex items-center gap-2 transition-colors pb-1 {{ request()->is('cekTransaksi') ? 'text-[#e5c07b] border-b-2 border-[#e5c07b]' : 'text-white hover:text-[#e5c07b]' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    Cek Transaksi
                </a>
                <a href="/leaderboard" class="flex items-center gap-2 transition-colors pb-1 {{ request()->is('leaderboard') ? 'text-[#e5c07b] border-b-2 border-[#e5c07b]' : 'text-white hover:text-[#e5c07b]' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Leaderboard
                </a>
                <a href="/kalkulator" class="flex items-center gap-2 transition-colors pb-1 {{ request()->is('kalkulator') ? 'text-[#e5c07b] border-b-2 border-[#e5c07b]' : 'text-white hover:text-[#e5c07b]' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
                    Kalkulator
                </a>
            </div>
            <div class="flex items-center gap-8 text-gray-300">
                <a href="/login" class="flex items-center gap-2 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    Masuk
                </a>
                <a href="/register" class="flex items-center gap-2 hover:text-white transition-colors">
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

    <div class="container mx-auto mt-7 p-5">
        <div class="relative w-full max-w-4xl mx-auto overflow-hidden rounded-lg shadow-lg">
            <div class="flex transition-transform duration-500 ease-in-out" id="carousel-slides">
                <div class="min-w-full">
                    <img src="{{ asset('image/pokemon.jpg') }}" alt="Slide 1" class="w-full h-96 object-cover">
                </div>
                <div class="min-w-full">
                    <img src="https://fastcdn.hoyoverse.com/content-v2/plat/127049/f6dfee9a74478eccbe59c547277241df_9046600959592478924.jpeg?x-oss-process=image/resize,w_800/quality,q_80" alt="Slide 2" class="w-full h-96 object-cover">
                </div>
                <div class="min-w-full">
                    <img src="https://imgsrv2.voi.id/-IAsGkRlvNPY263nJJy5I-WKedgLYiCgshcw7tTcW7s/auto/1200/675/sm/1/bG9jYWw6Ly8vcHVibGlzaGVycy80MTI2NTIvMjAyNDA4MzExMzExLW1haW4uY3JvcHBlZF8xNzI1MDg0NzE1LmpwZWc.jpg" alt="Slide 3" class="w-full h-96 object-cover">
                </div>
            </div>
            <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition duration-200 z-20">
                &#10094;
            </button>
            <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition duration-200 z-20">
                &#10095;
            </button>
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                <div class="w-3 h-3 bg-white rounded-full cursor-pointer indicator" onclick="goToSlide(0)"></div>
                <div class="w-3 h-3 bg-white rounded-full cursor-pointer indicator" onclick="goToSlide(1)"></div>
                <div class="w-3 h-3 bg-white rounded-full cursor-pointer indicator" onclick="goToSlide(2)"></div>
            </div>
        </div>

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

        <div class="my-7">
            <div class="flex items-center gap-3 pb-2 overflow-x-auto kategori-container">
                <button id="topup" class="kategori-btn active">Top Up Games</button>
                <button id="joki" class="kategori-btn">Joki MLBB</button> <button class="kategori-btn">Joki HOK</button>
                <button class="kategori-btn">Top Up via LINK</button>
                <button class="kategori-btn">Pulsa & Data</button>
                <button id="voucher" class="kategori-btn">Voucher</button>
                <button class="kategori-btn">Entertainment</button>
                <button id="tagihan" class="kategori-btn">Tagihan</button>
            </div>
        </div>

        <div id="topup-products" class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @foreach($allGame as $index => $game)
                <a href="{{ route('produk.public', $game->product_id) }}" class="block">
                    <div class="hover-effect game-item relative group"
                         style="background-image: url('{{ asset('image/' . $game->thumbnail_url) }}');"
                         data-index="{{ $index }}"
                         {{ $index >= 12 ? 'hidden' : '' }}>
                        <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <h3 class="text-white text-lg font-bold mb-1">{{ $game->game_name ?? $game->product_name ?? 'Tanpa Nama' }}</h3>
                            <p class="text-gray-300 text-sm">{{ $game->developer ?? '-' }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if(count($allGame) > 12)
        <div class="text-center mt-4">
            <button id="loadMore" class="btn-load-more">Tampilkan Lainnya</button>
        </div>
        @endif

        <div id="voucher-products" class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5 hidden">
            <div class="hover-effect" style="background-image: url('https://beebom.com/wp-content/uploads/2024/07/mavuika-hands-outstretched-genshin-impact.jpg?w=1024');" data-text="Voucher Mobile Legends"></div>
        </div>

        <div id="joki-products" class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5 hidden">
            <div class="hover-effect" style="background-image: url('https://cdn.vcgamers.com/news/wp-content/uploads/2022/11/aldous-Wallpaper-Mobile-Legends-HD.-Sumber-uhdpaper.com_.jpg');" data-text="Joki Mobile Legends"></div>
        </div>

        <div id="tagihan-products" class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5 hidden">
            <div class="hover-effect" style="background-image: url('https://cdn.vcgamers.com/news/wp-content/uploads/2022/11/aldous-Wallpaper-Mobile-Legends-HD.-Sumber-uhdpaper.com_.jpg');" data-text="Tagihan Mobile Legends"></div>
        </div>
    </div>

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
        if (!slides.length) return;
        const slidesContainer = document.getElementById('carousel-slides');
        slidesContainer.style.transform = `translateX(-${index * 100}%)`;
        
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('bg-white', i === index);
            indicator.classList.toggle('bg-gray-500', i !== index);
        });
    }

    function nextSlide() {
        if (!slides.length) return;
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function prevSlide() {
        if (!slides.length) return;
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
    showSlide(0); // Initialize first slide and indicators


    // JavaScript untuk Menampilkan Produk Berdasarkan Kategori & efek active
    const kategoriButtons = document.querySelectorAll('.kategori-btn');
    const topupProducts = document.getElementById('topup-products');
    const voucherProducts = document.getElementById('voucher-products');
    const jokiProducts = document.getElementById('joki-products');
    const tagihanProducts = document.getElementById('tagihan-products');
    const loadMoreContainer = document.querySelector('#loadMore')?.parentElement;

    function hideAllProducts() {
        if(topupProducts) topupProducts.classList.add('hidden');
        if(voucherProducts) voucherProducts.classList.add('hidden');
        if(jokiProducts) jokiProducts.classList.add('hidden');
        if(tagihanProducts) tagihanProducts.classList.add('hidden');
        
        if(loadMoreContainer) {
            loadMoreContainer.classList.add('hidden');
        }
    }

    if (topupProducts) {
        hideAllProducts();
        topupProducts.classList.remove('hidden');
        if(loadMoreContainer) {
            loadMoreContainer.classList.remove('hidden');
        }
    }


    kategoriButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            kategoriButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            hideAllProducts();

            if(this.id === 'topup' && topupProducts) {
                topupProducts.classList.remove('hidden');
                 if(loadMoreContainer) {
                    loadMoreContainer.classList.remove('hidden');
                }
            }
            if(this.id === 'voucher' && voucherProducts) voucherProducts.classList.remove('hidden');
            if(this.id === 'joki' && jokiProducts) jokiProducts.classList.remove('hidden');
            if(this.id === 'tagihan' && tagihanProducts) tagihanProducts.classList.remove('hidden');
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
        let games = document.querySelectorAll(".game-item");
        let loadMoreBtn = document.getElementById("loadMore");
        
        if (!loadMoreBtn) return;

        let visibleCount = 12;
        let increment = 12;

        for (let i = visibleCount; i < games.length; i++) {
            if(games[i]) {
                games[i].parentElement.style.display = 'none';
            }
        }

        if (games.length <= visibleCount) {
             loadMoreBtn.style.display = "none";
        }

        loadMoreBtn.addEventListener("click", function() {
            let newlyVisibleCount = 0;
            for (let i = visibleCount; i < games.length && newlyVisibleCount < increment; i++) {
                if(games[i]) {
                    games[i].parentElement.style.display = 'block';
                    newlyVisibleCount++;
                }
            }
            visibleCount += newlyVisibleCount;

            if (visibleCount >= games.length) {
                loadMoreBtn.style.display = "none";
            }
        });
    });
</script>
</body>
</html>