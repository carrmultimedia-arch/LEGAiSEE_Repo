<?php

header('Content-Type: application/json');

$registry = require __DIR__ . '/kernel/module_registry.php';

$module = $_GET['module'] ?? null;

if (!$module || !isset($registry[$module])) {
    echo json_encode([
        'error' => 'Invalid module',
        'module' => $module
    ]);
    exit;
}

$file = __DIR__ . '/modules/' . $registry[$module];

if (!file_exists($file)) {
    echo json_encode([
        'error' => 'Missing module file',
        'file' => $file
    ]);
    exit;
}

try {

    $data = require $file;

    if (!is_array($data)) {
        throw new Exception('Module must return array');
    }

    if (!isset($data['items'])) {
        $data['items'] = [];
    }

    // enforce JSON string content
    foreach ($data['items'] as &$item) {
        if (is_array($item['content'])) {
            $item['content'] = json_encode($item['content'], JSON_PRETTY_PRINT);
        }
    }

    echo json_encode($data, JSON_PRETTY_PRINT);

} catch (Throwable $e) {

    echo json_encode([
        'title' => 'Module Failure',
        'type'  => 'error',
        'items' => [
            [
                'title' => 'Error',
                'meta'  => 'Runtime',
                'content' => json_encode([
                    'message' => $e->getMessage(),
                    'file'    => $e->getFile(),
                    'line'    => $e->getLine()
                ], JSON_PRETTY_PRINT)
            ]
        ]
    ]);
}