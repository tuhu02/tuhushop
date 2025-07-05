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
            border-color: #8b5cf6;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-[#23272f] min-h-screen">
    <x-navbar />
    <div class="container mx-auto mt-24 p-5">
        {{-- Banner Section dengan Logo Overlap --}}
        <div class="relative w-full mb-8">
            {{-- Banner dinamis --}}
            <img src="{{ $product->banner_url ? asset('image/' . $product->banner_url) : asset('image/banner-mlbb.jpg') }}" alt="Banner {{ $product->product_name }}"
                 class="w-full h-64 object-cover rounded-2xl shadow-md">
            {{-- Logo Produk, overlap --}}
            <div class="absolute left-8 -bottom-12 z-10">
                <img src="{{ $product->logo ? Storage::url($product->logo) : asset('image/' . $product->thumbnail_url) }}"
                     alt="{{ $product->product_name }}"
                     class="w-40 h-40 object-cover rounded-xl border-4 border-white shadow-lg bg-white">
            </div>
        </div>
        {{-- Box Info Produk --}}
        <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-8 mt-12 flex flex-col md:flex-row items-center md:items-start">
            <div class="md:ml-48 flex-1">
                <h1 class="text-3xl font-bold text-white mb-2">{{ $product->product_name }}</h1>
                <p class="text-gray-300 mb-4"><i class="fas fa-building mr-2"></i>{{ $product->developer }}</p>
                <div class="flex flex-wrap gap-6 text-sm">
                    <div class="flex items-center gap-2 text-yellow-400">
                        <i class="fas fa-bolt"></i> Proses Cepat
                    </div>
                    <div class="flex items-center gap-2 text-blue-400">
                        <i class="fas fa-comments"></i> Layanan Chat 24/7
                    </div>
                    <div class="flex items-center gap-2 text-purple-400">
                        <i class="fas fa-shield-alt"></i> Pembayaran Aman!
                    </div>
                </div>
            </div>
        </div>
        <!-- Denom Selection -->
        <div class="bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-white mb-6">Pilih Nominal</h2>
            <!-- Diamond Denoms -->
            @if($diamondDenoms->count() > 0)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-cyan-400 mb-4 flex items-center">
                    <i class="fas fa-gem text-blue-400 mr-2"></i>
                    Diamond
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($diamondDenoms as $denom)
                    <div class="denom-card bg-gray-900 border-2 border-gray-700 rounded-lg p-4 cursor-pointer hover:border-purple-400"
                         onclick="selectDenom({{ $denom->id }}, '{{ $denom->nama_denom ?: $denom->nama_produk }}', {{ $denom->harga_jual ?: $denom->harga }})">
                        <div class="text-center">
                            <h4 class="font-semibold text-white mb-2">{{ $denom->nama_denom ?: $denom->nama_produk }}</h4>
                            <p class="text-2xl font-bold text-purple-400">Rp{{ number_format($denom->harga_jual ?: $denom->harga, 0, ',', '.') }}</p>
                            @if($denom->harga_member && $denom->harga_member < ($denom->harga_jual ?: $denom->harga))
                                <p class="text-sm text-green-400 font-medium">Member: Rp{{ number_format($denom->harga_member, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- Non-Diamond Denoms -->
            @if($nonDiamondDenoms->count() > 0)
            <div>
                <h3 class="text-lg font-semibold text-cyan-400 mb-4 flex items-center">
                    <i class="fas fa-coins text-yellow-400 mr-2"></i>
                    Lainnya
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($nonDiamondDenoms as $denom)
                    <div class="denom-card bg-gray-900 border-2 border-gray-700 rounded-lg p-4 cursor-pointer hover:border-purple-400"
                         onclick="selectDenom({{ $denom->id }}, '{{ $denom->nama_denom ?: $denom->nama_produk }}', {{ $denom->harga_jual ?: $denom->harga }})">
                        <div class="text-center">
                            <h4 class="font-semibold text-white mb-2">{{ $denom->nama_denom ?: $denom->nama_produk }}</h4>
                            <p class="text-2xl font-bold text-purple-400">Rp{{ number_format($denom->harga_jual ?: $denom->harga, 0, ',', '.') }}</p>
                            @if($denom->harga_member && $denom->harga_member < ($denom->harga_jual ?: $denom->harga))
                                <p class="text-sm text-green-400 font-medium">Member: Rp{{ number_format($denom->harga_member, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @if($diamondDenoms->count() == 0 && $nonDiamondDenoms->count() == 0)
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-coins text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-white mb-2">Belum ada denom tersedia</h3>
                <p class="text-gray-300">Produk ini sedang dalam maintenance</p>
            </div>
            @endif
        </div>
    </div>
    <!-- Footer -->
    <footer class="relative bg-blueGray-200 pt-8 mt-10">
        <div class="mx-auto px-4 pt-2 text-white" style="background-color: #393E46;">
            <div class="flex flex-wrap text-left lg:text-left">
                <div class="w-full lg:w-6/12 px-4">
                    <h4 class="text-2xl fonat-semibold text-blueGray-700 font-bold">TUHU SHOP</h4>
                    <h5 class="text-sm mt-0 mb-2 text-blueGray-600">
                        Platform terpercaya untuk pembelian game voucher dan top up dengan harga terbaik.
                    </h5>
                </div>
                <div class="w-full lg:w-6/12 px-4">
                    <div class="flex flex-wrap items-top mb-6">
                        <div class="w-full lg:w-4/12 px-4 ml-auto">
                            <span class="block uppercase text-blueGray-500 text-sm font-semibold mb-2">Useful Links</span>
                            <ul class="list-unstyled">
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800 block pb-2 text-sm" href="#">Home</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800  block pb-2 text-sm" href="#">Topup</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800 block pb-2 text-sm" href="#">Cek Transaksi</a>
                                </li>
                                <li>
                                    <a class="text-blueGray-600 hover:text-blueGray-800  block pb-2 text-sm" href="#">Kontak</a>
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
                        Copyright © <span id="get-current-year">2024</span> Tuhu Shop
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script>
        function selectDenom(denomId, denomName, price) {
            // Remove previous selection
            document.querySelectorAll('.denom-card').forEach(card => {
                card.classList.remove('selected');
            });
            // Add selection to clicked card
            event.currentTarget.classList.add('selected');
            // Update form
            document.getElementById('denom_id').value = denomId;
            document.getElementById('selected-denom-name').textContent = denomName;
            document.getElementById('selected-denom-price').textContent = 'Rp' + price.toLocaleString('id-ID');
            
            // Show checkout form
            document.getElementById('checkout-form').classList.remove('hidden');
            
            // Scroll to checkout form
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