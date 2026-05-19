<?php
/**
 * =========================================================
 * COMMANDCENTER SYSTEM HEALTH ENGINE
 * =========================================================
 *
 * PURPOSE:
 * Provides deterministic runtime diagnostics for:
 * - DB integrity
 * - Module registry validity
 * - File system consistency
 * - Graph data integrity
 *
 * This is READ-ONLY diagnostics.
 * It does NOT modify system state.
 * =========================================================
 */

require_once __DIR__ . '/kernel_boot.php';

$pdo = kernel_db();

/* --------------------------
   RESULT CONTAINER
--------------------------- */
$report = [
    "kernel" => [],
    "database" => [],
    "modules" => [],
    "files" => [],
    "graph" => [],
];

/* =========================================================
   1. KERNEL CHECK
========================================================= */
$report["kernel"] = [
    "booted" => defined('COMMANDCENTER_BOOTSTRAPPED'),
    "db_mode" => defined('DB_AUTHORITY') ? DB_AUTHORITY : "unknown",
    "system_mode" => defined('SYSTEM_MODE') ? SYSTEM_MODE : "unknown",
];

/* =========================================================
   2. DATABASE CHECK
========================================================= */
try {

    $tables = [];

    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
    $sqliteTables = $stmt ? $stmt->fetchAll(PDO::FETCH_COLUMN) : [];

    $stmt = $pdo->query("SHOW TABLES");
    $mysqlTables = $stmt ? $stmt->fetchAll(PDO::FETCH_COLUMN) : [];

    $tables = array_merge($sqliteTables ?: [], $mysqlTables ?: []);

    $required = ['page', 'page_content', 'clusters', 'page_relations'];

    $missing = [];

    foreach ($required as $t) {
        if (!in_array($t, $tables)) {
            $missing[] = $t;
        }
    }

    $report["database"] = [
        "tables_found" => $tables,
        "missing_tables" => $missing,
        "status" => empty($missing) ? "OK" : "FAIL"
    ];

} catch (Throwable $e) {
    $report["database"] = [
        "status" => "ERROR",
        "message" => $e->getMessage()
    ];
}

/* =========================================================
   3. MODULE REGISTRY CHECK
========================================================= */
try {

    $registry = require __DIR__ . "/module_registry.php";

    $modulePath = __DIR__ . "/../modules/";
    $filesystemModules = array_diff(scandir($modulePath), ['.', '..']);

    $registeredFiles = array_column($registry, 'file');

    $missingFiles = [];
    $orphanFiles = [];

    foreach ($registeredFiles as $file) {
        if (!file_exists($modulePath . $file)) {
            $missingFiles[] = $file;
        }
    }

    foreach ($filesystemModules as $file) {
        if (!in_array($file, $registeredFiles)) {
            $orphanFiles[] = $file;
        }
    }

    $report["modules"] = [
        "registered" => count($registry),
        "missing_files" => $missingFiles,
        "orphan_files" => $orphanFiles,
        "status" => (empty($missingFiles) && empty($orphanFiles)) ? "OK" : "DEGRADED"
    ];

} catch (Throwable $e) {
    $report["modules"] = [
        "status" => "ERROR",
        "message" => $e->getMessage()
    ];
}

/* =========================================================
   4. FILE SYSTEM CHECK (NORMALIZED + DATA LAYERS)
========================================================= */
try {

    $base = realpath(__DIR__ . "/../");

    $paths = [
        "normalized" => $base . "/normalized/",
        "data" => $base . "/data/"
    ];

    $results = [];

    foreach ($paths as $label => $path) {

        if (!is_dir($path)) {
            $results[$label] = "MISSING";
            continue;
        }

        $files = scandir($path);
        $results[$label] = count($files);
    }

    $report["files"] = [
        "directories" => $results,
        "status" => "OK"
    ];

} catch (Throwable $e) {
    $report["files"] = [
        "status" => "ERROR",
        "message" => $e->getMessage()
    ];
}

/* =========================================================
   5. GRAPH INTEGRITY CHECK
========================================================= */
try {

    $nodes = $pdo->query("SELECT COUNT(*) FROM page")->fetchColumn();
    $edges = $pdo->query("SELECT COUNT(*) FROM page_relations")->fetchColumn();

    $report["graph"] = [
        "nodes" => (int)$nodes,
        "edges" => (int)$edges,
        "status" => ($nodes > 0) ? "OK" : "EMPTY"
    ];

} catch (Throwable $e) {
    $report["graph"] = [
        "status" => "ERROR",
        "message" => $e->getMessage()
    ];
}

/* =========================================================
   OUTPUT
========================================================= */
header("Content-Type: application/json");

echo json_encode($report, JSON_PRETTY_PRINT);