<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Tuhu Topup</title>
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
                <a href="{{ route('register') }}" class="text-white bg-aqua hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-aqua font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="text-aqua focus:ring-4 focus:outline-none focus:ring-aqua font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex min-h-screen items-center justify-center px-4 pt-20">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="bg-gray-800 rounded-lg shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Masuk</h2>
                    <p class="text-gray-400">Masuk ke akunmu untuk melanjutkan</p>
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

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                            placeholder="Masukkan email"
                            required
                        >
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            Password
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-aqua focus:border-transparent transition duration-200"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember" 
                                name="remember" 
                                type="checkbox" 
                                class="h-4 w-4 text-aqua focus:ring-aqua border-gray-600 rounded bg-gray-700"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-300">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-aqua hover:bg-opacity-80 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-aqua focus:ring-offset-2 focus:ring-offset-gray-800"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-gray-400">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-aqua hover:text-opacity-80 font-medium transition duration-200">
                            Daftar di sini
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