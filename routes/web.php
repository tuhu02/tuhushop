<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// ==========================================================
// == BAGIAN INI YANG DIPERBAIKI ==
// ==========================================================
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CekTransaksiController; // Penulisan diperbaiki
use App\Http\Controllers\KontakController;       // Penulisan diperbaiki
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
// Anda mungkin juga perlu menambahkan ResellerController jika ada
use App\Http\Controllers\ResellerController; 

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer Routes
Route::post('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
Route::get('/invoice/{orderId}', [CustomerController::class, 'invoice'])->name('invoice');
Route::get('/payment/{orderId}', [CustomerController::class, 'payment'])->name('payment');
Route::get('/payment/success/{orderId}', [CustomerController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failed/{orderId}', [CustomerController::class, 'paymentFailed'])->name('payment.failed');
Route::get('/check-digiflazz-status/{orderId}', [CustomerController::class, 'checkDigiflazzStatus'])->name('check.digiflazz.status');

// Reseller Routes
Route::prefix('reseller')->name('reseller.')->group(function () {
    Route::get('/register', [ResellerController::class, 'showRegister'])->name('register');
    Route::post('/register', [ResellerController::class, 'register']);
    
    // Protected reseller routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [ResellerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [ResellerController::class, 'profile'])->name('profile');
        Route::put('/profile', [ResellerController::class, 'updateProfile'])->name('profile.update');
        Route::get('/transactions', [ResellerController::class, 'transactions'])->name('transactions');
        Route::get('/withdrawals', [ResellerController::class, 'withdrawals'])->name('withdrawals');
        Route::get('/withdrawal/new', [ResellerController::class, 'showWithdrawalForm'])->name('withdrawal.new');
        Route::post('/withdrawal', [ResellerController::class, 'submitWithdrawal'])->name('withdrawal.submit');
        Route::get('/referrals', [ResellerController::class, 'referrals'])->name('referrals');
    });
});

// Route utama (dashboard pengguna)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/cekTransaksi', [CekTransaksiController::class, 'index'])->name('cekTransaksi');

Route::get('/kontak',[KontakController::class , 'index'])->name('kontak');

// Route admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // Produk routes
    Route::resource('produk', App\Http\Controllers\Admin\ProdukController::class);
    Route::get('produk/{product}/denom/create', [App\Http\Controllers\Admin\ProdukController::class, 'createDenom'])->name('produk.denom.create');
    Route::get('produk/{product_id}/account-fields', [App\Http\Controllers\Admin\ProdukController::class, 'editAccountFields'])->name('produk.account-fields');
    Route::put('produk/{product_id}/account-fields', [App\Http\Controllers\Admin\ProdukController::class, 'updateAccountFields'])->name('produk.account-fields.update');
    Route::post('produk/update-order', [App\Http\Controllers\Admin\ProdukController::class, 'updateOrder'])->name('produk.update-order');
    Route::post('produk/{product}/sync-digiflazz', [App\Http\Controllers\Admin\ProdukController::class, 'syncDigiflazzDenom'])->name('produk.sync-digiflazz');

    // Game routes
    Route::resource('games', App\Http\Controllers\Admin\GameController::class);

    // Price List routes
    Route::resource('price-lists', App\Http\Controllers\Admin\PriceListController::class);

    // Kategori routes
    Route::resource('kategori-produk', App\Http\Controllers\Admin\KategoriProdukController::class);
    Route::resource('kategori-denom', App\Http\Controllers\Admin\KategoriDenomController::class);

    // Denom routes
    Route::resource('denom', App\Http\Controllers\Admin\DenomController::class);
    Route::get('denom/import', [App\Http\Controllers\Admin\DenomController::class, 'import'])->name('denom.import');
    Route::get('denom/import-digiflazz', [App\Http\Controllers\Admin\DenomController::class, 'importDigiflazz'])->name('denom.importDigiflazz');
    Route::post('denom/import-digiflazz', [App\Http\Controllers\Admin\DenomController::class, 'importDigiflazz'])->name('denom.importDigiflazz');
    Route::get('denom/manual', [App\Http\Controllers\Admin\DenomController::class, 'manual'])->name('denom.manual');
    Route::post('denom/store-manual', [App\Http\Controllers\Admin\DenomController::class, 'storeManual'])->name('denom.storeManual');

    // Reseller Management routes
    Route::resource('resellers', App\Http\Controllers\Admin\ResellerManagementController::class);
    Route::post('resellers/{reseller}/approve', [App\Http\Controllers\Admin\ResellerManagementController::class, 'approve'])->name('resellers.approve');
    Route::post('resellers/{reseller}/reject', [App\Http\Controllers\Admin\ResellerManagementController::class, 'reject'])->name('resellers.reject');
    Route::post('resellers/{reseller}/suspend', [App\Http\Controllers\Admin\ResellerManagementController::class, 'suspend'])->name('resellers.suspend');
    Route::post('resellers/{reseller}/activate', [App\Http\Controllers\Admin\ResellerManagementController::class, 'activate'])->name('resellers.activate');

    // Digiflazz routes
    Route::get('digiflazz', [App\Http\Controllers\Admin\DigiflazzController::class, 'index'])->name('digiflazz.index');
    Route::post('digiflazz/sync', [App\Http\Controllers\Admin\DigiflazzController::class, 'syncProducts'])->name('digiflazz.sync');

    // Additional admin routes
    Route::get('transactions', [App\Http\Controllers\Admin\AdminDashboardController::class, 'transactions'])->name('transactions');
    Route::get('withdrawals', [App\Http\Controllers\Admin\AdminDashboardController::class, 'withdrawals'])->name('withdrawals.index');
    Route::get('statistics', [App\Http\Controllers\Admin\AdminDashboardController::class, 'statistics'])->name('statistics');
});

// Route publik produk (pastikan didefinisikan setelah group admin)
Route::get('/produk/{product_id}', [ProdukController::class, 'showPublic'])->name('produk.public');
// Route pembelian produk Digiflazz
Route::post('/produk/{product_id}/buy', [ProdukController::class, 'buyDigiflazz'])->name('produk.buy');

// Routes untuk Midtrans dan Invoice
Route::post('/midtrans/notification', [ProdukController::class, 'handlePaymentNotification']);
Route::get('/payment/{ref_id}', [ProdukController::class, 'showPayment'])->name('payment.show');
Route::get('/transaction/{ref_id}/invoice', [ProdukController::class, 'showInvoice'])->name('transaction.invoice');

// Route untuk pengecekan nickname MLBB
Route::post('/api/mlbb-nickname', [ProdukController::class, 'cekMLBBUsername']);

// Route test untuk pengecekan nickname MLBB (tanpa CSRF)
Route::post('/test/mlbb-nickname', [ProdukController::class, 'cekMLBBUsername'])->middleware('web')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

