<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Reseller - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen">
    <div class="max-w-5xl mx-auto py-10 px-4">
        <a href="{{ route('admin.resellers.list') }}" class="text-aqua hover:underline mb-4 inline-block">← Kembali ke Daftar Reseller</a>
        <h1 class="text-3xl font-bold text-white mb-6">Detail Reseller: {{ $reseller->user->name }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Profil Reseller</h2>
                <ul class="text-gray-300 space-y-2">
                    <li><span class="font-semibold text-white">Nama:</span> {{ $reseller->user->name }}</li>
                    <li><span class="font-semibold text-white">Email:</span> {{ $reseller->user->email }}</li>
                    <li><span class="font-semibold text-white">Telepon:</span> {{ $reseller->phone }}</li>
                    <li><span class="font-semibold text-white">Perusahaan:</span> {{ $reseller->company_name ?? '-' }}</li>
                    <li><span class="font-semibold text-white">Alamat:</span> {{ $reseller->address }}, {{ $reseller->city }}, {{ $reseller->province }}, {{ $reseller->postal_code }}</li>
                    <li><span class="font-semibold text-white">Kode Reseller:</span> {{ $reseller->reseller_code }}</li>
                    <li><span class="font-semibold text-white">Kode Referral:</span> {{ $reseller->referral_code }}</li>
                    <li><span class="font-semibold text-white">Status:</span> <span class="px-2 py-1 rounded text-xs {{
                        $reseller->status === 'active' ? 'bg-green-700 text-green-200' :
                        ($reseller->status === 'pending' ? 'bg-yellow-700 text-yellow-200' :
                        ($reseller->status === 'suspended' ? 'bg-red-700 text-red-200' : 'bg-gray-700 text-gray-200'))
                    }}">{{ ucfirst($reseller->status) }}</span></li>
                    <li><span class="font-semibold text-white">Komisi:</span> {{ $reseller->commission_rate }}%</li>
                    <li><span class="font-semibold text-white">Saldo:</span> Rp {{ number_format($reseller->balance) }}</li>
                    <li><span class="font-semibold text-white">Total Pendapatan:</span> Rp {{ number_format($reseller->total_earnings) }}</li>
                    <li><span class="font-semibold text-white">Total Transaksi:</span> {{ $reseller->total_transactions }}</li>
                    <li><span class="font-semibold text-white">Tanggal Registrasi:</span> {{ $reseller->created_at->format('d M Y H:i') }}</li>
                    <li><span class="font-semibold text-white">Tanggal Disetujui:</span> {{ $reseller->approved_at ? $reseller->approved_at->format('d M Y H:i') : '-' }}</li>
                </ul>
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Statistik</h2>
                <ul class="text-gray-300 space-y-2">
                    <li>Total Transaksi: <span class="font-bold text-white">{{ $statistics['total_transactions'] }}</span></li>
                    <li>Transaksi Sukses: <span class="text-green-400">{{ $statistics['successful_transactions'] }}</span></li>
                    <li>Total Pendapatan: <span class="text-aqua">Rp {{ number_format($statistics['total_earnings']) }}</span></li>
                    <li>Saldo: <span class="text-blue-400">Rp {{ number_format($statistics['balance']) }}</span></li>
                    <li>Total Withdrawal: <span class="text-white">{{ $statistics['total_withdrawals'] }}</span></li>
                    <li>Pending Withdrawal: <span class="text-yellow-400">{{ $statistics['pending_withdrawals'] }}</span></li>
                    <li>Total Referral: <span class="text-white">{{ $statistics['total_referrals'] }}</span></li>
                </ul>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Transaksi Terbaru</h2>
                @if($reseller->transactions->count() > 0)
                    <ul class="text-gray-300 space-y-2">
                        @foreach($reseller->transactions->take(5) as $trx)
                        <li>
                            <span class="font-semibold text-white">{{ $trx->game->game_name ?? '-' }}</span> -
                            Rp {{ number_format($trx->amount) }} -
                            <span class="text-xs px-2 py-1 rounded {{
                                $trx->status === 'success' ? 'bg-green-700 text-green-200' :
                                ($trx->status === 'pending' ? 'bg-yellow-700 text-yellow-200' : 'bg-red-700 text-red-200')
                            }}">{{ ucfirst($trx->status) }}</span>
                            <span class="text-gray-400 text-xs">({{ $trx->created_at->format('d M Y H:i') }})</span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400">Belum ada transaksi.</p>
                @endif
            </div>
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Withdrawal Terbaru</h2>
                @if($reseller->withdrawals->count() > 0)
                    <ul class="text-gray-300 space-y-2">
                        @foreach($reseller->withdrawals->take(5) as $wd)
                        <li>
                            <span class="font-semibold text-white">Rp {{ number_format($wd->amount) }}</span> -
                            <span class="text-xs px-2 py-1 rounded {{
                                $wd->status === 'completed' ? 'bg-green-700 text-green-200' :
                                ($wd->status === 'pending' ? 'bg-yellow-700 text-yellow-200' : 'bg-red-700 text-red-200')
                            }}">{{ ucfirst($wd->status) }}</span>
                            <span class="text-gray-400 text-xs">({{ $wd->created_at->format('d M Y H:i') }})</span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-400">Belum ada withdrawal.</p>
                @endif
            </div>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <h2 class="text-lg font-semibold text-white mb-4">Referral</h2>
            @if($reseller->referrals->count() > 0)
                <ul class="text-gray-300 space-y-2">
                    @foreach($reseller->referrals as $ref)
                    <li>
                        <span class="font-semibold text-white">{{ $ref->user->name ?? '-' }}</span> -
                        <span class="text-gray-400 text-xs">{{ $ref->user->email ?? '-' }}</span>
                        <span class="text-xs px-2 py-1 rounded {{
                            $ref->status === 'active' ? 'bg-green-700 text-green-200' :
                            ($ref->status === 'pending' ? 'bg-yellow-700 text-yellow-200' : 'bg-red-700 text-red-200')
                        }}">{{ ucfirst($ref->status) }}</span>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-400">Belum ada referral.</p>
            @endif
        </div>
    </div>
</body>
</html> 