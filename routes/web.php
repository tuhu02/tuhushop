<?php   
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\cekTransaksiController;
use App\http\Controllers\kontakController;
use App\Http\Controllers\AuthController;


// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
Route::prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/kelolaProduk', function () {
        return view('admin.kelolaProduk');
    })->name('admin.kelolaProduk');

    Route::get('/tambahProduk', function () {
        return view('admin.tambahProduk');
    })->name('admin.tambahProduk');

    Route::get('/transactions', function () {
        return view('admin.kelolaTransaksi');
    })->name('admin.transactions');

    // Digiflazz API Management
    Route::get('/digiflazz', [App\Http\Controllers\Admin\DigiflazzController::class, 'index'])->name('admin.digiflazz');
    Route::post('/digiflazz/test-connection', [App\Http\Controllers\Admin\DigiflazzController::class, 'testConnection'])->name('admin.digiflazz.test');
    Route::post('/digiflazz/sync-games', [App\Http\Controllers\Admin\DigiflazzController::class, 'syncGames'])->name('admin.digiflazz.sync');
    Route::post('/digiflazz/update-credentials', [App\Http\Controllers\Admin\DigiflazzController::class, 'updateCredentials'])->name('admin.digiflazz.credentials');
    Route::get('/digiflazz/price-list', [App\Http\Controllers\Admin\DigiflazzController::class, 'getPriceList'])->name('admin.digiflazz.pricelist');
    Route::get('/digiflazz/categories', [App\Http\Controllers\Admin\DigiflazzController::class, 'getCategories'])->name('admin.digiflazz.categories');

    // Reseller Management
    Route::get('/resellers', [App\Http\Controllers\Admin\ResellerManagementController::class, 'index'])->name('admin.resellers');
    Route::get('/resellers/list', [App\Http\Controllers\Admin\ResellerManagementController::class, 'resellers'])->name('admin.resellers.list');
    Route::get('/resellers/{reseller}', [App\Http\Controllers\Admin\ResellerManagementController::class, 'show'])->name('admin.resellers.show');
    Route::post('/resellers/{reseller}/approve', [App\Http\Controllers\Admin\ResellerManagementController::class, 'approve'])->name('admin.resellers.approve');
    Route::post('/resellers/{reseller}/reject', [App\Http\Controllers\Admin\ResellerManagementController::class, 'reject'])->name('admin.resellers.reject');
    Route::post('/resellers/{reseller}/suspend', [App\Http\Controllers\Admin\ResellerManagementController::class, 'suspend'])->name('admin.resellers.suspend');
    Route::post('/resellers/{reseller}/activate', [App\Http\Controllers\Admin\ResellerManagementController::class, 'activate'])->name('admin.resellers.activate');
    Route::put('/resellers/{reseller}/commission', [App\Http\Controllers\Admin\ResellerManagementController::class, 'updateCommission'])->name('admin.resellers.commission');
    Route::get('/resellers/statistics', [App\Http\Controllers\Admin\ResellerManagementController::class, 'statistics'])->name('admin.resellers.statistics');
    Route::get('/resellers/export', [App\Http\Controllers\Admin\ResellerManagementController::class, 'export'])->name('admin.resellers.export');

    // Withdrawal Management
    Route::get('/withdrawals', [App\Http\Controllers\Admin\ResellerManagementController::class, 'withdrawals'])->name('admin.withdrawals');
    Route::post('/withdrawals/{withdrawal}/process', [App\Http\Controllers\Admin\ResellerManagementController::class, 'processWithdrawal'])->name('admin.withdrawals.process');
});

Route::get('/produk/{game}', [ProdukController::class, 'show'])->name('produk.show');
