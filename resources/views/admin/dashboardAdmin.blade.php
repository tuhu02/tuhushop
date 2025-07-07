<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tuhu Game Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
    <x-admin-sidebar />
    <div class="ml-64">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        <p class="text-sm text-gray-600">Selamat datang kembali, Admin!</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="p-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        <div class="flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=0D9488&color=fff" alt="Admin" class="w-8 h-8 rounded-full">
                            <div class="hidden md:block">
                                <p class="text-sm font-medium text-gray-900">Admin Tuhu</p>
                                <p class="text-xs text-gray-500">Super Admin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Users -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Users</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                                <p class="text-xs text-green-600 mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i>+12% dari bulan lalu
                                </p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                        </div>
            </div>

                    <!-- Total Revenue -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                <div>
                                <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                                <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue']) }}</p>
                                <p class="text-xs text-green-600 mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i>+8% dari bulan lalu
                                </p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                            </div>
                </div>
            </div>

                    <!-- Total Transactions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                <div>
                                <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_transactions']) }}</p>
                                <p class="text-xs text-blue-600 mt-1">
                                    <i class="fas fa-arrow-up mr-1"></i>{{ $stats['today_transactions'] }} hari ini
                                </p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-full">
                                <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

                    <!-- Total Games -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                <div>
                                <p class="text-sm font-medium text-gray-600">Total Games</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_games']) }}</p>
                                <p class="text-xs text-orange-600 mt-1">
                                    <i class="fas fa-gamepad mr-1"></i>{{ $stats['top_games']->count() }} aktif
                                </p>
                            </div>
                            <div class="p-3 bg-orange-100 rounded-full">
                                <i class="fas fa-gamepad text-orange-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Status Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Transaksi Sukses</p>
                                <p class="text-2xl font-bold text-green-600">{{ number_format($stats['successful_transactions']) }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
            </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                <div>
                                <p class="text-sm font-medium text-gray-600">Transaksi Pending</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ number_format($stats['pending_transactions']) }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                            </div>
                </div>
            </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                <div>
                                <p class="text-sm font-medium text-gray-600">Transaksi Gagal</p>
                                <p class="text-2xl font-bold text-red-600">{{ number_format($stats['failed_transactions']) }}</p>
                            </div>
                            <div class="p-3 bg-red-100 rounded-full">
                                <i class="fas fa-times-circle text-red-600 text-xl"></i>
                            </div>
                </div>
            </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                <div>
                                <p class="text-sm font-medium text-gray-600">Transaksi Dibatalkan</p>
                                <p class="text-2xl font-bold text-gray-600">{{ number_format($stats['cancelled_transactions']) }}</p>
                            </div>
                            <div class="p-3 bg-gray-100 rounded-full">
                                <i class="fas fa-ban text-gray-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Analytics -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Revenue Chart -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 h-72">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Revenue Overview</h3>
                            <select class="text-sm border border-gray-300 rounded-lg px-3 py-1">
                                <option>7 Hari Terakhir</option>
                                <option>30 Hari Terakhir</option>
                                <option>3 Bulan Terakhir</option>
                            </select>
            </div>
                        <canvas id="revenueChart" class="w-full h-full"></canvas>
        </div>

                    <!-- Transaction Status Chart -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 h-72 min-h-[250px] flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Status Transaksi</h3>
                        </div>
                        <div class="flex-1 flex items-center justify-center relative">
                            <canvas id="statusChart" class="w-full h-full"></canvas>
                            <div id="statusChartPlaceholder" class="absolute inset-0 flex items-center justify-center text-gray-400 text-base hidden">
                                Belum ada data
                            </div>
                        </div>
                        <div class="flex justify-center gap-6 mt-6">
                            <div class="flex items-center gap-1">
                                <span class="inline-block w-6 h-3 rounded bg-green-500"></span>
                                <span class="text-gray-700 text-sm">Sukses</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="inline-block w-6 h-3 rounded bg-yellow-400"></span>
                                <span class="text-gray-700 text-sm">Pending</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="inline-block w-6 h-3 rounded bg-red-400"></span>
                                <span class="text-gray-700 text-sm">Gagal</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="inline-block w-6 h-3 rounded bg-gray-500"></span>
                                <span class="text-gray-700 text-sm">Dibatalkan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions and Quick Actions -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Transactions -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900">Transaksi Terbaru</h3>
                                <a href="/admin/transactions" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($stats['recent_transactions']->count() > 0)
                                <div class="space-y-4">
                                    @foreach($stats['recent_transactions']->take(5) as $transaction)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-shopping-cart text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $transaction->order_id }}</p>
                                                <p class="text-sm text-gray-600">{{ $transaction->user->name ?? 'User' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium text-gray-900">{{ $transaction->formatted_amount }}</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->status_badge_class }}">
                                                {{ ucfirst($transaction->transaction_status) }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                                    <p class="text-gray-500">Belum ada transaksi</p>
                                </div>
                            @endif
                        </div>
            </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="/admin/tambahProduk" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <i class="fas fa-plus text-blue-600 mr-3"></i>
                                <span class="text-blue-900">Tambah Produk</span>
                            </a>
                            <a href="/admin/resellers" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <i class="fas fa-users text-green-600 mr-3"></i>
                                <span class="text-green-900">Kelola Reseller</span>
                            </a>
                            <a href="/admin/withdrawals" class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                                <i class="fas fa-money-bill-wave text-yellow-600 mr-3"></i>
                                <span class="text-yellow-900">Withdrawal ({{ $stats['pending_withdrawals'] }})</span>
                            </a>
                            <a href="/admin/digiflazz" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                <i class="fas fa-cog text-purple-600 mr-3"></i>
                                <span class="text-purple-900">Digiflazz API</span>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Revenue',
                    data: [1200000, 1900000, 1500000, 2100000, 1800000, 2500000, 2200000],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusData = [
            {{ $stats['successful_transactions'] }},
            {{ $stats['pending_transactions'] }},
            {{ $stats['failed_transactions'] }},
            {{ $stats['cancelled_transactions'] }}
        ];
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sukses', 'Pending', 'Gagal', 'Dibatalkan'],
                datasets: [{
                    data: statusData,
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(234, 179, 8)',
                        'rgb(239, 68, 68)',
                        'rgb(107, 114, 128)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Tampilkan placeholder jika semua data 0
        if (statusData.reduce((a, b) => a + b, 0) === 0) {
            document.getElementById('statusChart').style.display = 'none';
            document.getElementById('statusChartPlaceholder').classList.remove('hidden');
        }
    </script>
</body>
</html>
