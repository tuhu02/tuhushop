<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DigiflazzService;

class TestDigiflazzConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'digiflazz:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Digiflazz API connection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Digiflazz API connection...');
        
        $service = new DigiflazzService();
        $result = $service->checkConnection();
        
        $this->info('Connection Result:');
        $this->table(['Key', 'Value'], [
            ['Success', $result['success'] ? 'Yes' : 'No'],
            ['Status Code', $result['status_code']],
            ['Message', $result['message']],
        ]);
        
        if (!$result['success']) {
            $this->error('Failed to connect to Digiflazz API');
            return 1;
        }
        
        $this->info('✅ Digiflazz API connection successful!');
        return 0;
    }
} 