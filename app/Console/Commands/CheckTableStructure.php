<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CheckTableStructure extends Command
{
    protected $signature = 'table:structure {table}';
    protected $description = 'Check table structure';

    public function handle()
    {
        $table = $this->argument('table');
        
        $this->info('Checking structure for table: ' . $table);
        
        $columns = Schema::getColumnListing($table);
        
        if (empty($columns)) {
            $this->error('Table not found or no columns!');
            return 1;
        }
        
        $this->info('Columns in ' . $table . ':');
        foreach ($columns as $column) {
            $this->line('- ' . $column);
        }
        
        return 0;
    }
}
