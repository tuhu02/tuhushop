<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reseller - Tuhu Topup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'aqua': '#00D4FF',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-gray-900 fixed w-full z-20 h-fit top-0 left-0">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('dashboard')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{asset('image/logo-baru.png')}}" class="w-28" alt="Logo">
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <a href="{{ route('register') }}" class="text-aqua hover:text-white font-medium rounded-lg text-sm px-4 py-2 text-center transition duration-200">
                    Daftar User
                </a>
                <a href="{{ route('reseller.register') }}" class="text-white bg-aqua hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-aqua font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Daftar Reseller
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex min-h-screen items-center justify-center px-4 pt-20">
        <div class="w-full max-w-4xl">
            <!-- Registration Card -->
            <div class="bg-gray-800 rounded-lg shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Daftar Reseller</h2>
                    <p class="text-gray-400">Bergabung sebagai reseller dan dapatkan komisi dari setiap transaksi</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('reseller.register') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nama Lengkap *
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Masukkan nama lengkap"
                                    required
                                >
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                                    Email *
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Masukkan email"
                                    required
                                >
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nomor Telepon *
                                </label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Contoh: 081234567890"
                                    required
                                >
                            </div>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nama Perusahaan (Opsional)
                                </label>
                                <input 
                                    type="text" 
                                    id="company_name" 
                                    name="company_name" 
                                    value="{{ old('company_name') }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Nama perusahaan atau toko"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Informasi Alamat</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-300 mb-2">
                                    Alamat Lengkap *
                                </label>
                                <textarea 
                                    id="address" 
                                    name="address" 
                                    rows="3"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Masukkan alamat lengkap"
                                    required
                                >{{ old('address') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-300 mb-2">
                                        Kota *
                                    </label>
                                    <input 
                                        type="text" 
                                        id="city" 
                                        name="city" 
                                        value="{{ old('city') }}"
                                        class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                        placeholder="Nama kota"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="province" class="block text-sm font-medium text-gray-300 mb-2">
                                        Provinsi *
                                    </label>
                                    <input 
                                        type="text" 
                                        id="province" 
                                        name="province" 
                                        value="{{ old('province') }}"
                                        class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                        placeholder="Nama provinsi"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-300 mb-2">
                                        Kode Pos *
                                    </label>
                                    <input 
                                        type="text" 
                                        id="postal_code" 
                                        name="postal_code" 
                                        value="{{ old('postal_code') }}"
                                        class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                        placeholder="Kode pos"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Information -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Informasi Bank</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nama Bank *
                                </label>
                                <input 
                                    type="text" 
                                    id="bank_name" 
                                    name="bank_name" 
                                    value="{{ old('bank_name') }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Contoh: BCA, Mandiri, BNI"
                                    required
                                >
                            </div>

                            <div>
                                <label for="bank_account_number" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nomor Rekening *
                                </label>
                                <input 
                                    type="text" 
                                    id="bank_account_number" 
                                    name="bank_account_number" 
                                    value="{{ old('bank_account_number') }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Nomor rekening"
                                    required
                                >
                            </div>

                            <div>
                                <label for="bank_account_name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nama Pemilik Rekening *
                                </label>
                                <input 
                                    type="text" 
                                    id="bank_account_name" 
                                    name="bank_account_name" 
                                    value="{{ old('bank_account_name') }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Nama pemilik rekening"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Referral Code -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Kode Referral (Opsional)</h3>
                        <div>
                            <label for="referral_code" class="block text-sm font-medium text-gray-300 mb-2">
                                Kode Referral
                            </label>
                            <input 
                                type="text" 
                                id="referral_code" 
                                name="referral_code" 
                                value="{{ old('referral_code') }}"
                                class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                placeholder="Masukkan kode referral jika ada"
                            >
                            <p class="text-sm text-gray-400 mt-2">Jika Anda direferensikan oleh reseller lain, masukkan kode referral mereka</p>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Password</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                                    Password *
                                </label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Minimal 8 karakter"
                                    required
                                >
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                                    Konfirmasi Password *
                                </label>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Ulangi password"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Commission Info -->
                    <div class="bg-aqua bg-opacity-10 border border-aqua rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-aqua mb-4">💡 Informasi Komisi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                            <div class="bg-gray-700 rounded-lg p-4">
                                <div class="text-2xl font-bold text-aqua">5%</div>
                                <div class="text-sm text-gray-300">Bronze Tier</div>
                                <div class="text-xs text-gray-400">0 - 1M</div>
                            </div>
                            <div class="bg-gray-700 rounded-lg p-4">
                                <div class="text-2xl font-bold text-aqua">7%</div>
                                <div class="text-sm text-gray-300">Silver Tier</div>
                                <div class="text-xs text-gray-400">1M - 5M</div>
                            </div>
                            <div class="bg-gray-700 rounded-lg p-4">
                                <div class="text-2xl font-bold text-aqua">10%</div>
                                <div class="text-sm text-gray-300">Gold Tier</div>
                                <div class="text-xs text-gray-400">5M - 10M</div>
                            </div>
                            <div class="bg-gray-700 rounded-lg p-4">
                                <div class="text-2xl font-bold text-aqua">12%</div>
                                <div class="text-sm text-gray-300">Platinum Tier</div>
                                <div class="text-xs text-gray-400">10M+</div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-aqua hover:bg-opacity-80 text-white font-semibold py-4 px-6 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-aqua focus:ring-offset-2 focus:ring-offset-gray-800 text-lg"
                    >
                        Daftar Sebagai Reseller
                    </button>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-400">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-aqua hover:text-opacity-80 font-medium transition duration-200">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition duration-200">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html> 