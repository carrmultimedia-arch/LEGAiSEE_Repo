<?php

require_once __DIR__ . '/../db.php';

/**
 * GOD MODE v1 - SYSTEM INDEX BUILDER
 * Scans core folders and builds unified navigation registry
 */

function scan_dir_recursive($dir, $base = '') {
    $items = [];

    if (!is_dir($dir)) return $items;

    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $path = $dir . '/' . $file;
        $relative = $base . '/' . $file;

        if (is_dir($path)) {
            $items[] = [
                'type' => 'folder',
                'name' => $file,
                'path' => trim($relative, '/'),
                'children' => scan_dir_recursive($path, trim($relative, '/'))
            ];
        } else {
            $items[] = [
                'type' => 'file',
                'name' => $file,
                'path' => trim($relative, '/')
            ];
        }
    }

    return $items;
}

function build_system_index() {

    $root = realpath(__DIR__ . '/..');

    $index = [
        'modules' => scan_dir_recursive($root . '/modules', 'modules'),
        'engine'  => scan_dir_recursive($root . '/engine', 'engine'),
        'kernel'  => scan_dir_recursive($root . '/kernel', 'kernel'),
        'api'     => scan_dir_recursive($root . '/api', 'api'),
        'pages'   => scan_dir_recursive($root . '/pages', 'pages'),
        'data'    => scan_dir_recursive($root . '/data', 'data')
    ];

   $cache_file = __DIR__ . '/system_index_cache.json';
    
    file_put_contents(
    $cache_file,
    json_encode($index, JSON_PRETTY_PRINT)
);
    return $index;
}

if (php_sapi_name() !== 'cli') {
    header('Content-Type: application/json');
    echo json_encode(build_system_index());
}