<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digiflazz API Management - Admin</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <x-admin-sidebar />
    <div class="ml-64 min-h-screen">
        <div class="p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Digiflazz API Management</h1>
            <p class="text-gray-600 mb-8">Kelola integrasi dengan Digiflazz API untuk data game</p>

            <!-- Connection Status & Credentials & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- API Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">API Status</h3>
                        <div class="w-3 h-3 rounded-full {{ $connectionStatus['success'] ? 'bg-green-500' : 'bg-red-500' }}"></div>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">{{ $connectionStatus['message'] }}</p>
                    <button id="testConnection" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                        Test Connection
                    </button>
                </div>

                <!-- API Credentials -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">API Credentials</h3>
                    <form id="credentialsForm" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="text" name="username" value="{{ env('DIGIFLAZZ_USERNAME', '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                            <input type="password" name="api_key" value="{{ env('DIGIFLAZZ_API_KEY', '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                            Update Credentials
                        </button>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <button id="syncGames" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                            Sync Games
                        </button>
                        <button id="refreshData" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                            Refresh Data
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-teal-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900">{{ count($priceList) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm">Categories</p>
                            <p class="text-2xl font-bold text-gray-900">{{ count($categories) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm">Last Sync</p>
                            <p class="text-lg font-bold text-gray-900">{{ now()->format('H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm">Status</p>
                            <p class="text-lg font-bold text-gray-900">{{ $connectionStatus['success'] ? 'Connected' : 'Disconnected' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Preview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Game Categories</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach(array_slice($categories, 0, 12) as $category => $items)
                    <div class="bg-gray-100 rounded-lg p-4">
                        <h4 class="text-gray-900 font-medium text-sm mb-2">{{ $category }}</h4>
                        <p class="text-gray-500 text-xs">{{ count($items) }} products</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Products Preview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Products</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-100">
                            <tr>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Brand</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($priceList, 0, 10) as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-900">{{ $item['name'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $item['brand'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $item['category'] ?? 'N/A' }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($item['price'] ?? 0) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ ($item['status'] ?? '') == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item['status'] ?? 'unknown' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-gray-800 rounded-lg p-6 text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-aqua mx-auto mb-4"></div>
            <p class="text-white">Processing...</p>
        </div>
    </div>

    <script>
        // Test Connection
        document.getElementById('testConnection').addEventListener('click', function() {
            fetch('/admin/digiflazz/test-connection')
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                });
        });

        // Update Credentials
        document.getElementById('credentialsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('/admin/digiflazz/update-credentials', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    location.reload();
                }
            });
        });

        // Sync Games
        document.getElementById('syncGames').addEventListener('click', function() {
            if (confirm('Are you sure you want to sync games from Digiflazz?')) {
                document.getElementById('loadingModal').classList.remove('hidden');
                document.getElementById('loadingModal').classList.add('flex');
                
                fetch('/admin/digiflazz/sync-games')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('loadingModal').classList.add('hidden');
                        document.getElementById('loadingModal').classList.remove('flex');
                        alert(`Synced ${data.synced_count} games successfully!`);
                        location.reload();
                    });
            }
        });

        // Refresh Data
        document.getElementById('refreshData').addEventListener('click', function() {
            location.reload();
        });
    </script>
</body>
</html> 