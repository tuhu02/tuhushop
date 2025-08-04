<aside class="bg-white shadow-lg border-r border-gray-200 w-64 h-screen fixed top-0 left-0 flex flex-col z-50">
    <!-- Logo Section -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-teal-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-gamepad text-white text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Tuhu Produk</h1>
                <p class="text-xs text-gray-500">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Admin Profile -->
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <img src="https://ui-avatars.com/api/?name=Admin+Tuhu&background=0D9488&color=fff&size=40" 
                 alt="Admin Avatar" 
                 class="w-10 h-10 rounded-full">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">Admin Tuhu</p>
                <p class="text-xs text-gray-500">Super Admin</p>
            </div>
            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
            <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
            Dashboard
        </a>

        <!-- Products Management -->
        <div class="space-y-1">
            <button class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors" 
                    onclick="toggleSubmenu('products')">
                <div class="flex items-center">
                    <i class="fas fa-box w-5 h-5 mr-3"></i>
                    Produk
                </div>
                <i class="fas fa-chevron-down w-4 h-4 transition-transform" id="products-icon"></i>
            </button>
            <div id="products-submenu" class="hidden pl-8 space-y-1">
                <a href="{{ route('admin.produk.create') }}" 
                   class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('admin.produk.create') ? 'bg-teal-50 text-teal-700' : '' }}">
                    <i class="fas fa-plus w-4 h-4 mr-2"></i>
                    Tambah Produk
                </a>
                <a href="{{ route('admin.produk.index') }}" 
                   class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('admin.produk.index') ? 'bg-teal-50 text-teal-700' : '' }}">
                    <i class="fas fa-edit w-4 h-4 mr-2"></i>
                    Kelola Produk
                </a>
                <a href="{{ route('admin.kategori-produk.index') }}" 
                   class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('admin.kategori-produk.*') ? 'bg-teal-50 text-teal-700' : '' }}">
                    <i class="fas fa-tags w-4 h-4 mr-2"></i>
                    Kelola Kategori
                </a>
                <a href="{{ route('admin.kategori-denom.index') }}" 
                   class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors {{ request()->routeIs('admin.kategori-denom.*') ? 'bg-teal-50 text-teal-700' : '' }}">
                    <i class="fas fa-layer-group w-4 h-4 mr-2"></i>
                    Kelola Kategori Denom
                </a>
            </div>
        </div>

        <!-- Transactions -->
        <a href="{{ route('admin.transactions') }}" 
           class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors {{ request()->routeIs('admin.transactions') ? 'bg-teal-50 text-teal-700 border border-teal-200' : '' }}">
            <i class="fas fa-shopping-cart w-5 h-5 mr-3"></i>
            Transaksi
            <span class="ml-auto bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">New</span>
        </a>

        <!-- Reseller Management -->
        <a href="{{ route('admin.resellers.index') }}" 
           class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors {{ request()->routeIs('admin.resellers.*') ? 'bg-teal-50 text-teal-700 border border-teal-200' : '' }}">
            <i class="fas fa-users w-5 h-5 mr-3"></i>
            Reseller
        </a>

        <!-- Withdrawals -->
        <a href="{{ route('admin.withdrawals.index') }}" 
           class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors {{ request()->routeIs('admin.withdrawals.*') ? 'bg-teal-50 text-teal-700 border border-teal-200' : '' }}">
            <i class="fas fa-money-bill-wave w-5 h-5 mr-3"></i>
            Withdrawal
        </a>

        <!-- Digiflazz API -->
        <a href="{{ route('admin.digiflazz.index') }}" 
           class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors {{ request()->routeIs('admin.digiflazz.*') ? 'bg-teal-50 text-teal-700 border border-teal-200' : '' }}">
            <i class="fas fa-cog w-5 h-5 mr-3"></i>
            Digiflazz API
        </a>

        <!-- Statistics -->
        <a href="/admin/statistics" 
           class="flex items-center px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors">
            <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
            Statistik
        </a>

        <!-- Settings -->
        <div class="space-y-1">
            <button class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition-colors" 
                    onclick="toggleSubmenu('settings')">
                <div class="flex items-center">
                    <i class="fas fa-cogs w-5 h-5 mr-3"></i>
                    Pengaturan
                </div>
                <i class="fas fa-chevron-down w-4 h-4 transition-transform" id="settings-icon"></i>
            </button>
            <div id="settings-submenu" class="hidden pl-8 space-y-1">
                <a href="/admin/settings/general" 
                   class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-sliders-h w-4 h-4 mr-2"></i>
                    Umum
                </a>
                <a href="/admin/settings/security" 
                   class="block px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="fas fa-shield-alt w-4 h-4 mr-2"></i>
                    Keamanan
                </a>
            </div>
        </div>
    </nav>

    <!-- Bottom Section -->
    <div class="p-4 border-t border-gray-200">
        <div class="space-y-2">
            <!-- System Status -->
            <div class="flex items-center justify-between px-3 py-2 bg-green-50 rounded-lg">
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                    <span class="text-xs font-medium text-green-800">System Online</span>
                </div>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
function toggleSubmenu(menuId) {
    const submenu = document.getElementById(menuId + '-submenu');
    const icon = document.getElementById(menuId + '-icon');
    
    if (submenu.classList.contains('hidden')) {
        submenu.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        submenu.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Auto-expand submenu if current page is in that section
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    
    if (currentPath.includes('/admin/produk') || currentPath.includes('/admin/kategori') || 
        currentPath.includes('/admin/tambahProduk') || currentPath.includes('/admin/kelolaProduk') || 
        currentPath.includes('/admin/kategoriProduk')) {
        toggleSubmenu('products');
    }
    
    if (currentPath.includes('/admin/settings')) {
        toggleSubmenu('settings');
    }
});
</script>
