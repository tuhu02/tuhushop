<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Reseller</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-white mb-6">Daftar & Manajemen Reseller</h1>
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <form method="GET" action="" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, kode reseller..." class="px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring-aqua focus:border-aqua">
                <select name="status" class="px-4 py-2 rounded bg-gray-700 text-white border border-gray-600">
                    <option value="">Semua Status</option>
                    <option value="active" @if(request('status')=='active') selected @endif>Active</option>
                    <option value="pending" @if(request('status')=='pending') selected @endif>Pending</option>
                    <option value="suspended" @if(request('status')=='suspended') selected @endif>Suspended</option>
                    <option value="rejected" @if(request('status')=='rejected') selected @endif>Rejected</option>
                </select>
                <button type="submit" class="bg-aqua text-white px-4 py-2 rounded">Cari</button>
            </form>
            <a href="{{ route('admin.resellers') }}" class="text-aqua hover:underline">Kembali ke Dashboard Admin</a>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 overflow-x-auto">
            <table class="w-full text-left text-gray-300">
                <thead>
                    <tr>
                        <th class="py-2">Nama</th>
                        <th>Email</th>
                        <th>Kode Reseller</th>
                        <th>Status</th>
                        <th>Saldo</th>
                        <th>Total Transaksi</th>
                        <th>Komisi</th>
                        <th class="px-4 py-2">Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resellers as $reseller)
                    <tr class="border-b border-gray-700">
                        <td class="py-2 font-semibold text-white">{{ $reseller->user->name }}</td>
                        <td>{{ $reseller->user->email }}</td>
                        <td>{{ $reseller->reseller_code }}</td>
                        <td>
                            <span class="px-2 py-1 rounded text-xs {{
                                $reseller->status === 'active' ? 'bg-green-700 text-green-200' :
                                ($reseller->status === 'pending' ? 'bg-yellow-700 text-yellow-200' :
                                ($reseller->status === 'suspended' ? 'bg-red-700 text-red-200' : 'bg-gray-700 text-gray-200'))
                            }}">
                                {{ ucfirst($reseller->status) }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($reseller->balance) }}</td>
                        <td>{{ $reseller->total_transactions }}</td>
                        <td>{{ $reseller->commission_rate }}%</td>
                        <td class="px-4 py-2">{{ ucfirst($reseller->level) }}</td>
                        <td class="flex gap-2 flex-wrap">
                            <a href="{{ route('admin.resellers.show', $reseller) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">Detail</a>
                            @if($reseller->status === 'pending')
                                <form method="POST" action="{{ route('admin.resellers.approve', $reseller) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.resellers.reject', $reseller) }}" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="rejection_reason" value="Ditolak admin">
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">Reject</button>
                                </form>
                            @elseif($reseller->status === 'active')
                                <form method="POST" action="{{ route('admin.resellers.suspend', $reseller) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-xs">Suspend</button>
                                </form>
                            @elseif($reseller->status === 'suspended')
                                <form method="POST" action="{{ route('admin.resellers.activate', $reseller) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">Activate</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-400 py-6">Tidak ada reseller ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $resellers->links() }}
            </div>
        </div>
    </div>
</body>
</html> 