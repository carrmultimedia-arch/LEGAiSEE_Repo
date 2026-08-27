<?php

return [
    'up' => function($pdo) {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS tree_nodes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                parent_id INTEGER DEFAULT NULL,
                name TEXT NOT NULL,
                type TEXT NOT NULL DEFAULT 'folder',
                sort_order INTEGER DEFAULT 0,
                metadata TEXT DEFAULT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (parent_id) REFERENCES tree_nodes(id) ON DELETE CASCADE
            )
        ");

        // Create index for parent_id lookups
        $pdo->exec("CREATE INDEX IF NOT EXISTS idx_tree_nodes_parent_id ON tree_nodes(parent_id)");
        
        // Create index for type queries
        $pdo->exec("CREATE INDEX IF NOT EXISTS idx_tree_nodes_type ON tree_nodes(type)");
    },
    'down' => function($pdo) {
        $pdo->exec("DROP INDEX IF EXISTS idx_tree_nodes_type");
        $pdo->exec("DROP INDEX IF EXISTS idx_tree_nodes_parent_id");
        $pdo->exec("DROP TABLE IF EXISTS tree_nodes");
    }
];
