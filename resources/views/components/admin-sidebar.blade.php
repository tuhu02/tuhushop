<aside class="sidebar bg-teal-600 text-white w-64 h-screen fixed top-0 left-0 flex flex-col">
    <!-- Profile Section -->
    <div class="p-4 flex flex-col items-center">
        <img src="https://png.pngtree.com/png-clipart/20230409/original/pngtree-admin-and-customer-service-job-vacancies-png-image_9041264.png" alt="Admin Avatar" class="w-20 h-20 rounded-full border-4 border-blue-400 bg-red-600">
        <span class="mt-2 font-bold text-lg">Admin Tuhu</span>
    </div>

    <!-- Menu Section -->
    <ul class="mt-4">
        <li>
            <a href="/dashboard" class="flex items-center py-2 px-4 hover:bg-teal-700">
                <i class="fas fa-home mr-3"></i> Dashboard
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="flex items-center justify-between py-2 px-4 hover:bg-teal-700">
                <span><i class="fas fa-box mr-3"></i> Produk</span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </a>
            <ul class="sub-menu pl-8 mt-1 hidden">
                <li><a href="/produk/tambah" class="block py-1 px-4 hover:bg-teal-700">| Tambah Produk</a></li>
                <li><a href="/produk/edit" class="block py-1 px-4 hover:bg-teal-700">| Edit Produk</a></li>
            </ul>
        </li>
        <li>
            <a href="/transaksi" class="flex items-center py-2 px-4 hover:bg-teal-700">
                <i class="fas fa-shopping-cart mr-3"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="/statistik" class="flex items-center py-2 px-4 hover:bg-teal-700">
                <i class="fas fa-chart-bar mr-3"></i> Statistik
            </a>
        </li>
        <li>
            <a href="/statistik" class="flex items-center py-2 px-4 hover:bg-teal-700">
                <i class="fas fa-right-from-bracket mr-3"></i> Logout
            </a>
        </li>
    </ul>
</aside>
