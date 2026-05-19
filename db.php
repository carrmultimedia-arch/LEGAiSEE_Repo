<?php

try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/legaisee.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("DB ERROR: " . $e->getMessage());
}