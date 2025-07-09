<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApigamesService
{
    protected $merchantId;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->merchantId = config('services.apigames.merchant_id');
        $this->secretKey = config('services.apigames.secret_key');
        $this->baseUrl = 'https://v1.apigames.id/merchant/';
    }

    protected function signature()
    {
        return md5($this->merchantId . $this->secretKey);
    }

    // Radeem Voucher Detail (POST)
    public function getVoucherDetail($projectId = '', $status = '', $page = 1, $limit = 30)
    {
        $url = $this->baseUrl . $this->merchantId . '/kiosgamer/project/detail';
        $response = Http::post($url, [
            'projectid' => $projectId,
            'status' => $status,
            'page' => $page,
            'limit' => $limit,
            'signature' => $this->signature(),
        ]);
        return $response->json();
    }

    // Cek akun game (GET)
    public function cekAkunGame($gameCode, $userId)
    {
        $signature = $this->signature();
        $url = $this->baseUrl . $this->merchantId . "/cek-username/{$gameCode}?user_id={$userId}&signature={$signature}";
        $response = Http::get($url);
        return $response->json();
    }

    // Info akun (GET)
    public function infoAkun()
    {
        $signature = $this->signature();
        $url = $this->baseUrl . $this->merchantId . "?signature={$signature}";
        $response = Http::get($url);
        return $response->json();
    }
} 