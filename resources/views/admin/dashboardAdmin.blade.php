
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Dashboard Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="flex">
    <!-- Sidebar -->
    <x-admin-sidebar />
    <!-- kode utama -->
    <div class="flex-1 ml-64 p-5">
        <div class="grid grid-cols-3">
            <div class="shadow-lg rounded-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-500">SELAMAT DATANG</h1>
                    <h1 class="font-semibold text-2xl text-gray-700">Tuhu Pangestu</h1>
                </div>
                <i class="fa fa-user ml-auto text-gray-700 text-3xl"></i>
            </div>

            <div class="shadow-lg rounded-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-500">TOTAL USER</h1>
                    <h1 class="font-semibold text-2xl text-gray-700">5</h1>
                </div>
                <i class="fa fa-users ml-auto text-gray-700 text-3xl"></i>
            </div>

            <div class="shadow-lg rounded-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-500">TOTAL PRODUK</h1>
                    <h1 class="font-semibold text-2xl text-gray-700">5</h1>
                </div>
                <i class="fa fa-cubes ml-auto text-gray-700 text-3xl"></i>
            </div>
        </div>

        <h1 class="mt-5 font-semibold text-gray-700 text-2xl">Transaksi</h1>
        <div class="grid grid-cols-2">
            <div class="shadow-lg rounded-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-500">GAGAL</h1>
                    <h1 class="font-semibold text-2xl text-gray-700">0</h1>
                </div>
                <img src="https://knockgameshop.id/static/media/status_error.7218e1e2434090240e8c.png" alt="" class="w-20">
            </div>

            <div class="shadow-lg rounded-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-500">PENDING</h1>
                    <h1 class="font-semibold text-2xl text-gray-700">2</h1>
                </div>
                <img src="https://knockgameshop.id/static/media/status_pending.cca68d8bea77e3f27c74.png" alt="" class="w-20">
            </div>

            <div class="shadow-lg rounded-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-500">SELESAI</h1>
                    <h1 class="font-semibold text-2xl text-gray-700">10</h1>
                </div>
                <img src="data:image/png;base64,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" alt="" class="w-20">
            </div>

            <div class="shadow-lg rounded-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-500">DIBATALKAN</h1>
                    <h1 class="font-semibold text-2xl text-gray-700">3</h1>
                </div>
                <img src="https://knockgameshop.id/static/media/status_cancel.c8f2996d346f26c721d2.png" alt="" class="w-20">
            </div>
        </div>

        <h1 class="mt-5 font-semibold text-gray-700 text-2xl">Statistik</h1>
        <div class="grid grid-cols-2">
            <div class="rounded-lg shadow-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-700">Hari ini</h1>
                    <p class="text-gray-700">Total Pengunjung: 98</p>
                    <p class="text-green-700">Total Interaksi Halaman: 991</p>
                    <p class="text-green-700">Pengunjung Hari ini: 10</p>
                    <p class="text-green-700">Online: 98</p>
                </div>
                <i class="fa fa-chart-line ml-auto pl-5 text-2xl text-gray-700"></i>
            </div>

            <div class="rounded-lg shadow-lg p-5 flex justify-between items-center">
                <div>
                    <h1 class="font-semibold text-gray-700">FILTER</h1>
                    <input type="date">
                    <p class="text-green-700">Pengunjung: 10</p>
                    <p class="text-green-700">Interaksi: 98</p>
                </div>
                <i class="fa fa-chart-line ml-auto pl-5 text-2xl text-gray-700"></i>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
