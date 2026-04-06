<?php
// InfinityFree Storage Debug Script
// Upload to: /htdocs/public/storage-debug.php
// Visit: https://royalcreationsbd.com/storage-debug.php

$basePath = dirname(__DIR__) . '/storage/app/public/';
$basePathReal = realpath($basePath);

echo "<pre style='font-family:monospace;font-size:13px;padding:20px;background:#1e1e1e;color:#d4d4d4;'>";
echo "=== InfinityFree Storage Debug ===\n\n";

echo "1. script location: " . __FILE__ . "\n";
echo "2. dirname(__DIR__): " . dirname(__DIR__) . "\n";
echo "3. basePath (built): " . $basePath . "\n";
echo "4. basePath realpath: " . ($basePathReal ?: 'FAILED - directory not found') . "\n\n";

echo "5. storage/app/public exists? " . (is_dir($basePath) ? 'YES' : 'NO') . "\n";
echo "6. public/storage symlink exists? " . (file_exists(__DIR__ . '/storage') ? 'YES' : 'NO') . "\n";
echo "7. public/storage is symlink? " . (is_link(__DIR__ . '/storage') ? 'YES' : 'NO') . "\n\n";

// List files in storage/app/public
if (is_dir($basePath)) {
    $files = scandir($basePath);
    echo "8. Files in storage/app/public:\n";
    foreach (array_slice($files, 0, 20) as $f) {
        if ($f !== '.' && $f !== '..') {
            echo "   - $f\n";
        }
    }
} else {
    echo "8. Cannot list files - directory not found\n";
    
    // Try alternative paths
    $altPaths = [
        '/htdocs/storage/app/public/',
        dirname(dirname(__FILE__)) . '/storage/app/public/',
        $_SERVER['DOCUMENT_ROOT'] . '/../storage/app/public/',
    ];
    echo "\n   Trying alternative paths:\n";
    foreach ($altPaths as $alt) {
        echo "   " . $alt . " -> " . (is_dir($alt) ? 'EXISTS' : 'not found') . "\n";
    }
}

echo "\n9. PHP version: " . phpversion() . "\n";
echo "10. DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'not set') . "\n";
echo "11. SCRIPT_FILENAME: " . ($_SERVER['SCRIPT_FILENAME'] ?? 'not set') . "\n";

echo "\n=== End Debug ===\n";
echo "</pre>";
