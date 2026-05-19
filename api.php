<?php

header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

require_once __DIR__ . '/db.php';

$action = $_GET['action'] ?? '';
$case_id = isset($_POST['case_id']) ? intval($_POST['case_id']) : 0;
$content = $_POST['content'] ?? null;

/*
========================================
RESPONSE CONTRACT
========================================
*/
function respond($status, $data = [], $message = null){
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

/*
========================================
LEGACY WRAPPER FUNCTION
========================================
*/
function legacy($file, $post = []){
    $_POST = array_merge($_POST, $post);
    ob_start();
    include __DIR__ . "/api/v8/" . $file;
    $output = ob_get_clean();

    $json = json_decode($output, true);

    if ($json === null) {
        return [
            "status" => "error",
            "raw" => $output,
            "message" => "Invalid legacy JSON"
        ];
    }

    return $json;
}

/*
========================================
ROUTES (MIGRATED)
========================================
*/

switch($action){

    case "build_graph":
        $result = legacy("build_graph.php", ["case_id"=>$case_id]);
        respond($result["status"] ?? "ok", $result, "Graph executed");
        break;

    case "clusters":
        $result = legacy("cluster_insights.php", ["case_id"=>$case_id]);
        respond($result["status"] ?? "ok", $result, "Clusters generated");
        break;

    case "insights":
        $result = legacy("insights_generate.php", ["case_id"=>$case_id]);
        respond($result["status"] ?? "ok", $result, "Insights generated");
        break;

    case "recommendations":
        $result = legacy("recommendations_generate.php", ["case_id"=>$case_id]);
        respond($result["status"] ?? "ok", $result, "Recommendations generated");
        break;

    case "tasks":
        $result = legacy("generate_tasks.php", ["case_id"=>$case_id]);
        respond($result["status"] ?? "ok", $result, "Tasks generated");
        break;

    case "ingest":

        if(!$content){
            respond("error", [], "Missing content");
        }

        $result = legacy("network_add_node.php", [
            "network_id" => "net_case_" . $case_id,
            "content" => $content
        ]);

        respond($result["status"] ?? "ok", $result, "Ingest successful");
        break;

case "enqueue_task":

    $task_type = $_POST['task_type'] ?? null;
    $case_id = isset($_POST['case_id']) ? intval($_POST['case_id']) : 0;

    if(!$task_type || !$case_id){
        respond("error", [], "Missing task_type or case_id");
    }

    $stmt = $conn->prepare("
        INSERT INTO processing_queue (case_id, task_type, status)
        VALUES (?, ?, 'pending')
    ");

    $stmt->bind_param("is", $case_id, $task_type);
    $stmt->execute();

    respond("ok", [
        "queued" => true,
        "task_type" => $task_type
    ], "Task queued");

break;

    default:
        respond("error", [], "Invalid action");
}