<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <div class="container mx-auto mt-20 p-5">
    <div class="text-center">
        <h1 class="font-bold text-2xl text-white">Cek Invoice Kamu dengan Mudah dan Cepat.</h1>
        <p class="text-white">Lihat detail pembelian kamu menggunakan nomor Invoice.</p>
    </div>
    <div class="bg-gray-800 h-fit w-96 mx-auto mt-2 rounded-lg p-2 text-white p-5 border-2 border-transparent hover:border-cyan-400">
        <p class="font-semibold">Cari detail pembelian kamu disini</p>
        <input type="text" placeholder="Cari invoice kamu disini (Contoh : 08xxxxxxx)" class="w-full rounded-lg p-2 border-2 border-aqua mt-4 bg-gray-500 text-white placeholder-white "> 
        <button class="w-full bg-aqua rounded-md font-semibold mt-2 py-2">Cari Invoice</button>
    </div>

    <h1 class="font-bold text-center mt-20 text-xl text-white">Transaksi Real-Time</h1>
    <h1 class="text-center text-white">Berikut ini Real-time data pesanan masuk terbaru OURASTORE.</h1>
    <div class="overflow-hidden rounded-lg border border-gray-700 mt-2">
  <table class="min-w-full text-white">
    <thead>
      <tr class="bg-gray-900 text-left">
        <th class="px-4 py-3 border-b border-gray-700">Tanggal</th>
        <th class="px-4 py-3 border-b border-gray-700">Nomor Invoice</th>
        <th class="px-4 py-3 border-b border-gray-700">No. Handphone</th>
        <th class="px-4 py-3 border-b border-gray-700">Harga</th>
        <th class="px-4 py-3 border-b border-gray-700">Status</th>
      </tr>
    </thead>
    <tbody class="bg-gray-800">
      <tr class="border-b border-gray-700">
        <td class="px-4 py-3">04-02-2025 11:30:48</td>
        <td class="px-4 py-3">OS********266</td>
        <td class="px-4 py-3">628*******087</td>
        <td class="px-4 py-3">Rp 55.035</td>
        <td class="px-4 py-3"><span class="bg-yellow-500 text-black px-2 py-1 rounded text-sm">PENDING</span></td>
      </tr>
      <tr class="border-b border-gray-700">
        <td class="px-4 py-3">04-02-2025 11:29:43</td>
        <td class="px-4 py-3">OS********550</td>
        <td class="px-4 py-3">628*******708</td>
        <td class="px-4 py-3">Rp 81.092</td>
        <td class="px-4 py-3"><span class="bg-yellow-500 text-black px-2 py-1 rounded text-sm">PENDING</span></td>
      </tr>
      <tr class="border-b border-gray-700">
        <td class="px-4 py-3">04-02-2025 11:30:14</td>
        <td class="px-4 py-3">OS********994</td>
        <td class="px-4 py-3">628*******023</td>
        <td class="px-4 py-3">Rp 9.522</td>
        <td class="px-4 py-3"><span class="bg-blue-500 text-white px-2 py-1 rounded text-sm">PROCESS</span></td>
      </tr>
      <tr class="border-b border-gray-700">
        <td class="px-4 py-3">04-02-2025 11:30:41</td>
        <td class="px-4 py-3">OS********604</td>
        <td class="px-4 py-3">628*******097</td>
        <td class="px-4 py-3">Rp 88.917</td>
        <td class="px-4 py-3"><span class="bg-blue-500 text-white px-2 py-1 rounded text-sm">PROCESS</span></td>
      </tr>
      <tr class="border-b border-gray-700">
        <td class="px-4 py-3">04-02-2025 11:28:25</td>
        <td class="px-4 py-3">OS********169</td>
        <td class="px-4 py-3">628*******166</td>
        <td class="px-4 py-3">Rp 29.639</td>
        <td class="px-4 py-3"><span class="bg-yellow-500 text-black px-2 py-1 rounded text-sm">PENDING</span></td>
      </tr>
      <tr>
        <td class="px-4 py-3">04-02-2025 11:28:22</td>
        <td class="px-4 py-3">OS********509</td>
        <td class="px-4 py-3">628*******271</td>
        <td class="px-4 py-3">Rp 29.639</td>
        <td class="px-4 py-3"><span class="bg-yellow-500 text-black px-2 py-1 rounded text-sm">PENDING</span></td>
      </tr>
    </tbody>
  </table>
</div>

    </div>

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