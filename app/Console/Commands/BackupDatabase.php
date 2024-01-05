<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description for the mecom project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbName = 'mecom'; 
        $username = 'root'; 
        $password = ''; 

        $backupPath = 'backups/mecom'; 
        $backupFilename = 'backup_' . date('Y-m-d_His') . '.sql';

        // Ensure the 'backups/mecom' directory exists within the 'storage/app' directory
        if (!Storage::exists($backupPath)) {
            Storage::makeDirectory($backupPath);
        }
        $command = "mysqldump --user={$username} --password={$password} {$dbName} > " . storage_path("app/{$backupPath}/{$backupFilename}");
    
        // Capture the output and any errors
        $output = [];
        $return_var = 0;
        exec($command, $output, $return_var);

         // Check for any errors in the return status
        if ($return_var !== 0) {
            $this->error("Error occurred while creating the database backup");
            foreach ($output as $line) {
                $this->line($line);
            }
        } else {
            $this->info("Database backup created for mecom project: {$backupFilename}");
        }
    }
}

