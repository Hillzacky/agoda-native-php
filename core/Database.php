<?php

class Database
{
    private static $instance = null;

    public static function connect()
    {
        if (self::$instance === null) {

            $config = require __DIR__ . '/../config.php';
            $db = $config['database'];

            self::$instance = new PDO(
                "mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4",
                $db['user'],
                $db['pass']
            );

            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}