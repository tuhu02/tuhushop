<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Reseller</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    <x-admin-sidebar />
    <div class="ml-64 min-h-screen">
        <div class="p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Manajemen Reseller</h1>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Reseller Pending Approval</h2>
                @if($recentResellers->where('status', 'pending')->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-gray-700">
                            <thead>
                                <tr>
                                    <th class="py-2">Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentResellers->where('status', 'pending') as $reseller)
                                <tr class="border-b border-gray-100">
                                    <td class="py-2">{{ $reseller->user->name }}</td>
                                    <td>{{ $reseller->user->email }}</td>
                                    <td>{{ $reseller->phone }}</td>
                                    <td><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span></td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.resellers.approve', $reseller) }}" style="display:inline">
                                            @csrf
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.resellers.reject', $reseller) }}" style="display:inline">
                                            @csrf
                                            <input type="hidden" name="rejection_reason" value="Ditolak admin">
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs ml-2">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Tidak ada reseller yang menunggu approval.</p>
                @endif
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Statistik Reseller</h2>
                <ul class="text-gray-700">
                    <li>Total Reseller: <span class="font-bold text-gray-900">{{ $statistics['total_resellers'] ?? '-' }}</span></li>
                    <li>Active: <span class="text-green-600">{{ $statistics['active_resellers'] ?? '-' }}</span></li>
                    <li>Pending: <span class="text-yellow-600">{{ $statistics['pending_resellers'] ?? '-' }}</span></li>
                    <li>Total Komisi Dibayarkan: <span class="text-blue-600">Rp {{ number_format($statistics['total_commission_paid'] ?? 0) }}</span></li>
                    <li>Total Saldo Reseller: <span class="text-purple-600">Rp {{ number_format($statistics['total_balance'] ?? 0) }}</span></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html> 