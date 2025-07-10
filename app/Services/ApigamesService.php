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

    // Test vendor-specific endpoints (after connecting vendors)
    public function testVendorEndpoints()
    {
        $results = [];
        
        // Test different vendor endpoints
        $vendors = ['kiosgamer', 'smileone', 'unipin', 'xendit'];
        
        foreach ($vendors as $vendor) {
            $url = $this->baseUrl . $this->merchantId . '/' . $vendor . '/project/detail';
            $response = Http::post($url, [
                'projectid' => 1,
                'signature' => $this->signature()
            ]);
            
            $results[] = [
                'vendor' => $vendor,
                'url' => $url,
                'status_code' => $response->status(),
                'response' => $response->json(),
                'accessible' => $response->status() == 200
            ];
        }
        
        return $results;
    }

    // Comprehensive test for voucher detail issues
    public function comprehensiveVoucherTest()
    {
        $results = [];
        $url = $this->baseUrl . $this->merchantId . '/kiosgamer/project/detail';
        
        // Test different Project ID formats and combinations
        $testCases = [
            [
                'name' => 'Empty Project ID',
                'data' => ['signature' => $this->signature()]
            ],
            [
                'name' => 'Project ID as string "1"',
                'data' => ['projectid' => '1', 'signature' => $this->signature()]
            ],
            [
                'name' => 'Project ID as integer 1',
                'data' => ['projectid' => 1, 'signature' => $this->signature()]
            ],
            [
                'name' => 'Project ID as string "FF"',
                'data' => ['projectid' => 'FF', 'signature' => $this->signature()]
            ],
            [
                'name' => 'Project ID as string "freefire"',
                'data' => ['projectid' => 'freefire', 'signature' => $this->signature()]
            ],
            [
                'name' => 'With merchant_id',
                'data' => ['projectid' => 1, 'merchant_id' => $this->merchantId, 'signature' => $this->signature()]
            ],
            [
                'name' => 'With game_code',
                'data' => ['projectid' => 1, 'game_code' => 'freefire', 'signature' => $this->signature()]
            ],
            [
                'name' => 'With vendor parameter',
                'data' => ['projectid' => 1, 'vendor' => 'kiosgamer', 'signature' => $this->signature()]
            ]
        ];
        
        foreach ($testCases as $testCase) {
            $response = Http::post($url, $testCase['data']);
            
            $results[] = [
                'test_name' => $testCase['name'],
                'data_sent' => $testCase['data'],
                'status_code' => $response->status(),
                'response' => $response->json(),
                'error_type' => isset($response->json()['error_msg']) ? $response->json()['error_msg'] : 'No error'
            ];
        }
        
        return $results;
    }

    // Test different API structures and base URLs
    public function testApiStructures()
    {
        $results = [];
        
        // Only test the working base URL with different approaches
        $baseUrl = 'https://v1.apigames.id/merchant/';
        $url = $baseUrl . $this->merchantId . '/kiosgamer/project/detail';
        
        // Test different request methods and formats
        $testCases = [
            [
                'name' => 'POST with form data',
                'method' => 'POST',
                'data' => [
                    'projectid' => 1,
                    'signature' => $this->signature()
                ]
            ],
            [
                'name' => 'POST with JSON',
                'method' => 'POST',
                'data' => json_encode([
                    'projectid' => 1,
                    'signature' => $this->signature()
                ]),
                'headers' => ['Content-Type' => 'application/json']
            ],
            [
                'name' => 'GET with query params',
                'method' => 'GET',
                'url' => $url . '?projectid=1&signature=' . $this->signature()
            ]
        ];
        
        foreach ($testCases as $testCase) {
            if ($testCase['method'] === 'GET') {
                $response = Http::get($testCase['url']);
            } else {
                if (isset($testCase['headers'])) {
                    $response = Http::withHeaders($testCase['headers'])->post($url, $testCase['data']);
                } else {
                    $response = Http::post($url, $testCase['data']);
                }
            }
            
            $results[] = [
                'test_name' => $testCase['name'],
                'url' => $testCase['url'] ?? $url,
                'method' => $testCase['method'],
                'status_code' => $response->status(),
                'response' => $response->json(),
                'works' => $response->status() == 200 && !isset($response->json()['error_msg'])
            ];
        }
        
        return $results;
    }

    // Check available endpoints and vendor connections
    public function checkAvailableEndpoints()
    {
        $results = [];
        
        // Test various possible endpoints with the same approach as getProjectList
        $endpoints = [
            '/project/list',
            '/kiosgamer/project/list',
            '/game/list',
            '/products/list',
            '/kiosgamer/project/detail',
            '/kiosgamer/voucher/list',
            '/kiosgamer/voucher/detail',
            '/kiosgamer/product/list',
            '/kiosgamer/product/detail',
            '/project/detail',
            '/voucher/list',
            '/voucher/detail',
            '/product/list',
            '/product/detail',
            '/game/detail',
            '/denom/list',
            '/denom/detail'
        ];
        
        foreach ($endpoints as $endpoint) {
            $url = $this->baseUrl . $this->merchantId . $endpoint;
            
            // Use the same approach as getProjectList (form data, not JSON)
            $response = Http::post($url, [
                'signature' => $this->signature()
            ]);
            
            $results[] = [
                'endpoint' => $endpoint,
                'url' => $url,
                'status_code' => $response->status(),
                'response' => $response->json(),
                'exists' => $response->status() != 404
            ];
        }
        
        return $results;
    }

    // Test different parameter combinations for voucher details
    public function testVoucherDetailParams($projectId)
    {
        $results = [];
        $url = $this->baseUrl . $this->merchantId . '/kiosgamer/project/detail';
        
        // Test different parameter names and formats
        $testCases = [
            [
                'name' => 'Basic JSON with projectid',
                'data' => json_encode([
                    'projectid' => $projectId,
                    'signature' => $this->signature()
                ])
            ],
            [
                'name' => 'Basic JSON with project_id',
                'data' => json_encode([
                    'project_id' => $projectId,
                    'signature' => $this->signature()
                ])
            ],
            [
                'name' => 'Basic JSON with id',
                'data' => json_encode([
                    'id' => $projectId,
                    'signature' => $this->signature()
                ])
            ],
            [
                'name' => 'String Project ID',
                'data' => json_encode([
                    'projectid' => (string)$projectId,
                    'signature' => $this->signature()
                ])
            ],
            [
                'name' => 'With merchant_id',
                'data' => json_encode([
                    'projectid' => $projectId,
                    'merchant_id' => $this->merchantId,
                    'signature' => $this->signature()
                ])
            ],
            [
                'name' => 'Form Data with projectid',
                'data' => [
                    'projectid' => $projectId,
                    'signature' => $this->signature()
                ],
                'is_form' => true
            ],
            [
                'name' => 'Form Data with project_id',
                'data' => [
                    'project_id' => $projectId,
                    'signature' => $this->signature()
                ],
                'is_form' => true
            ]
        ];
        
        foreach ($testCases as $testCase) {
            if (isset($testCase['is_form']) && $testCase['is_form']) {
                // Send as form data
                $response = Http::asForm()->post($url, $testCase['data']);
            } else {
                // Send as JSON
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])->withBody($testCase['data'], 'application/json')->post($url);
            }
            
            $results[] = [
                'test_name' => $testCase['name'],
                'data_sent' => $testCase['data'],
                'url' => $url,
                'status_code' => $response->status(),
                'response' => $response->json(),
                'success' => $response->successful() && !isset($response->json()['error_msg'])
            ];
        }
        
        return $results;
    }

    // Radeem Voucher Detail (POST)
    public function getVoucherDetail($projectId = '', $status = '', $page = 1, $limit = 30)
    {
        $url = $this->baseUrl . $this->merchantId . '/kiosgamer/project/detail';
        
        // Prepare the data in form format (same as project list)
        $data = [
            'projectid' => $projectId,
            'signature' => $this->signature(),
        ];
        
        // Add optional parameters if provided
        if ($status) {
            $data['status'] = $status;
        }
        if ($page) {
            $data['page'] = $page;
        }
        if ($limit) {
            $data['limit'] = $limit;
        }
        
        // Try form data first (same approach as project list)
        $response = Http::post($url, $data);
        
        // If form data fails, try JSON
        if (!$response->successful() || isset($response->json()['error_msg'])) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($url, $data);
        }
        
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

    // Test basic API connection
    public function testConnection()
    {
        $signature = $this->signature();
        $url = $this->baseUrl . $this->merchantId . "?signature={$signature}";
        $response = Http::get($url);
        
        return [
            'status' => $response->successful(),
            'response' => $response->json(),
            'debug' => [
                'url' => $url,
                'merchant_id' => $this->merchantId,
                'signature' => $signature,
                'response_status' => $response->status(),
                'response_body' => $response->body()
            ]
        ];
    }

    // Ambil daftar project/game
    public function getProjectList()
    {
        // Try different possible endpoints
        $endpoints = [
            '/project/list',
            '/kiosgamer/project/list',
            '/game/list',
            '/products/list'
        ];
        
        foreach ($endpoints as $endpoint) {
            $url = $this->baseUrl . $this->merchantId . $endpoint;
            $response = Http::post($url, [
                'signature' => $this->signature(),
            ]);
            
            // If we get a successful response, return it
            if ($response->successful()) {
                return $response->json();
            }
        }
        
        // If all endpoints fail, return error with debug info
        return [
            'status' => 0,
            'rc' => 404,
            'error_msg' => 'All project list endpoints failed. Check API documentation.',
            'debug' => [
                'merchant_id' => $this->merchantId,
                'base_url' => $this->baseUrl,
                'signature' => $this->signature(),
                'tested_endpoints' => $endpoints
            ]
        ];
    }
} 