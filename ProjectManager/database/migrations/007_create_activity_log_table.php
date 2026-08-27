<?php

declare(strict_types=1);

use App\Database\Connection;

$db = Connection::get();

$db->exec("
CREATE TABLE IF NOT EXISTS activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(191) NOT NULL,
    entity_type VARCHAR(100) NOT NULL,
    entity_id INT NULL,
    details TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_activity_entity(entity_type, entity_id),

    CONSTRAINT fk_activity_user
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");