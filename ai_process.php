<?php
require_once __DIR__ . '/kernel/db.php';
require_once __DIR__ . '/api/prompts.php';

$pdo = kernel_db();

$stmt = $pdo->query("SELECT * FROM processing_queue WHERE status='pending' LIMIT 1");
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) exit;

$case_id = $job['case_id'];
$task = $job['task_type'];

$stmt = $pdo->prepare("SELECT * FROM raw_data WHERE case_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$case_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$input = ($data['website_history'] ?? '') . "\n" . ($data['reviews'] ?? '') . "\n" . ($data['social'] ?? '');

$prompt = getPrompt($task, $input);

// CALL YOUR EXISTING AIs LAYER
$output = process_ai($prompt); // <- this should already exist in your system

// STORE TASK OUTPUT
$stmt = $pdo->prepare("INSERT INTO tasks (case_id, task_type, output_data) VALUES (?, ?, ?)");
$stmt->execute([$case_id, $task, $output]);

// MARK COMPLETE
$pdo->exec("UPDATE processing_queue SET status='done' WHERE id=" . intval($job['id']));