<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Digiflazz API...\n";

$username = config('services.digiflazz.username');
$apiKey = config('services.digiflazz.api_key');
$sign = md5($username . $apiKey . 'pricelist');

echo "Username: " . $username . "\n";
echo "API Key: " . substr($apiKey, 0, 10) . "...\n";
echo "Sign: " . $sign . "\n";

$response = Http::post('https://api.digiflazz.com/v1/price-list', [
    'cmd' => 'prepaid',
    'username' => $username,
    'sign' => $sign,
]);

if ($response->successful()) {
    $data = $response->json('data');
    if ($data) {
        echo "Total items from Digiflazz: " . count($data) . "\n\n";
        
        // Find FREE FIRE items
        $freefireItems = collect($data)->filter(function($item) {
            return stripos($item['brand'] ?? '', 'FREE FIRE') !== false || 
                   stripos($item['category'] ?? '', 'FREE FIRE') !== false || 
                   stripos($item['product_name'] ?? '', 'FREE FIRE') !== false ||
                   stripos($item['name'] ?? '', 'FREE FIRE') !== false;
        });
        
        echo "Found " . $freefireItems->count() . " FREE FIRE items:\n\n";
        
        foreach ($freefireItems as $item) {
            echo "Brand: " . ($item['brand'] ?? 'N/A') . "\n";
            echo "Category: " . ($item['category'] ?? 'N/A') . "\n";
            echo "Product Name: " . ($item['product_name'] ?? 'N/A') . "\n";
            echo "Name: " . ($item['name'] ?? 'N/A') . "\n";
            echo "Desc: " . ($item['desc'] ?? 'N/A') . "\n";
            echo "Price: " . ($item['price'] ?? 'N/A') . "\n";
            echo "Buyer SKU Code: " . ($item['buyer_sku_code'] ?? 'N/A') . "\n";
            echo "---\n";
        }
        
        // Show all items for debugging
        echo "\nAll items from Digiflazz (first 20):\n";
        foreach (array_slice($data, 0, 20) as $item) {
            echo "Brand: " . ($item['brand'] ?? 'N/A') . " | ";
            echo "Product: " . ($item['product_name'] ?? $item['name'] ?? 'N/A') . " | ";
            echo "Price: " . ($item['price'] ?? 'N/A') . " | ";
            echo "SKU: " . ($item['buyer_sku_code'] ?? 'N/A') . "\n";
        }
        
    } else {
        echo "No data found in response\n";
        echo "Response: " . $response->body() . "\n";
    }
} else {
    echo "API call failed: " . $response->status() . "\n";
    echo "Response: " . $response->body() . "\n";
} 