<?php

declare(strict_types=1);

use App\Database\Connection;

$db = Connection::get();

$db->exec("
CREATE TABLE IF NOT EXISTS role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    permission_id INT NOT NULL,

    CONSTRAINT fk_role_permissions_role
    FOREIGN KEY (role_id)
    REFERENCES roles(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_role_permissions_permission
    FOREIGN KEY (permission_id)
    REFERENCES permissions(id)
    ON DELETE CASCADE,

    UNIQUE KEY unique_role_permission(role_id, permission_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");