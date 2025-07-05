<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DigiflazzService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DigiflazzController extends Controller
{
    protected $digiflazzService;

    public function __construct(DigiflazzService $digiflazzService)
    {
        $this->digiflazzService = $digiflazzService;
    }

    /**
     * Show Digiflazz dashboard
     */
    public function index()
    {
        $connectionStatus = $this->digiflazzService->checkConnection();
        $priceList = Cache::remember('digiflazz_price_list', 300, function () {
            return $this->digiflazzService->getPriceList();
        });

        $categories = Cache::remember('digiflazz_categories', 300, function () {
            return $this->digiflazzService->getGameCategories();
        });

        return view('admin.digiflazz.index', compact('connectionStatus', 'priceList', 'categories'));
    }

    /**
     * Test API connection
     */
    public function testConnection()
    {
        $result = $this->digiflazzService->checkConnection();
        
        return response()->json($result);
    }

    /**
     * Sync games from Digiflazz
     */
    public function syncGames()
    {
        $result = $this->digiflazzService->syncGames();
        
        // Clear cache after sync
        Cache::forget('digiflazz_price_list');
        Cache::forget('digiflazz_categories');
        
        return response()->json($result);
    }

    /**
     * Get price list
     */
    public function getPriceList()
    {
        $priceList = $this->digiflazzService->getPriceList();
        
        return response()->json([
            'success' => true,
            'data' => $priceList,
            'count' => count($priceList)
        ]);
    }

    /**
     * Get categories
     */
    public function getCategories()
    {
        $categories = $this->digiflazzService->getGameCategories();
        
        return response()->json([
            'success' => true,
            'data' => $categories,
            'count' => count($categories)
        ]);
    }

    /**
     * Update API credentials
     */
    public function updateCredentials(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'api_key' => 'required|string',
        ]);

        // Update .env file (you might want to use a more secure way)
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);
        
        $envContent = preg_replace('/DIGIFLAZZ_USERNAME=.*/', 'DIGIFLAZZ_USERNAME=' . $request->username, $envContent);
        $envContent = preg_replace('/DIGIFLAZZ_API_KEY=.*/', 'DIGIFLAZZ_API_KEY=' . $request->api_key, $envContent);
        
        file_put_contents($envFile, $envContent);

        // Clear cache
        Cache::forget('digiflazz_price_list');
        Cache::forget('digiflazz_categories');

        return response()->json([
            'success' => true,
            'message' => 'API credentials updated successfully'
        ]);
    }
} 