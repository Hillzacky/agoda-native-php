<?php

class Logger
{
    public static function write($type, $message)
    {
        $line = date('Y-m-d H:i:s') . " [$type] " . $message . PHP_EOL;

        file_put_contents(
            __DIR__ . '/../storage.log',
            $line,
            FILE_APPEND
        );
    }
}