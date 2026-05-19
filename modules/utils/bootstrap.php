<?php

if (!function_exists('load_json_dir')) {

    function load_json_dir($dir) {

        if (!is_dir($dir)) {
            return [];
        }

        $files = scandir($dir);

        if (!$files) return [];

        $out = [];

        foreach ($files as $f) {

            if (pathinfo($f, PATHINFO_EXTENSION) !== 'json') continue;

            $path = $dir . '/' . $f;

            $json = file_get_contents($path);

            $data = json_decode($json, true);

            if (is_array($data)) {
                $out[] = $data;
            }
        }

        return $out;
    }
}