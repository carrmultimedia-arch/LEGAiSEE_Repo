<?php

require_once __DIR__ . '/../kernel/db.php';

echo "Running Migration: Create tree_nodes table...\n";

try {
    $pdo = kernel_db();

    $sql = "
    CREATE TABLE IF NOT EXISTS `tree_nodes` (
      `id` INT NOT NULL AUTO_INCREMENT,
      `parent_id` INT NULL,
      `name` VARCHAR(255) NOT NULL,
      `type` VARCHAR(50) NOT NULL DEFAULT 'folder',
      `sort_order` INT NOT NULL DEFAULT 0,
      `metadata` JSON NULL,
      `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      INDEX `idx_parent_id` (`parent_id` ASC),
      CONSTRAINT `fk_tree_nodes_parent`
        FOREIGN KEY (`parent_id`)
        REFERENCES `tree_nodes` (`id`)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
    ) ENGINE = InnoDB;
    ";

    $pdo->exec($sql);

    echo "[OK] `tree_nodes` table created successfully or already exists.\n";

} catch (Exception $e) {
    echo "[FAIL] Error creating table: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Migration complete.\n";