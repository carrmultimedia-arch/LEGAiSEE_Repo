<?php

declare(strict_types=1);

use App\Database\Connection;

$db = Connection::get();

$db->exec("
CREATE TABLE IF NOT EXISTS attachments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entity_type VARCHAR(100) NOT NULL,
    entity_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    storage_path VARCHAR(500) NOT NULL,
    mime_type VARCHAR(100) NULL,
    file_size INT NULL,
    uploaded_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_attachment_entity(entity_type, entity_id),

    CONSTRAINT fk_attachment_user
    FOREIGN KEY (uploaded_by)
    REFERENCES users(id)
    ON DELETE SET NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");