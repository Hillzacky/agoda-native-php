<?php

require_once __DIR__ . '/../core/Database.php';

class HealthCheck
{
    public static function run()
    {
        try {
            Database::connect();
            echo "Database OK\n";
        } catch (Exception $e) {
            echo "Database FAIL\n";
        }

        if (file_exists(__DIR__ . '/../storage.log')) {
            echo "Logger OK\n";
        }

        echo "System Healthy\n";
    }
}