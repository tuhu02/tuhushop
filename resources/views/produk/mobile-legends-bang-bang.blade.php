<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        .brand-gradient {
            background: linear-gradient(45deg, #00b4d8, #90e0ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 180, 216, 0.1);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 180, 216, 0.2);
        }
    </style>
</head>
<body class="font-sans">
  <x-navbar :links="[ 
        ['url' => '/home', 'label' => 'Home'], 
        ['url' => '/about', 'label' => 'About'], 
        ['url' => '/services', 'label' => 'Services'], 
        ['url' => '/contact', 'label' => 'Contact'], 
    ]" />

    <!-- Hero Section -->
    <div class="container mx-auto py-12 px-4 mt-16">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Game Info Section -->
            <div class="lg:w-1/3 bg-gray-800 rounded-xl p-6 shadow-xl">
                <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                    <img src="https://news.codashop.com/id/wp-content/uploads/sites/4/2023/05/Mobile-Legends-Best-Settings.jpg" alt="Mobile Legends" class="object-cover">
                </div>
                <h2 class="text-2xl font-bold text-white mt-4 mb-2">Mobile Legends Top Up</h2>
                <p class="text-gray-300 text-sm mb-4">
                    Top up Diamond MLBB dengan cepat dan aman di TuhuTopUp. Proses instan dengan berbagai metode pembayaran modern.
                </p>
                
                <!-- Fitur Unggulan -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-cyan-400 rounded-full"></div>
                        <span class="text-gray-300 text-sm">Garansi 100% aman</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-cyan-400 rounded-full"></div>
                        <span class="text-gray-300 text-sm">Proses instan & otomatis</span>
                    </div>
                </div>

                <!-- Download Buttons Custom -->
                <div class="flex flex-col space-y-3">
                    <a href="#" class="bg-gray-700 hover:bg-gray-600 rounded-lg p-3 flex items-center transition-colors">
                        <img src="https://your-own-icon-set/app-store.png" class="w-6 h-6 mr-2">
                        <span class="text-white text-sm">Download on iOS</span>
                    </a>
                    <a href="#" class="bg-gray-700 hover:bg-gray-600 rounded-lg p-3 flex items-center transition-colors">
                        <img src="https://your-own-icon-set/play-store.png" class="w-6 h-6 mr-2">
                        <span class="text-white text-sm">Get on Google Play</span>
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="lg:w-2/3 space-y-6">
                <!-- Step 1 Custom -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center mr-3">1</div>
                        <h3 class="text-xl font-semibold text-white">Masukan ID Player</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" 
                               class="bg-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
                               placeholder="User ID">
                        <input type="text" 
                               class="bg-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
                               placeholder="Server ID">
                    </div>
                    <p class="text-gray-400 text-xs mt-3">
                        💡 Cari ID Anda di menu profile game. Contoh: 12345678(1234)
                    </p>
                </div>

                <!-- Step 2 Custom -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center mr-3">2</div>
                        <h3 class="text-xl font-semibold text-white">Pilih Produk</h3>
                    </div>
                    
                    <!-- Diamond Category -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-cyan-400 mb-4">Diamond</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <!-- Diamond Products -->
                            @foreach($diamond as $item)
                                <div class="card-hover bg-gray-700 rounded-lg p-4 cursor-pointer border-2 border-transparent hover:border-cyan-400">
                                    <div class="aspect-square mb-3">
                                        <img src="{{ $item->thumbnail }}" 
                                            class="w-full h-full object-contain"
                                            alt="{{ $item->product_name }}">
                                    </div>
                                    <h4 class="text-center text-white font-semibold mb-1">{{ $item->item_name }}</h4>
                                    <p class="text-center text-cyan-400 text-sm font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                            <!-- Add more diamond products as needed -->
                        </div>
                    </div>

                    <!-- Weekly Pass Category -->
                    <div>
                        <h4 class="text-lg font-semibold text-cyan-400 mb-4">Weekly Pass</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <!-- Weekly Pass Products -->
                             @foreach($nonDiamond as $item2)
                            <div class="card-hover bg-gray-700 rounded-lg p-4 cursor-pointer border-2 border-transparent hover:border-cyan-400">
                                <div class="aspect-square mb-3">
                                    <img src="{{$item2->thumbnail}}" 
                                        class="w-full h-full object-contain">
                                </div>
                                <h4 class="text-center text-white font-semibold mb-1">{{$item2->item_name}}</h4>
                                <p class="text-center text-cyan-400 text-sm font-medium">Rp {{ number_format($item2->price, 0, ',', '.') }}</p>
                            </div>
                            @endforeach
                            <!-- Add more weekly pass products as needed -->
                        </div>
                    </div>
                </div>

                <!-- Step 3 Custom -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center mr-3">3</div>
                        <h3 class="text-xl font-semibold text-white">Metode Pembayaran</h3>
                    </div>
                    
                    <!-- Payment Methods Grid -->
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                        <div class="payment-method bg-gray-700 rounded-lg p-3 flex items-center justify-center cursor-pointer hover:bg-gray-600">
                            <img src="https://cdn1.codashop.com/S/content/common/images/mno/DANA_ID_CHNL_LOGO.webp" class="h-8">
                        </div>

                        <div class="payment-method bg-gray-700 rounded-lg p-3 flex items-center justify-center cursor-pointer hover:bg-gray-600">
                            <img src="https://cdn1.codashop.com/S/content/common/images/mno/QRIS_ID_CHNL_LOGO.webp" class="h-8">
                        </div>
                        <!-- Tambahkan metode lainnya -->
                    </div>
                </div>

                <!-- Step 3 Custom -->
                <div class="bg-gray-800 rounded-xl p-6 shadow-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 bg-cyan-500 rounded-full flex items-center justify-center mr-3">4</div>
                        <h3 class="text-xl font-semibold text-white">Beli Sekarang!</h3>
                    </div>

                    <p class="text-white mb-3">Masukkan alamat email untuk mendapatkan Coda Rewards sampai dengan 2% pada pembelian kamu. Kamu juga akan mendapatkan bukti pembayaran dan berhak untuk mendapatkan promosi.</p>
                    <input type="email" class="w-full rounded-lg p-2 bg-gray-700 focus:ring-2 focus:ring-cyan-400 focus:outline-none" placeholder="Masukan emailmu disini!...">
                    <button class="w-full bg-cyan-500 mt-2 rounded-md p-2 font-semibold">
                        <i class="fas fa-shopping-basket mr-2"></i>Beli Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Custom -->
    <footer class="relative bg-gray-800 pt-8">
  <div class="container mx-auto px-4 pt-2 text-white">
    <div class="flex flex-wrap text-left lg:text-left">
      <div class="w-full lg:w-6/12 px-4">
        <h4 class="text-3xl fonat-semibold text-blueGray-700 font-bold">TUHU SHOP</h4>
        <h5 class="text-lg mt-0 mb-2 text-blueGray-600">
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
                <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm" href="https://www.creative-tim.com/presentation?ref=njs-profile">About Us</a>
              </li>
              <li>
                <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm" href="https://blog.creative-tim.com?ref=njs-profile">Blog</a>
              </li>
              <li>
                <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm" href="https://www.github.com/creativetimofficial?ref=njs-profile">Github</a>
              </li>
              <li>
                <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm" href="https://www.creative-tim.com/bootstrap-themes/free?ref=njs-profile">Free Products</a>
              </li>
            </ul>
          </div>
          <div class="w-full lg:w-4/12 px-4">
            <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Other Resources</span>
            <ul class="list-unstyled">
              <li>
                <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm" href="https://github.com/creativetimofficial/notus-js/blob/main/LICENSE.md?ref=njs-profile">MIT License</a>
              </li>
              <li>
                <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm" href="https://creative-tim.com/terms?ref=njs-profile">Terms &amp; Conditions</a>
              </li>
              <li>
                <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm" href="https://creative-tim.com/privacy?ref=njs-profile">Privacy Policy</a>
              </li>
              <li>
                <a class="text-blueGray-600 hover:text-blueGray-800 font-semibold block pb-2 text-sm" href="https://creative-tim.com/contact-us?ref=njs-profile">Contact Us</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <hr class="my-6 border-cyan-500">
    <div class="flex flex-wrap items-center md:justify-between justify-center">
      <div class="w-full md:w-4/12 px-4 mx-auto text-center">
        <div class="text-sm text-blueGray-500 font-semibold py-1 mb-6">
          Copyright © <span id="get-current-year">2024</span><a href="https://www.creative-tim.com/product/notus-js" class="text-blueGray-500 hover:text-gray-800 " target="_blank"> Tuhu Shop
          <a href="https://www.creative-tim.com?ref=njs-profile" class="text-blueGray-500 hover:text-blueGray-800">|| Tuhu Pangestu</a>
        </div>
      </div>
    </div>
  </div>
</footer>
</body>
</html>