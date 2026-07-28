<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;
use Exception;

class SetupDatabaseCommand extends Command
{
    protected $signature = 'app:setup-db';
    protected $description = 'Automatically create the local MySQL database if missing and execute fresh migrations with seeders.';

    public function handle(): int
    {
        $this->info('Initializing local MySQL database environment for Daily AI World...');

        $host = config('database.connections.mysql.host', '127.0.0.1');
        $port = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database', 'daily_ai_world');
        $username = config('database.connections.mysql.username', 'root');
        $password = config('database.connections.mysql.password', '');

        try {
            // Attempt root PDO connection to MySQL server without database specified
            $pdo = new PDO("mysql:host={$host};port={$port}", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $this->info("MySQL Database `{$dbName}` verified/created successfully.");
        } catch (Exception $e) {
            $this->warn("MySQL direct connection check: " . $e->getMessage());
        }

        $this->info('Running database migrations and editorial seeders...');
        $this->call('migrate:fresh', ['--seed' => true]);

        $this->info('Database initialization complete! Ready for local development.');
        return Command::SUCCESS;
    }
}
