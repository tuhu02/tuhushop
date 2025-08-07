<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DebugSignature extends Command
{
    protected $signature = 'debug:signature {ref_id}';
    protected $description = 'Debug signature generation for DigiFlazz';

    public function handle()
    {
        $refId = $this->argument('ref_id');
        
        $username = config('services.digiflazz.username');
        $apiKey = config('services.digiflazz.api_key');
        
        $this->info("=== Signature Debug ===");
        $this->info("Username: {$username}");
        $this->info("API Key: " . substr($apiKey, 0, 8) . '...');
        $this->info("Ref ID: {$refId}");
        
        // Generate signature
        $signature = md5($username . $apiKey . $refId);
        $this->info("Generated Signature: {$signature}");
        
        // Test with different formats
        $this->info("\n=== Alternative Signatures ===");
        $this->info("Username + API Key + Ref ID: " . md5($username . $apiKey . $refId));
        $this->info("API Key + Username + Ref ID: " . md5($apiKey . $username . $refId));
        $this->info("Ref ID + Username + API Key: " . md5($refId . $username . $apiKey));
        
        return 0;
    }
} 