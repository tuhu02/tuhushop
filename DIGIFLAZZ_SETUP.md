# Setup Digiflazz API Integration

## 📋 **Langkah-langkah Setup:**

### 1. **Daftar di Digiflazz**
- Kunjungi [https://digiflazz.com](https://digiflazz.com)
- Daftar akun baru
- Verifikasi email dan akun
- Dapatkan Username dan API Key dari dashboard

### 2. **Konfigurasi Environment Variables**
Tambahkan konfigurasi berikut ke file `.env`:

```env
# Digiflazz API Configuration
DIGIFLAZZ_USERNAME=your_username_here
DIGIFLAZZ_API_KEY=your_api_key_here
DIGIFLAZZ_BASE_URL=https://api.digiflazz.com/v1
```

### 3. **Jalankan Migration**
```bash
php artisan migrate
```

### 4. **Akses Admin Panel**
- Buka `/admin/digiflazz`
- Test koneksi API
- Update credentials jika diperlukan
- Sync games dari Digiflazz

## 🔧 **Fitur yang Tersedia:**

### **DigiflazzService** (`app/Services/DigiflazzService.php`)
- ✅ **getPriceList()**: Ambil daftar harga dari Digiflazz
- ✅ **getGameCategories()**: Ambil kategori game
- ✅ **checkConnection()**: Test koneksi API
- ✅ **syncGames()**: Sync game ke database lokal

### **Admin Controller** (`app/Http/Controllers/Admin/DigiflazzController.php`)
- ✅ **Dashboard**: Monitor status API dan data
- ✅ **Test Connection**: Test koneksi API
- ✅ **Sync Games**: Sync game dari Digiflazz
- ✅ **Update Credentials**: Update username dan API key
- ✅ **View Data**: Lihat price list dan kategori

### **Admin Dashboard** (`resources/views/admin/digiflazz/index.blade.php`)
- ✅ **Real-time Status**: Status koneksi API
- ✅ **Statistics**: Total produk, kategori, dll
- ✅ **Quick Actions**: Sync games, refresh data
- ✅ **Data Preview**: Preview produk dan kategori
- ✅ **Credentials Management**: Update API credentials

## 🚀 **Cara Menggunakan:**

### **1. Setup Awal**
```bash
# Jalankan migration
php artisan migrate

# Buka admin panel
http://localhost/admin/digiflazz
```

### **2. Test API Connection**
- Klik tombol "Test Connection"
- Pastikan status menunjukkan "Connected"

### **3. Sync Games**
- Klik tombol "Sync Games"
- Tunggu proses selesai
- Games akan otomatis masuk ke database

### **4. Monitor Data**
- Lihat statistics di dashboard
- Preview produk dan kategori
- Monitor status API

## 📊 **Data yang Di-sync:**

### **Fields dari Digiflazz:**
- `name` → `game_name`
- `brand` → `developer`
- `desc` → `description`
- `icon_url` → `thumbnail_url`
- `buyer_sku_code` → `digiflazz_id`
- `category` → `category`
- `price` → `price`
- `status` → `status`

### **Database Structure:**
```sql
games table:
- game_id (primary key)
- game_name
- developer
- release_date
- description
- thumbnail_url
- is_active
- digiflazz_id (new)
- category (new)
- price (new)
- brand (new)
- icon_url (new)
- status (new)
```

## 🔒 **Keamanan:**

### **API Credentials:**
- Disimpan di `.env` file
- Tidak di-commit ke repository
- Bisa di-update via admin panel

### **Rate Limiting:**
- Cache data selama 5 menit
- Prevent excessive API calls
- Error handling untuk connection issues

## 📝 **Troubleshooting:**

### **API Connection Failed:**
1. Cek username dan API key
2. Pastikan akun Digiflazz sudah aktif
3. Cek koneksi internet
4. Verifikasi URL API

### **Sync Games Failed:**
1. Cek log error di `storage/logs/laravel.log`
2. Pastikan database connection
3. Cek permission write ke database
4. Verifikasi struktur tabel games

### **Data Tidak Muncul:**
1. Clear cache: `php artisan cache:clear`
2. Refresh halaman admin
3. Cek apakah API mengembalikan data
4. Verifikasi response format

## 🎯 **Next Steps:**

1. **Verifikasi API**: Pastikan API key sudah aktif
2. **Test Sync**: Sync beberapa game untuk testing
3. **Customize UI**: Sesuaikan tampilan dengan kebutuhan
4. **Add Features**: Tambahkan fitur lain sesuai kebutuhan

## 📞 **Support:**

Jika ada masalah dengan setup:
1. Cek dokumentasi Digiflazz
2. Verifikasi API credentials
3. Cek log error Laravel
4. Hubungi support Digiflazz jika diperlukan 