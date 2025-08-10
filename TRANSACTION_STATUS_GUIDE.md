# 📋 Panduan Status Transaksi

## 🎯 Ringkasan

**Status "SUCCESS" + "PENDING"** adalah **NORMAL** dan menunjukkan:
- ✅ Pembayaran berhasil diterima
- ✅ Request berhasil dikirim ke Digiflazz  
- ⏳ Sedang diproses oleh server game

## 📊 Penjelasan Status

### 🏦 Status Pembayaran (Payment Status)
- `pending` = Menunggu pembayaran
- `paid` = Pembayaran berhasil ✅
- `expired` = Pembayaran kedaluwarsa
- `failed` = Pembayaran gagal

### 🔄 Status Transaksi Lokal (Transaction Status)
- `pending` = Belum diproses
- `processing` = Sedang diproses
- `success` = Berhasil diproses ✅
- `failed` = Gagal diproses

### 🎮 Status Digiflazz (Provider Status)
- `Pending` = Sedang diproses server game ⏳ **NORMAL**
- `Sukses` = Selesai, item/diamond terkirim ✅
- `Gagal` = Gagal, akan direfund ❌

## ⚡ Command untuk Monitoring

### 1. Cek Status Transaksi Tertentu
```bash
php artisan transaction:check ORDER-123456789
```

### 2. Cek Status dari Digiflazz
```bash
php artisan digiflazz:check-status ORDER-123456789
```

### 3. Monitor Semua Transaksi Pending
```bash
php artisan transaction:monitor-pending
```

### 4. Update Status Otomatis
```bash
php artisan transaction:update-status
```

### 5. Retry Transaksi Gagal
```bash
php artisan transaction:retry ORDER-123456789
```

## 🤖 Monitoring Otomatis

Sistem akan otomatis mengecek status setiap 5 menit:
```php
// Sudah dikonfigurasi di routes/console.php
Schedule::command('transaction:update-status')
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->runInBackground();
```

### Menjalankan Scheduler
```bash
# Untuk production
php artisan schedule:run

# Untuk development (running continuously)
php artisan schedule:work
```

## ⏰ Timeline Normal

1. **0-1 menit**: Pembayaran → Status `paid`
2. **1-2 menit**: Kirim ke Digiflazz → Status `success` + `Pending`
3. **5-30 menit**: Server game memproses → Status `Sukses`

## 🚨 Kapan Harus Khawatir

- ❌ Jika status `Pending` lebih dari **1 jam**
- ❌ Jika status berubah menjadi `Gagal`
- ❌ Jika ada error koneksi berulang

## 🔧 Troubleshooting

### Problem: IP Tidak Dikenali
```
Error: "IP Anda tidak kami kenali"
```
**Solusi**: Hubungi support Digiflazz untuk whitelist IP server

### Problem: Koneksi Gagal
```
Error: "Failed to connect to Digiflazz"
```
**Solusi**: 
1. Cek koneksi internet server
2. Cek DNS resolution ke api.digiflazz.com
3. Cek firewall settings

### Problem: Invalid Payload
```
Error: "Invalid Payload"
```
**Solusi**: Cek konfigurasi API credentials di config/services.php

## 📞 Support

Jika ada transaksi yang stuck lebih dari 1 jam:
1. Catat Order ID dan waktu transaksi
2. Hubungi support Digiflazz dengan data tersebut
3. Gunakan command retry jika diperlukan

## 🎯 Best Practices

1. **Jangan panic** jika status `Pending` - ini normal
2. **Monitor otomatis** sudah berjalan setiap 5 menit  
3. **Cek manual** hanya jika ada keluhan customer
4. **Dokumentasi** setiap issue untuk pattern analysis

