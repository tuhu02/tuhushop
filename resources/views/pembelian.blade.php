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
            background-color: #222831;
        }
    </style>
</head>
<body>
    <x-navbar :links="[ 
        ['url' => '/home', 'label' => 'Home'], 
        ['url' => '/about', 'label' => 'About'], 
        ['url' => '/services', 'label' => 'Services'], 
        ['url' => '/contact', 'label' => 'Contact'], 
    ]" />
    
    <div class="container mx-auto mt-12 p-5 flex w-full">
        <!-- Konten Samping -->
        <div style="width: 30%;" class="p-5">
            <img src="https://cdn1.codashop.com/S/content/common/images/mno/EN_Weekly-Diamond-Pass_ProductPage.jpg" alt="TEST" class="w-full h-36">
            <h1 class="font-bold py-3 text-white">MOBILE LEGENDS: Bang Bang</h1>
            <p class="text-sm text-white">
                <b>Tuhu Shop</b> mempermudah pengisian Diamond Mobile Legends dengan cepat, aman, dan praktis.
            </p>
            <br>
            <p class="text-sm text-white">
                Beragam metode pembayaran tersedia, termasuk pulsa (Telkomsel, Indosat, Tri, XL, Smartfren), TuhuCash, QRIS, GoPay, OVO, DANA, ShopeePay, LinkAja, Krevido, Alfamart, Indomaret, DOKU, transfer bank, dan kartu kredit.
            </p>
            <br>
            <p class="text-sm text-white">
                Isi ulang Diamond Mobile Legends, Twilight Pass, Weekly Diamond Pass (WDP), atau Starlight hanya dalam beberapa langkah. Masukkan User ID dan Zone ID MLBB Anda, pilih jumlah Diamond yang diinginkan, selesaikan pembayaran, dan Diamond akan langsung masuk ke akun Mobile Legends Anda.
            </p>
            <br>
            <h1 class="pt-3 font-bold text-sm text-white">Unduh Mobile Legends: Bang Bang sekarang!</h1>
            <div class="flex gap-4">
                <!-- Tombol App Store -->
                <a href="https://www.apple.com/app-store/" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/203px-Download_on_the_App_Store_Badge.svg.png" 
                        alt="Download on the App Store" class="w-20 h-7 mt-2">
                </a>
                <!-- Tombol Google Play -->
                <a href="https://play.google.com/store/apps/details?id=com.mobile.legends" target="_blank">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/270px-Google_Play_Store_badge_EN.svg.png" 
                        alt="Get it on Google Play" class="w-24 h-7 mt-2">
                </a>
            </div>

        </div>

        <!-- Form -->
        <div style="width: 70%;" class="p-5">
            <!-- Pengisian Form -->
            <div class="w-full rounded-md p-2 mt-2 text-white flex">
              <!-- Bagian nomor -->
              <h1 class="font-bold bg-white text-black rounded-l-md p-2 flex-shrink-0">
                1.
              </h1>
              <!-- Bagian deskripsi -->
              <h1 class="font-bold bg-aqua rounded-r-md flex-grow p-2">
                Masukan User Id
              </h1>
            </div>
            <div class="w-full rounded-md p-2">
                  <div class="d-flex gap-3">
                  <input type="text" 
                        class="rounded-md p-2 border border-gray-400 text-center bg-gray-700 text-white" 
                        placeholder="Masukan user ID">
                  <input type="text" 
                        class="rounded-md p-2 border border-gray-400 text-center bg-gray-700 text-white" 
                        placeholder="( Masukan Server )">
                        <i class="fa fa-question-circle text-aqua" style="font-size:24px"></i>
              </div>
                <p class="italic text-xs text-gray-400 mt-2">
                    Untuk mengetahui User ID Anda, silakan klik menu profile di bagian kiri atas pada menu utama game. User ID akan terlihat di bagian bawah Nama Karakter Game Anda. Contoh : 12345678(1234).
                </p>
            </div>

            <!-- Pemilihan Nominal -->
            <div class="w-full rounded-md p-2 mt-2 text-white flex">
              <!-- Bagian nomor -->
              <h1 class="font-bold bg-white text-black rounded-l-md p-2 flex-shrink-0">
                2.
              </h1>
              <!-- Bagian deskripsi -->
              <h1 class="font-bold bg-aqua rounded-r-md flex-grow p-2">
                Pilih Nominal Top Up
              </h1>
            </div>
            <div class="w-full rounded-md p-2 mt-2">
                <h1 class="font-semibold py-3 text-white">Pilih Kategori</h1>
                <div class="flex gap-4 mb-3">
            <!-- Card Diamond -->
                <div class="bg-charcoal border border-gray-400 text-white rounded-md p-5 w-24 flex flex-col items-center h-40 hover:border-aqua">
                    <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/100x100/5000orMore_MLBB_Diamonds.png" alt="Diamond" class="h-16">
                    <h1 class="text-center font-semibold py-2 text-sm">Diamond</h1>
                </div>
                <!-- Card Weekly Diamond Pass -->
                <div class="bg-charcoal border border-gray-400 text-white rounded-md p-5 w-24 flex flex-col items-center h-40 hover:border-aqua">
                    <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/MLBB-Diamond-Pass_Popular-tag%20(2).png" alt="Weekly Diamond Pass" class="h-16">
                    <h1 class="text-center font-semibold py-2 text-sm">Weekly Diamond Pass</h1>
                </div>
            </div>

                <div class="grid grid-cols-5 gap-2 mt-2">
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white hover:boder-aqua">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                  <div class="h-fit rounded-md border py-3 border-gray-400 text-center flex flex-col items-center bg-charcoal text-white">
                      <h1 class="font-semibold mb-2">3 Diamonds</h1>
                      <img src="https://cdn1.codashop.com/S/content/common/images/denom-image/MLBB/150x150/10_MLBB_NewDemom.png" alt="3 Diamonds" class="h-20 w-20">
                      <h1 class="font-semibold">Rp. 10.000</h1>
                  </div>
                </div>
            </div>

            <!-- Pemilihan Pembayaran -->
            <div class="w-full rounded-md p-2 mt-2 text-white flex">
              <!-- Bagian nomor -->
              <h1 class="font-bold bg-white text-black rounded-l-md p-2 flex-shrink-0">
                3.
              </h1>
              <!-- Bagian deskripsi -->
              <h1 class="font-bold bg-aqua rounded-r-md flex-grow p-2">
                Pilih metode Pembayaran
              </h1>
            </div>
            <div class="w-full rounded-md mt-2 p-2">
                
                <div class="grid grid-cols-5 gap-2 mt-2">
                    <div class="h-fit rounded-md border bg-payment border-gray-400 p-2">
                      <img src="https://cdn1.codashop.com/S/content/common/images/mno/GO_PAY_ID_CHNL_LOGO.webp" alt="" class="w-16">
                      <h1 class="pt-2 font-semibold text-sm">GoPay</h1>
                    </div>
                    <div class="h-fit rounded-md border bg-payment border-gray-400 p-2">
                      <img src="https://cdn1.codashop.com/S/content/common/images/mno/DANA_ID_CHNL_LOGO.webp" alt="" class="w-16">
                      <h1 class="pt-2 font-semibold text-sm">Dana</h1>
                    </div>
                    <div class="h-fit rounded-md border bg-payment border-gray-400 p-2">
                      <img src="https://cdn1.codashop.com/S/content/common/images/mno/QRIS_ID_CHNL_LOGO.webp" alt="" class="w-16">
                      <h1 class="pt-2 font-semibold text-sm">Qris</h1>
                    </div>
                    <div class="h-fit rounded-md border bg-payment border-gray-400 p-2">
                      <img src="https://cdn1.codashop.com/S/content/common/images/mno/OVO_ID_CHNL_LOGO.webp" alt="" class="w-16">
                      <h1 class="pt-2 font-semibold text-sm">OVO</h1>
                    </div>
                    <div class="h-fit rounded-md border bg-payment border-gray-400 p-2">
                      <img src="https://cdn1.codashop.com/S/content/common/images/mno/Indomaret_ID_CHNL_LOGO.webp" alt="" class="w-16">
                      <h1 class="pt-2 font-semibold text-sm">Indomaret</h1>
                    </div>
                    <div class="h-fit rounded-md border bg-payment border-gray-400 p-2">
                      <img src="https://cdn1.codashop.com/S/content/common/images/mno/DOKU_OTC_ID_CHNL_LOGO.webp" alt="" class="w-16">
                      <h1 class="pt-2 font-semibold text-sm">Alfamart</h1>
                    </div>
                </div>
            </div>

            <!-- Masukan Email -->
             <!-- Pemilihan Pembayaran -->
            <div class="w-full rounded-md p-2 mt-2 text-white flex">
              <!-- Bagian nomor -->
              <h1 class="font-bold bg-white text-black rounded-l-md p-2 flex-shrink-0">
                4.
              </h1>
              <!-- Bagian deskripsi -->
              <h1 class="font-bold bg-aqua rounded-r-md flex-grow p-2">
                Beli
              </h1>
            </div>
            <div class="w-full rounded-md mt-2 p-4 bg-payment">
                <p>
                    Masukkan alamat email untuk mendapatkan Coda Rewards sampai dengan 2% pada pembelian kamu. 
                    Kamu juga akan mendapatkan bukti pembayaran dan berhak untuk mendapatkan promosi.
                </p>
                <input type="text" class="rounded-md mt-2 p-2 w-full border border-aqua" placeholder="Masukkan email">
                <div class="flex justify-end mt-4">
                    <button class="bg-aqua text-white px-4 py-2 rounded-md">Beli Sekarang</button>
                </div>
            </div>      
        </div>
    </div>
    <footer class="relative bg-blueGray-200 pt-8">
  <div class="container mx-auto px-4 pt-2 text-white" style="background-color: #393E46;">
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
    <hr class="my-6 border-blueGray-300">
    <div class="flex flex-wrap items-center md:justify-between justify-center">
      <div class="w-full md:w-4/12 px-4 mx-auto text-center">
        <div class="text-sm text-blueGray-500 font-semibold py-1">
          Copyright © <span id="get-current-year">2024</span><a href="https://www.creative-tim.com/product/notus-js" class="text-blueGray-500 hover:text-gray-800" target="_blank"> Tuhu Shop
          <a href="https://www.creative-tim.com?ref=njs-profile" class="text-blueGray-500 hover:text-blueGray-800">|| Tuhu Pangestu</a>
        </div>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
