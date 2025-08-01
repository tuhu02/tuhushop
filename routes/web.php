<?php   
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\cekTransaksiController;
use App\http\Controllers\kontakController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Http;


// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer Routes
Route::post('/checkout', [App\Http\Controllers\CustomerController::class, 'checkout'])->name('checkout');
Route::get('/invoice/{orderId}', [App\Http\Controllers\CustomerController::class, 'invoice'])->name('invoice');
Route::get('/payment/{orderId}', [App\Http\Controllers\CustomerController::class, 'payment'])->name('payment');
Route::get('/payment/success/{orderId}', [App\Http\Controllers\CustomerController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/failed/{orderId}', [App\Http\Controllers\CustomerController::class, 'paymentFailed'])->name('payment.failed');

// Reseller Routes
Route::prefix('reseller')->name('reseller.')->group(function () {
    Route::get('/register', [App\Http\Controllers\ResellerController::class, 'showRegister'])->name('register');
    Route::post('/register', [App\Http\Controllers\ResellerController::class, 'register']);
    
    // Protected reseller routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\ResellerController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [App\Http\Controllers\ResellerController::class, 'profile'])->name('profile');
        Route::put('/profile', [App\Http\Controllers\ResellerController::class, 'updateProfile'])->name('profile.update');
        Route::get('/transactions', [App\Http\Controllers\ResellerController::class, 'transactions'])->name('transactions');
        Route::get('/withdrawals', [App\Http\Controllers\ResellerController::class, 'withdrawals'])->name('withdrawals');
        Route::get('/withdrawal/new', [App\Http\Controllers\ResellerController::class, 'showWithdrawalForm'])->name('withdrawal.new');
        Route::post('/withdrawal', [App\Http\Controllers\ResellerController::class, 'submitWithdrawal'])->name('withdrawal.submit');
        Route::get('/referrals', [App\Http\Controllers\ResellerController::class, 'referrals'])->name('referrals');
    });
});

// Route utama (dashboard pengguna)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/cekTransaksi', [cekTransaksiController::class, 'index'])->name('cekTransaksi');

Route::get('kontak',[kontakController::class , 'index'])->name('kontak');

// Route::get('/cekTransaksi',function(){
//     return view('cekTransaksi');
// });

