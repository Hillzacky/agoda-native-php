<?php

spl_autoload_register(function ($class) {

    // Normalize class name to lowercase
    $class = ltrim($class, '\\');
    $file  = '';

    // Core classes
    if (file_exists(__DIR__ . "/core/{$class}.php")) {
        $file = __DIR__ . "/core/{$class}.php";
    }
    // Models
    elseif (file_exists(__DIR__ . "/models/{$class}.php")) {
        $file = __DIR__ . "/models/{$class}.php";
    }
    // Services
    elseif (file_exists(__DIR__ . "/services/{$class}.php")) {
        $file = __DIR__ . "/services/{$class}.php";
    }
    // Builders
    elseif (file_exists(__DIR__ . "/builders/{$class}.php")) {
        $file = __DIR__ . "/builders/{$class}.php";
    }
    // Engines
    elseif (file_exists(__DIR__ . "/engines/{$class}.php")) {
        $file = __DIR__ . "/engines/{$class}.php";
    }
    // Queue
    elseif (file_exists(__DIR__ . "/queue/{$class}.php")) {
        $file = __DIR__ . "/queue/{$class}.php";
    }

    // Include file if found
    if ($file && file_exists($file)) {
        require_once $file;
    }
});