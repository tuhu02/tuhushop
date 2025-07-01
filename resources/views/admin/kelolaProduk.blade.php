<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>
    @vite('resources/css/app.css')
</head>
<body class="flex">
    <x-admin-sidebar />

    <main class="w-full min-h-screen box-border bg-gray-50 overflow-hidden flex flex-col ml-64">
        <div class="w-full space-y-3 h-screen overflow-y-scroll p-5">
            <!-- Produk Gambar -->
            <div class="relative inline-block w-64 h-64 bg-gray-300 rounded-md">
                <span class="absolute inset-0 flex items-center justify-center text-white font-bold">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLjVKjGsxGr-TQxWc36uzSspIJ75058QGc_A&s" alt="">
                </span>
                <button class="absolute bottom-2 right-2 bg-red-700 text-white text-xs px-3 py-1 rounded hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-300">
                    <i class="fa fa-pencil"></i>
                </button>
            </div>

            <!-- Input Produk -->
            <div class="flex">
                <input type="text" value="MOBILE LEGENDS: BANG BANG" class="mt-2 border font-semibold text-gray-400 text-sm border-aqua rounded-sm w-52 p-2">
                <button class="p-2 w-9 ml-2 mt-2 bg-red-600 rounded-lg">
                    <i class="fa fa-pencil text-sm text-white"></i>
                </button>
            </div>

            <!-- Deskripsi Produk -->
            <textarea class="border border-aqua rounded-sm mt-2 p-2 w-full h-fit">
Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit ad delectus, quibusdam maxime, fugiat dignissimos, sunt beatae autem minus ullam voluptatem repellat omnis aperiam. Delectus voluptate enim culpa possimus natus.
            </textarea>

            <!-- Tabel Produk -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-500 mt-2">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">Produk</th>
                            <th scope="col" class="px-6 py-3">Harga</th>
                            <th scope="col" class="px-6 py-3">Stok</th>
                            <th scope="col" class="px-6 py-3">Update</th>
                            <th scope="col" class="px-6 py-3 text-center">Atur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Produk -->
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4">
                                <p class="text-blue-600 font-medium">5 Diamond</p>
                            </td>
                            <td class="px-6 py-4 text-orange-500 font-bold">Rp. 1.500</td>
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">10 Mei 2023<br>18:34:42</td>
                            <td class="px-6 py-4 text-center">
                                <button class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none">
                                    Atur
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4">
                                <p class="text-blue-600 font-medium">10 Diamond</p>
                            </td>
                            <td class="px-6 py-4 text-orange-500 font-bold">Rp. 3.000</td>
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">11 Mei 2023<br>15:12:30</td>
                            <td class="px-6 py-4 text-center">
                                <button class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none">
                                    Atur
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4">
                                <p class="text-blue-600 font-medium">12 Diamond</p>
                            </td>
                            <td class="px-6 py-4 text-orange-500 font-bold">Rp. 3.500</td>
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">12 Mei 2023<br>09:45:20</td>
                            <td class="px-6 py-4 text-center">
                                <button class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none">
                                    Atur
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4">
                                <p class="text-blue-600 font-medium">86 Diamond</p>
                            </td>
                            <td class="px-6 py-4 text-orange-500 font-bold">Rp. 20.000</td>
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">12 Mei 2023<br>11:00:42</td>
                            <td class="px-6 py-4 text-center">
                                <button class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none">
                                    Atur
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4">
                                <p class="text-blue-600 font-medium">172 Diamond</p>
                            </td>
                            <td class="px-6 py-4 text-orange-500 font-bold">Rp. 42.000</td>
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">13 Mei 2023<br>13:23:45</td>
                            <td class="px-6 py-4 text-center">
                                <button class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none">
                                    Atur
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b bg-white">
                            <td class="px-6 py-4">
                                <p class="text-blue-600 font-medium">344 Diamond</p>
                            </td>
                            <td class="px-6 py-4 text-orange-500 font-bold">Rp. 70.000</td>
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4">14 Mei 2023<br>10:40:23</td>
                            <td class="px-6 py-4 text-center">
                                <button class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none">
                                    Atur
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
