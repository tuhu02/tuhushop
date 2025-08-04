<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rute-rute di sini bersifat stateless dan secara otomatis akan
| memiliki prefix /api. Contoh: /api/midtrans/callback
|
*/

/**
 * Rute untuk menerima notifikasi pembayaran (webhook) dari Midtrans.
 * Ini adalah rute terpenting untuk proses otomatisasi pesanan.
 */
Route::post('/midtrans/callback', [WebhookController::class, 'handle'])->name('midtrans.callback');