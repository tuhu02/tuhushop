<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDigiflazzKey extends Command
{
    protected $signature = 'update:digiflazz-key {key}';
    protected $description = 'Update DigiFlazz API key in .env file';

    public function handle()
    {
        $newKey = $this->argument('key');
        
        // Read .env file
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        
        // Update DIGIFLAZZ_API_KEY
        $pattern = '/DIGIFLAZZ_API_KEY=.*/';
        $replacement = "DIGIFLAZZ_API_KEY={$newKey}";
        
        if (preg_match($pattern, $envContent)) {
            $envContent = preg_replace($pattern, $replacement, $envContent);
            file_put_contents($envPath, $envContent);
            
            $this->info("✅ API Key updated successfully!");
            $this->info("New Key: " . substr($newKey, 0, 8) . '...');
            
            // Clear config cache
            $this->call('config:clear');
            $this->info("✅ Config cache cleared!");
            
        } else {
            $this->error("❌ DIGIFLAZZ_API_KEY not found in .env file!");
        }
        
        return 0;
    }
} 