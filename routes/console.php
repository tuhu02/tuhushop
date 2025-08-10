<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule untuk memantau dan mengupdate status transaksi pending
Schedule::command('transaction:update-status')
    ->everyFiveMinutes()
    ->withoutOverlapping()
    ->runInBackground();
