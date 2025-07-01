<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi</title>
    @vite('resources/css/app.css')
</head>
<body class="flex bg-gray-100">
    <x-admin-sidebar />
    <main class="w-full min-h-screen box-border bg-gray-50 overflow-hidden flex flex-col p-6">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Kelola Transaksi</h1>
            <button 
                onclick="showModal('addTransactionModal')" 
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                Tambah Transaksi
            </button>
        </header>

        <!-- Tabel Transaksi -->
        <div class="bg-white shadow rounded-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-4 border-b text-gray-700">ID Transaksi</th>
                        <th class="p-4 border-b text-gray-700">Produk</th>
                        <th class="p-4 border-b text-gray-700">Jumlah</th>
                        <th class="p-4 border-b text-gray-700">Total Harga</th>
                        <th class="p-4 border-b text-gray-700">Tanggal</th>
                        <th class="p-4 border-b text-gray-700">Status</th>
                        <th class="p-4 border-b text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contoh data -->
                    <tr>
                        <td class="p-4 border-b">TRX001</td>
                        <td class="p-4 border-b">Diamond ML (100dm)</td>
                        <td class="p-4 border-b">10</td>
                        <td class="p-4 border-b">Rp 1.000.000</td>
                        <td class="p-4 border-b">2025-01-12</td>
                        <td class="p-4 border-b">Pending</td>
                        <td class="p-4 border-b flex space-x-2">
                            <button 
                                onclick="showTransactionDetails('TRX001', 'Diamond ML (100dm)', 10, 'Rp 1.000.000', '2025-01-12', 'Pending')" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg">
                                Detail
                            </button>
                            <button 
                                onclick="confirmDelete()" 
                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg">
                                Hapus
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal Detail Transaksi -->
    <div id="transactionDetailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-lg font-bold mb-4">Detail Transaksi</h2>
            <div class="mb-2">
                <strong>ID Transaksi:</strong>
                <span id="detail-id-transaksi"></span>
            </div>
            <div class="mb-2">
                <strong>Produk:</strong>
                <span id="detail-produk"></span>
            </div>
            <div class="mb-2">
                <strong>Jumlah:</strong>
                <span id="detail-jumlah"></span>
            </div>
            <div class="mb-2">
                <strong>Total Harga:</strong>
                <span id="detail-harga"></span>
            </div>
            <div class="mb-2">
                <strong>Tanggal:</strong>
                <span id="detail-tanggal"></span>
            </div>
            <div class="mb-2">
                <strong>Status:</strong>
                <span id="detail-status"></span>
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button 
                    onclick="hideModal('transactionDetailModal')" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan modal
        function showModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        // Fungsi untuk menyembunyikan modal
        function hideModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Fungsi untuk menampilkan detail transaksi
        function showTransactionDetails(id, produk, jumlah, harga, tanggal, status) {
            document.getElementById('detail-id-transaksi').innerText = id;
            document.getElementById('detail-produk').innerText = produk;
            document.getElementById('detail-jumlah').innerText = jumlah;
            document.getElementById('detail-harga').innerText = harga;
            document.getElementById('detail-tanggal').innerText = tanggal;
            document.getElementById('detail-status').innerText = status;

            showModal('transactionDetailModal');
        }

        // Fungsi untuk konfirmasi hapus
        function confirmDelete() {
            if (confirm("Apakah Anda yakin ingin menghapus transaksi ini?")) {
                alert("Transaksi dihapus!");
            }
        }
    </script>
</body>
</html>
