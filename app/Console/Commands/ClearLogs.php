<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all log files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the path to the log files directory
        $logDirectory = storage_path('logs');

        // Get all log files from the directory
        $files = glob($logDirectory . '/*.log');

        // Delete each log file
        foreach ($files as $file) {
            unlink($file);
        }

        $this->info('Log files have been cleared!');
    }
}
