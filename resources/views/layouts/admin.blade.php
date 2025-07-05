<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'aqua': '#00D4FF',
                        'adminbg': '#0e2e36',
                        'adminsidebar': '#1e4d56',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-adminbg min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-adminsidebar text-white flex flex-col py-8 px-4 min-h-screen">
        <div class="flex flex-col items-center mb-8">
            <img src="https://ui-avatars.com/api/?name=Admin&background=00D4FF&color=fff" class="w-20 h-20 rounded-full mb-2 border-4 border-aqua" alt="Admin Avatar">
            <div class="font-bold text-lg">Admin Tuhu</div>
        </div>
        <nav class="flex-1 space-y-2">
            <a href="{{ route('admin.resellers') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-aqua hover:text-adminsidebar transition @if(request()->routeIs('admin.resellers*')) bg-aqua text-adminsidebar @endif">
                <span>🏠</span> Dashboard
            </a>
            <a href="#" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-aqua hover:text-adminsidebar transition">
                <span>🛒</span> Produk
            </a>
            <a href="#" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-aqua hover:text-adminsidebar transition">
                <span>💳</span> Transaksi
            </a>
            <a href="{{ route('admin.resellers.list') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-aqua hover:text-adminsidebar transition @if(request()->routeIs('admin.resellers.list')) bg-aqua text-adminsidebar @endif">
                <span>👥</span> Reseller
            </a>
            <a href="#" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-aqua hover:text-adminsidebar transition">
                <span>📊</span> Statistik
            </a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="mt-8">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                <span>⏏️</span> Logout
            </button>
        </form>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 bg-adminbg min-h-screen p-8">
        <!-- Header -->
        <header class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">@yield('header', 'Admin Panel')</h1>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-white font-semibold">{{ Auth::user()->name ?? 'Admin' }}</span>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=00D4FF&color=fff" class="w-10 h-10 rounded-full border-2 border-aqua" alt="Avatar">
            </div>
        </header>
        @yield('content')
    </main>
</body>
</html> 