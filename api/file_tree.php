<?php

$base = realpath(__DIR__ . "/../normalized/");

function scanDirRecursive($dir) {
    $result = [];

    $items = scandir($dir);

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $dir . '/' . $item;

        if (is_dir($path)) {
            $result[] = [
                "type" => "folder",
                "name" => $item,
                "children" => scanDirRecursive($path)
            ];
        } else {
            $result[] = [
                "type" => "file",
                "name" => $item,
                "path" => $path
            ];
        }
    }

    return $result;
}

echo json_encode(scanDirRecursive($base));