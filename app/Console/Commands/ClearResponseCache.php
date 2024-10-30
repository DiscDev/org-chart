<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearResponseCache extends Command
{
    protected $signature = 'cache:clear-responses';
    protected $description = 'Clear all cached responses';

    public function handle()
    {
        Cache::tags(['responses', 'api_responses'])->flush();
        $this->info('Response cache cleared successfully.');
    }
}