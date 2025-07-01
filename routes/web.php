<?php   
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\cekTransaksiController;
use App\http\Controllers\kontakController;


// Route utama (dashboard pengguna)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/cekTransaksi', [cekTransaksiController::class, 'index'])->name('cekTransaksi');

Route::get('kontak',[kontakController::class , 'index'])->name('kontak');

// Route::get('/cekTransaksi',function(){
//     return view('cekTransaksi');
// });

// Route admin
Route::prefix('admin')->group(function () {
    Route::get('/', function(){
        return view('admin.dashboardAdmin');
    });

    Route::get('/kelolaProduk', function () {
        return view('admin.kelolaProduk');
    })->name('admin.kelolaProduk');

    Route::get('/tambahProduk', function () {
        return view('admin.tambahProduk');
    })->name('admin.tambahProduk');
});

Route::get('/produk/{game}', [ProdukController::class, 'show'])->name('produk.show');
