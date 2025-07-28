<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $trx->order_id }} - Tuhu Shop</title>
    @vite('resources/css/app.css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        body { background: #23272f; }
        .invoice-main { background: #181824; border-radius: 1.5rem; box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18); max-width: 900px; margin: 2.5rem auto; padding: 2.5rem 2rem 2rem 2rem; color: #fff; }
        .invoice-header { display: flex; align-items: center; gap: 1.2rem; margin-bottom: 1.2rem; }
        .invoice-header img { width: 60px; height: 60px; border-radius: 1rem; object-fit: cover; }
        .invoice-title { font-size: 1.7rem; font-weight: 800; color: #facc15; }
        .invoice-tabs { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
        .invoice-tab { flex: 1; text-align: center; padding: 0.7rem 0; border-radius: 0.7rem 0.7rem 0 0; font-weight: 700; background: #23272f; color: #facc15; border-bottom: 3px solid transparent; transition: background 0.2s, color 0.2s; }
        .invoice-tab.active { background: #facc15; color: #23272f; border-bottom: 3px solid #facc15; }
        .invoice-row { display: flex; gap: 2rem; flex-wrap: wrap; }
        .invoice-col { flex: 1 1 320px; background: #23272f; border-radius: 1rem; padding: 1.5rem 1.2rem; margin-bottom: 1.5rem; box-shadow: 0 2px 8px 0 rgba(31,38,135,0.10); }
        .invoice-label { color: #facc15; font-weight: 600; }
        .invoice-value { color: #fff; font-weight: 600; }
        .invoice-total { color: #4ade80; font-size: 1.2rem; font-weight: 800; }
        .invoice-btn { background: #facc15; color: #23272f; font-weight: 700; padding: 0.7rem 2.2rem; border-radius: 0.7rem; font-size: 1.1rem; box-shadow: 0 2px 8px 0 rgba(250,204,21,0.10); transition: background 0.2s, transform 0.2s; margin-top: 1.2rem; }
        .invoice-btn:hover { background: #fde047; color: #181824; transform: translateY(-2px) scale(1.03); }
        .qr-box { background: #fff; border-radius: 1rem; padding: 1.2rem; display: flex; flex-direction: column; align-items: center; margin-top: 1.2rem; }
        .qr-box img { width: 180px; height: 180px; }
        .qr-label { color: #23272f; font-weight: 700; margin-top: 0.7rem; }
        .countdown { background: #facc15; color: #23272f; font-weight: 700; border-radius: 0.5rem; padding: 0.3rem 1.2rem; font-size: 1.1rem; margin-left: 1rem; }
        @media (max-width: 900px) { .invoice-row { flex-direction: column; gap: 0; } }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden pt-20">
    <nav class="sticky top-0 left-0 w-full z-50">
        <x-navbar />
    </nav>
    <div class="invoice-main">
        <div class="invoice-header">
            <img src="{{ $trx->game->banner_url ? asset('image/' . $trx->game->banner_url) : asset('image/banner-mlbb.jpg') }}" alt="Banner">
            <div>
                <div class="invoice-title">Invoice</div>
                <div style="color:#f1f5f9; font-size:1.1rem; font-weight:600;">{{ $trx->order_id }}</div>
                <div style="color:#f1f5f9; font-size:0.95rem;">Tanggal Transaksi: {{ $trx->created_at->format('Y-m-d H:i:s') }}</div>
            </div>
            <div class="ml-auto flex items-center">
                <span class="countdown" id="countdown">01:20:08</span>
            </div>
        </div>
        <div class="invoice-tabs">
            <div class="invoice-tab active">Pembayaran</div>
            <div class="invoice-tab">Proses</div>
            <div class="invoice-tab">Pesanan Selesai</div>
        </div>
        <div class="invoice-row">
            <div class="invoice-col">
                <div class="mb-4 flex items-center gap-3">
                    <img src="{{ $trx->game->thumbnail_url ? asset('image/' . $trx->game->thumbnail_url) : asset('image/logo-baru.png') }}" alt="Thumb" style="width:56px;height:56px;border-radius:0.7rem;object-fit:cover;">
                    <div>
                        <div class="font-bold text-lg">{{ $trx->game->product_name ?? '-' }}</div>
                        <div class="text-gray-300 text-sm">Mobile Legends Indonesia</div>
                    </div>
                </div>
                <div class="mb-2"><span class="invoice-label">User Id:</span> <span class="invoice-value">{{ $trx->user_id_game }}</span></div>
                <div class="mb-2"><span class="invoice-label">Server:</span> <span class="invoice-value">{{ $trx->server_id }}</span></div>
                <div class="mb-2"><span class="invoice-label">Email:</span> <span class="invoice-value">{{ $trx->metadata['email'] ?? '-' }}</span></div>
                <div class="mb-2"><span class="invoice-label">Layanan:</span> <span class="invoice-value">{{ $trx->game->product_name ?? '-' }}</span></div>
                <div class="mb-2"><span class="invoice-label">Data:</span> <span class="invoice-value">{{ $trx->user_id_game }}{{ $trx->server_id ? '|' . $trx->server_id : '' }}</span></div>
            </div>
            <div class="invoice-col">
                <div class="mb-2"><span class="invoice-label">Metode Pembayaran:</span> <span class="invoice-value">{{ strtoupper($midtransDetail->payment_type ?? ($trx->payment_method ?? 'QRIS')) }}</span></div>
                <div class="mb-2"><span class="invoice-label">Harga:</span> <span class="invoice-value">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span></div>
                <div class="mb-2"><span class="invoice-label">Fee:</span> <span class="invoice-value">Rp 0</span></div>
                <div class="mb-2"><span class="invoice-label">Total Bayar:</span> <span class="invoice-total">Rp {{ number_format($trx->amount, 0, ',', '.') }}</span></div>
                <div class="mb-2"><span class="invoice-label">Kontak:</span> <span class="invoice-value">{{ $trx->metadata['email'] ?? '-' }}</span></div>
                @if($midtransDetail)
                    @if($midtransDetail->payment_type == 'qris')
                        <div class="qr-box">
                            <img src="{{ $midtransDetail->actions[0]->url ?? '' }}" alt="QRIS">
                            <div class="qr-label">QRIS Pembayaran</div>
                            <a href="{{ $midtransDetail->actions[0]->url ?? '' }}" download class="invoice-btn w-full mt-2 text-center">Download QR Code</a>
                        </div>
                    @elseif($midtransDetail->payment_type == 'bank_transfer')
                        <div class="mb-2"><span class="invoice-label">Bank:</span> <span class="invoice-value">{{ strtoupper($midtransDetail->va_numbers[0]->bank ?? '-') }}</span></div>
                        <div class="mb-2"><span class="invoice-label">VA Number:</span> <span class="invoice-value">{{ $midtransDetail->va_numbers[0]->va_number ?? '-' }}</span></div>
                    @elseif($midtransDetail->payment_type == 'echannel')
                        <div class="mb-2"><span class="invoice-label">Bill Key:</span> <span class="invoice-value">{{ $midtransDetail->bill_key ?? '-' }}</span></div>
                        <div class="mb-2"><span class="invoice-label">Biller Code:</span> <span class="invoice-value">{{ $midtransDetail->biller_code ?? '-' }}</span></div>
                    @elseif($midtransDetail->payment_type == 'cstore')
                        <div class="mb-2"><span class="invoice-label">Retail:</span> <span class="invoice-value">{{ strtoupper($midtransDetail->store ?? '-') }}</span></div>
                        <div class="mb-2"><span class="invoice-label">Kode Bayar:</span> <span class="invoice-value">{{ $midtransDetail->payment_code ?? '-' }}</span></div>
                    @elseif($midtransDetail->payment_type == 'gopay')
                        <div class="mb-2"><span class="invoice-label">GoPay QR:</span></div>
                        <img src="{{ $midtransDetail->actions[0]->url ?? '' }}" alt="GoPay QR">
                    @endif
                @endif
            </div>
        </div>
        <div class="flex gap-3 mt-4">
            @if($trx->payment_status === 'pending' && $snapToken && empty($midtransDetail->payment_type))
                <button id="pay-button" class="invoice-btn flex-1">Lanjutkan Pembayaran</button>
                <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
                <script>
                    document.getElementById('pay-button').onclick = function() {
                        window.snap.pay('{{ $snapToken }}', {
                            onSuccess: function(result){ location.reload(); },
                            onPending: function(result){ location.reload(); },
                            onClose: function(){ location.reload(); },
                            onError: function(result){ alert('Pembayaran gagal!'); }
                        });
                    }
                </script>
            @elseif($midtransDetail && $midtransDetail->payment_type)
                <!-- Instruksi pembayaran dinamis sudah tampil di atas (VA, QRIS, retail, dsb) -->
            @endif
        </div>
    </div>
</body>
</html> 