// Route admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // Produk Management
    Route::get('/produk', [App\Http\Controllers\Admin\ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [App\Http\Controllers\Admin\ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [App\Http\Controllers\Admin\ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{product}', [App\Http\Controllers\Admin\ProdukController::class, 'show'])->name('produk.show');
    Route::get('/produk/{product}/edit', [App\Http\Controllers\Admin\ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{product}', [App\Http\Controllers\Admin\ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{product}', [App\Http\Controllers\Admin\ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::post('/produk/{product}/sync-digiflazz', [App\Http\Controllers\Admin\ProdukController::class, 'syncDigiflazzDenom'])->name('produk.syncDigiflazz');
    Route::post('/produk/update-order', [App\Http\Controllers\Admin\ProdukController::class, 'updateOrder'])->name('produk.updateOrder');

    // Kategori Management
    Route::get('/kategori', [App\Http\Controllers\Admin\KategoriProdukController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [App\Http\Controllers\Admin\KategoriProdukController::class, 'store'])->name('kategori.store');
    Route::delete('/kategori/{id}', [App\Http\Controllers\Admin\KategoriProdukController::class, 'destroy'])->name('kategori.destroy');

    // Denom Management
    Route::post('/denom', [App\Http\Controllers\Admin\PriceListController::class, 'store'])->name('denom.store');
    Route::get('/denom/{id}/edit', [App\Http\Controllers\Admin\PriceListController::class, 'edit'])->name('denom.edit');
    Route::put('/denom/{id}', [App\Http\Controllers\Admin\PriceListController::class, 'update'])->name('denom.update');
    Route::delete('/denom/{id}', [App\Http\Controllers\Admin\PriceListController::class, 'destroy'])->name('denom.destroy');
    Route::patch('/denom/{id}/toggle-status', [App\Http\Controllers\Admin\PriceListController::class, 'toggleStatus'])->name('denom.toggleStatus');
    Route::post('/denom/bulk-update', [App\Http\Controllers\Admin\PriceListController::class, 'bulkUpdate'])->name('denom.bulkUpdate');
    Route::post('/denom/update-order', [App\Http\Controllers\Admin\PriceListController::class, 'updateOrder'])->name('denom.updateOrder');

    // Bundle Management
    // Route::resource('bundles', App\Http\Controllers\Admin\BundleController::class);

    // Transaction Management
    Route::get('/transactions', function () {
        return view('admin.kelolaTransaksi');
    })->name('transactions');

    // Digiflazz API Management
    Route::get('/digiflazz', [App\Http\Controllers\Admin\DigiflazzController::class, 'index'])->name('digiflazz.index');
    Route::post('/digiflazz/test-connection', [App\Http\Controllers\Admin\DigiflazzController::class, 'testConnection'])->name('digiflazz.test');
    Route::post('/digiflazz/sync-games', [App\Http\Controllers\Admin\DigiflazzController::class, 'syncGames'])->name('digiflazz.sync');
    Route::post('/digiflazz/update-credentials', [App\Http\Controllers\Admin\DigiflazzController::class, 'updateCredentials'])->name('digiflazz.credentials');
    Route::get('/digiflazz/price-list', [App\Http\Controllers\Admin\DigiflazzController::class, 'getPriceList'])->name('digiflazz.pricelist');
    Route::get('/digiflazz/categories', [App\Http\Controllers\Admin\DigiflazzController::class, 'getCategories'])->name('digiflazz.categories');

    // Reseller Management
    Route::get('/resellers', [App\Http\Controllers\Admin\ResellerManagementController::class, 'index'])->name('resellers.index');
    Route::get('/resellers/list', [App\Http\Controllers\Admin\ResellerManagementController::class, 'resellers'])->name('resellers.list');
    Route::get('/resellers/{reseller}', [App\Http\Controllers\Admin\ResellerManagementController::class, 'show'])->name('resellers.show');
    Route::post('/resellers/{reseller}/approve', [App\Http\Controllers\Admin\ResellerManagementController::class, 'approve'])->name('resellers.approve');
    Route::post('/resellers/{reseller}/reject', [App\Http\Controllers\Admin\ResellerManagementController::class, 'reject'])->name('resellers.reject');
    Route::post('/resellers/{reseller}/suspend', [App\Http\Controllers\Admin\ResellerManagementController::class, 'suspend'])->name('resellers.suspend');
    Route::post('/resellers/{reseller}/activate', [App\Http\Controllers\Admin\ResellerManagementController::class, 'activate'])->name('resellers.activate');
    Route::put('/resellers/{reseller}/commission', [App\Http\Controllers\Admin\ResellerManagementController::class, 'updateCommission'])->name('resellers.commission');
    Route::get('/resellers/statistics', [App\Http\Controllers\Admin\ResellerManagementController::class, 'statistics'])->name('resellers.statistics');
    Route::get('/resellers/export', [App\Http\Controllers\Admin\ResellerManagementController::class, 'export'])->name('resellers.export');

    // Withdrawal Management
    Route::get('/withdrawals', [App\Http\Controllers\Admin\ResellerManagementController::class, 'withdrawals'])->name('withdrawals.index');
    Route::post('/withdrawals/{withdrawal}/process', [App\Http\Controllers\Admin\ResellerManagementController::class, 'processWithdrawal'])->name('withdrawals.process');

    // Legacy routes for backward compatibility
    Route::get('/kelolaProduk', [App\Http\Controllers\Admin\ProdukController::class, 'index'])->name('kelolaProduk');
    Route::get('/tambahProduk', [App\Http\Controllers\Admin\ProdukController::class, 'create'])->name('tambahProduk');
    Route::get('/kategoriProduk', [App\Http\Controllers\Admin\KategoriProdukController::class, 'index'])->name('kategoriProduk');
    Route::post('/kategoriProduk', [App\Http\Controllers\Admin\KategoriProdukController::class, 'store'])->name('kategoriProduk.store');
    Route::delete('/kategoriProduk/{id}', [App\Http\Controllers\Admin\KategoriProdukController::class, 'destroy'])->name('kategoriProduk.destroy');

    // Route untuk edit struktur form akun (account_fields) produk/game
    Route::get('/produk/{product_id}/edit-account-fields', [App\Http\Controllers\Admin\ProdukController::class, 'editAccountFields'])->name('admin.account_fields.edit');
    Route::put('/produk/{product_id}/update-account-fields', [App\Http\Controllers\Admin\ProdukController::class, 'updateAccountFields'])->name('admin.account_fields.update');

    // Manual denom management
    Route::get('denom/manual', [App\Http\Controllers\Admin\DenomController::class, 'manualDenomForm'])->name('denom.manual');
    Route::post('denom/manual', [App\Http\Controllers\Admin\DenomController::class, 'storeManualDenom'])->name('denom.storeManual');
    
    // Import denom from Digiflazz
    Route::get('denom/import-digiflazz', [App\Http\Controllers\Admin\DenomController::class, 'importFromDigiflazz'])->name('denom.importDigiflazz');
    Route::get('/admin/denom/create', [\App\Http\Controllers\Admin\DenomController::class, 'create'])->name('admin.denom.create');
    Route::get('/denom/create', [\App\Http\Controllers\Admin\DenomController::class, 'create'])->name('denom.create');
    Route::post('/admin/denom/update-order', [App\Http\Controllers\Admin\DenomController::class, 'updateOrder'])->name('admin.denom.updateOrder');
    Route::post('/admin/denom', [App\Http\Controllers\Admin\DenomController::class, 'store'])->name('admin.denom.store');
    Route::delete('/admin/denom/{id}', [App\Http\Controllers\Admin\DenomController::class, 'destroy'])->name('admin.denom.destroy');
    Route::get('/admin/denom/{id}/edit', [App\Http\Controllers\Admin\DenomController::class, 'edit'])->name('admin.denom.edit');
    Route::put('/admin/denom/{id}', [App\Http\Controllers\Admin\DenomController::class, 'update'])->name('admin.denom.update');
});

// Route publik produk (pastikan didefinisikan setelah group admin)
Route::get('/produk/{product_id}', [App\Http\Controllers\ProdukController::class, 'showPublic'])->name('produk.public');

// Route untuk testing koneksi API Digiflazz
Route::get('/test-digiflazz', function () {
    $username = config('services.digiflazz.username');
    $apiKey = config('services.digiflazz.api_key');
    $baseUrl = config('services.digiflazz.base_url');
    $sign = md5($username . $apiKey . 'pricelist');

    $response = Http::post($baseUrl . '/price-list', [
        'cmd' => 'prepaid',
        'username' => $username,
        'sign' => $sign,
    ]);

    return $response->json();
});

Route::resource('admin/kategori-denom', App\Http\Controllers\Admin\KategoriDenomController::class)->names('admin.kategori-denom');
Route::post('/api/mlbb-nickname', [App\Http\Controllers\ProdukController::class, 'cekMLBBUsername']);
