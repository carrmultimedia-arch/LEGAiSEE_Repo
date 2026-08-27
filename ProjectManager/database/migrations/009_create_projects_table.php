<?php

declare(strict_types=1);

use App\Database\Connection;

$pdo = Connection::get();

$sql = "
CREATE TABLE IF NOT EXISTS projects (

    id INT AUTO_INCREMENT PRIMARY KEY,

    uuid VARCHAR(36) NOT NULL UNIQUE,

    name VARCHAR(255) NOT NULL,

    description TEXT NOT NULL,

    status VARCHAR(50) NOT NULL DEFAULT 'active',

    color VARCHAR(20) NOT NULL DEFAULT '#2563eb',

    owner_id INT NOT NULL,

    start_date DATE NULL,

    due_date DATE NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_projects_owner_id (owner_id),

    INDEX idx_projects_status (status),

    CONSTRAINT fk_projects_owner
        FOREIGN KEY (owner_id)
        REFERENCES users(id)
        ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

$pdo->exec($sql);
