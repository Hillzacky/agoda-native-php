<?php

class Env
{
    private static $vars = null;

    public static function load($path = __DIR__ . '/../.env')
    {
        if (!file_exists($path)) return;

        self::$vars = parse_ini_file($path, false, INI_SCANNER_RAW);
    }

    public static function get($key, $default = null)
    {
        return self::$vars[$key] ?? $default;
    }
}

// Load on startup
Env::load();