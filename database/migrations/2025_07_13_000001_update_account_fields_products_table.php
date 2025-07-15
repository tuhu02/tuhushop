<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Produk yang hanya butuh Nomor HP
        DB::table('products')
            ->whereIn('product_name', [
                'Axis', 'By.u', 'Indosat', 'Telkomsel', 'Xl', 'Smartfren', 'Tri', 'PLN', 'Shopee Pay', 'Dana', 'Ovo', 'Go Pay', 'Pertamina Gas'
            ])
            ->update([
                'account_fields' => json_encode([
                    [
                        'label' => 'Nomor HP',
                        'name' => 'phone',
                        'type' => 'text',
                        'placeholder' => 'Masukkan nomor HP'
                    ]
                ])
            ]);

        // Produk game (User ID & Server)
        DB::table('products')
            ->whereIn('product_name', [
                'Mobile Legends', 'Free Fire', 'PUBG Mobile', 'Genshin Impact', 'Call of Duty Mobile'
            ])
            ->update([
                'account_fields' => json_encode([
                    [
                        'label' => 'User ID',
                        'name' => 'user_id',
                        'type' => 'text',
                        'placeholder' => 'Masukkan User ID'
                    ],
                    [
                        'label' => 'Server',
                        'name' => 'server',
                        'type' => 'text',
                        'placeholder' => 'Masukkan Server'
                    ]
                ])
            ]);

        // Produk voucher (Kode Voucher)
        DB::table('products')
            ->where('product_name', 'like', '%Voucher%')
            ->update([
                'account_fields' => json_encode([
                    [
                        'label' => 'Kode Voucher',
                        'name' => 'voucher_code',
                        'type' => 'text',
                        'placeholder' => 'Masukkan kode voucher'
                    ]
                ])
            ]);

        // Produk K-Vision, TV, dst (ID Pelanggan)
        DB::table('products')
            ->where('product_name', 'like', '%K-vision%')
            ->orWhere('category', 'TV')
            ->update([
                'account_fields' => json_encode([
                    [
                        'label' => 'ID Pelanggan',
                        'name' => 'customer_id',
                        'type' => 'text',
                        'placeholder' => 'Masukkan ID Pelanggan'
                    ]
                ])
            ]);
    }

    public function down()
    {
        // Rollback: kosongkan field account_fields
        DB::table('products')->update(['account_fields' => null]);
    }
}; 