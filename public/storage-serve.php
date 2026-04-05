<?php
/**
 * Image serving script for InfinityFree hosting
 * Serves images from storage/app/public without relying on symlinks
 * 
 * Usage: /storage/path/to/image.jpg
 * This file is placed at: public/storage-serve.php
 */

// Security: only allow image files
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico'];

// Get the requested file path from the URL
$requestPath = $_GET['file'] ?? '';

// Strip any dangerous characters
$requestPath = ltrim($requestPath, '/.');
$requestPath = str_replace(['..', '\\'], '', $requestPath);

if (empty($requestPath)) {
    http_response_code(400);
    exit('Bad Request');
}

// Check extension
$ext = strtolower(pathinfo($requestPath, PATHINFO_EXTENSION));
if (!in_array($ext, $allowedExtensions)) {
    http_response_code(403);
    exit('Forbidden');
}

// Build the real path to the file
$basePath = dirname(__DIR__) . '/storage/app/public/';
$filePath = realpath($basePath . $requestPath);

// Make sure the resolved path is still within our storage directory
$basePathReal = realpath($basePath);
if (!$filePath || !$basePathReal || strpos($filePath, $basePathReal) !== 0) {
    http_response_code(404);
    exit('Not Found');
}

if (!file_exists($filePath)) {
    http_response_code(404);
    exit('Not Found');
}

// Set proper content type
$mimeTypes = [
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
    'gif'  => 'image/gif',
    'webp' => 'image/webp',
    'svg'  => 'image/svg+xml',
    'ico'  => 'image/x-icon',
];

$mimeType = $mimeTypes[$ext] ?? 'application/octet-stream';

// Cache headers - cache images for 7 days
header('Content-Type: ' . $mimeType);
header('Cache-Control: public, max-age=604800, immutable');
header('Content-Length: ' . filesize($filePath));
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($filePath)) . ' GMT');

// Check for conditional request (browser cache)
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    $ifModifiedSince = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
    if (filemtime($filePath) <= $ifModifiedSince) {
        http_response_code(304);
        exit;
    }
}

readfile($filePath);
exit;
