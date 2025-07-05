<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Withdrawal - Tuhu Topup</title>
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
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Ajukan Withdrawal</h1>
                <p class="text-gray-400">Tarik dana dari saldo reseller Anda</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Balance Info -->
            <div class="bg-aqua bg-opacity-10 border border-aqua rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-aqua font-medium">Saldo Tersedia</p>
                        <p class="text-2xl font-bold text-white">Rp {{ number_format($reseller->balance) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400 text-sm">Minimal Withdrawal</p>
                        <p class="text-white font-medium">Rp 50.000</p>
                    </div>
                </div>
            </div>

            <!-- Withdrawal Form -->
            <div class="bg-gray-800 rounded-lg shadow-xl p-8">
                <form method="POST" action="{{ route('reseller.withdrawal.submit') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">
                            Jumlah Withdrawal *
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">Rp</span>
                            <input 
                                type="number" 
                                id="amount" 
                                name="amount" 
                                value="{{ old('amount') }}"
                                min="50000"
                                max="{{ $reseller->balance }}"
                                step="1000"
                                class="w-full pl-12 pr-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                                placeholder="Masukkan jumlah withdrawal"
                                required
                            >
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Minimal Rp 50.000, maksimal sesuai saldo</p>
                    </div>

                    <!-- Bank Information -->
                    <div class="bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Informasi Bank</h3>
                        <div class="space-y-4">
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

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">
                            Catatan (Opsional)
                        </label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            rows="3"
                            class="w-full px-4 py-3 bg-gray-600 border border-gray-500 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                            placeholder="Tambahkan catatan jika diperlukan"
                        >{{ old('notes') }}</textarea>
                    </div>

                    <!-- Terms -->
                    <div class="bg-yellow-900 bg-opacity-20 border border-yellow-700 rounded-lg p-4">
                        <h4 class="text-yellow-400 font-medium mb-2">Ketentuan Withdrawal:</h4>
                        <ul class="text-yellow-200 text-sm space-y-1">
                            <li>• Minimal withdrawal Rp 50.000</li>
                            <li>• Maksimal 1 withdrawal pending dalam satu waktu</li>
                            <li>• Proses withdrawal 1-3 hari kerja</li>
                            <li>• Pastikan informasi bank sudah benar</li>
                            <li>• Withdrawal akan diproses pada jam kerja</li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('reseller.dashboard') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="bg-aqua hover:bg-opacity-80 text-white font-semibold py-3 px-6 rounded-lg transition duration-200"
                            onclick="return confirm('Apakah Anda yakin ingin mengajukan withdrawal ini?')"
                        >
                            Ajukan Withdrawal
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent Withdrawals -->
            <div class="mt-8 bg-gray-800 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Withdrawal Terbaru</h3>
                @php
                    $recentWithdrawals = $reseller->withdrawals()->latest()->take(5)->get();
                @endphp
                
                @if($recentWithdrawals->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentWithdrawals as $withdrawal)
                        <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white font-medium">{{ $withdrawal->bank_name }}</p>
                                    <p class="text-gray-400 text-sm">{{ $withdrawal->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-white font-medium">Rp {{ number_format($withdrawal->amount) }}</p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $withdrawal->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($withdrawal->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('reseller.withdrawals') }}" class="text-aqua hover:text-opacity-80 text-sm">
                            Lihat Semua Withdrawal →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <p class="text-gray-400">Belum ada withdrawal</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html> 