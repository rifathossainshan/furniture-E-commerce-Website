<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Laravel - A PHP Framework For Web Artisans
 * 
 * This file is created specifically for shared hosting (like InfinityFree) 
 * which strictly requires an index.php at the root level.
 */

// If the request is not for the root, and we are running PHP built-in server, let it pass
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . '/public' . $_SERVER['REQUEST_URI']);
    if ($path !== false && file_exists($path) && !is_dir($path)) {
        return false;
    }
}

// Otherwise, forward all requests to the actual Laravel public entry point
require_once __DIR__ . '/public/index.php';
