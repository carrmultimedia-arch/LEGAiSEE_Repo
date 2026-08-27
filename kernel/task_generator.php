<?php

require_once __DIR__ . '/recommendation_engine.php';
require_once __DIR__ . '/../db.php';

function createTasksFromRecommendations($case_id, $network_file, $conn) {

    $recommendations = generateRecommendations($network_file);

    foreach ($recommendations as $rec) {

        foreach ($rec['actions'] as $action) {

            $stmt = $conn->prepare("
                INSERT INTO tasks (case_id, action, priority, status, created_at)
                VALUES (?, ?, ?, 'pending', NOW())
            ");

            $stmt->bind_param(
                "iss",
                $case_id,
                $action['action'],
                $action['priority']
            );

            $stmt->execute();

            // Add to processing queue
            $task_id = $pdo->lastInsertId();

            $conn->query("
                INSERT INTO processing_queue (task_id, status, created_at)
                VALUES ($task_id, 'queued', NOW())
            ");
        }
    }

    return true;
}