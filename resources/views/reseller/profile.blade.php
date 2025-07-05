<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil Reseller - Tuhu Topup</title>
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
                <a href="{{ route('reseller.dashboard') }}" class="text-aqua hover:text-white font-medium rounded-lg text-sm px-4 py-2 text-center transition duration-200">
                    Dashboard
                </a>
                <span class="text-white font-medium">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-aqua hover:text-white font-medium rounded-lg text-sm px-4 py-2 text-center transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-20 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Edit Profil Reseller</h1>
                <p class="text-gray-400">Perbarui informasi profil Anda</p>
            </div>

            @if(session('success'))
                <div class="bg-green-900 border border-green-700 text-green-200 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Form -->
            <div class="bg-gray-800 rounded-lg shadow-xl p-8">
                <form method="POST" action="{{ route('reseller.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Personal Information -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nama Lengkap
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    value="{{ Auth::user()->name }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    readonly
                                >
                                <p class="text-xs text-gray-400 mt-1">Nama tidak dapat diubah</p>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                                    Email
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    value="{{ Auth::user()->email }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    readonly
                                >
                                <p class="text-xs text-gray-400 mt-1">Email tidak dapat diubah</p>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                                    Nomor Telepon *
                                </label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone', $reseller->phone) }}"
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
                                    value="{{ old('company_name', $reseller->company_name) }}"
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
                                >{{ old('address', $reseller->address) }}</textarea>
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
                                        value="{{ old('city', $reseller->city) }}"
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
                                        value="{{ old('province', $reseller->province) }}"
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
                                        value="{{ old('postal_code', $reseller->postal_code) }}"
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
                                    value="{{ old('bank_name', $reseller->bank_name) }}"
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
                                    value="{{ old('bank_account_number', $reseller->bank_account_number) }}"
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
                                    value="{{ old('bank_account_name', $reseller->bank_account_name) }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                    placeholder="Nama pemilik rekening"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Reseller Info (Read Only) -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Informasi Reseller</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Kode Reseller
                                </label>
                                <input 
                                    type="text" 
                                    value="{{ $reseller->reseller_code }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white"
                                    readonly
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Kode Referral
                                </label>
                                <input 
                                    type="text" 
                                    value="{{ $reseller->referral_code }}"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white"
                                    readonly
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">
                                    Komisi
                                </label>
                                <input 
                                    type="text" 
                                    value="{{ $reseller->commission_rate }}%"
                                    class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-aqua font-medium"
                                    readonly
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('reseller.dashboard') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="bg-aqua hover:bg-opacity-80 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 