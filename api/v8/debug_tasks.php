<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db.php';

$res = $conn->query("SELECT * FROM tasks ORDER BY id DESC LIMIT 20");

$data = [];

while($row = $res->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);