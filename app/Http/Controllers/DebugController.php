<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DebugController extends Controller
{
    public function debugApigames()
    {
        $merchantId = config('services.apigames.merchant_id');
        $secretKey = config('services.apigames.secret_key');
        $signature = md5($merchantId . $secretKey);

        $url = "https://v1.apigames.id/merchant/{$merchantId}/kiosgamer/project/detail";

        $body = [
            "projectid" => "",
            "status" => "",
            "page" => 1,
            "limit" => 30,
            "signature" => $signature,
        ];

        $response = Http::post($url, $body);

        dd([
            'url' => $url,
            'body' => $body,
            'http_code' => $response->status(),
            'response' => $response->json(),
            'raw' => $response->body(),
        ]);
    }
} 