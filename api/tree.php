<?php

require_once __DIR__ . '/../kernel/db.php';

header('Content-Type: application/json');

function respond($status, $data = [], $message = null) {
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

$action = $_GET['action'] ?? '';
$pdo = kernel_db();

switch($action) {
    
    case 'create':
        // Create a new tree node
        $name = $_POST['name'] ?? null;
        $parent_id = $_POST['parent_id'] ?? null;
        $type = $_POST['type'] ?? 'folder';
        $metadata = $_POST['metadata'] ?? null;
        
        // Convert empty string to null for parent_id
        if ($parent_id === '') {
            $parent_id = null;
        }
        
        if (!$name) {
            respond('error', [], 'Name is required');
        }
        
        // Validate parent_id exists if provided
        if ($parent_id !== null) {
            $stmt = $pdo->prepare("SELECT id FROM tree_nodes WHERE id = ?");
            $stmt->execute([$parent_id]);
            if (!$stmt->fetch()) {
                respond('error', [], 'Parent node not found');
            }
        }
        
        // Get max sort_order for siblings
        if ($parent_id !== null) {
            $stmt = $pdo->prepare("SELECT MAX(sort_order) as max_sort FROM tree_nodes WHERE parent_id = ?");
            $stmt->execute([$parent_id]);
        } else {
            $stmt = $pdo->prepare("SELECT MAX(sort_order) as max_sort FROM tree_nodes WHERE parent_id IS NULL");
            $stmt->execute();
        }
        $result = $stmt->fetch();
        $sort_order = ($result['max_sort'] ?? 0) + 1;
        
        $stmt = $pdo->prepare("
            INSERT INTO tree_nodes (parent_id, name, type, sort_order, metadata)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        try {
            $stmt->execute([
                $parent_id,
                $name,
                $type,
                $sort_order,
                $metadata ? json_encode($metadata) : null
            ]);
            
            respond('ok', [
                'id' => $pdo->lastInsertId(),
                'name' => $name,
                'parent_id' => $parent_id,
                'type' => $type,
                'sort_order' => $sort_order
            ], 'Node created successfully');
        } catch (Exception $e) {
            respond('error', [], 'Failed to create node: ' . $e->getMessage());
        }
        break;
        
    case 'rename':
        // Rename a tree node
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? null;
        
        if (!$id || !$name) {
            respond('error', [], 'ID and name are required');
        }
        
        $stmt = $pdo->prepare("UPDATE tree_nodes SET name = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        
        try {
            $stmt->execute([$name, $id]);
            
            if ($stmt->rowCount() === 0) {
                respond('error', [], 'Node not found');
            }
            
            respond('ok', ['id' => $id, 'name' => $name], 'Node renamed successfully');
        } catch (Exception $e) {
            respond('error', [], 'Failed to rename node: ' . $e->getMessage());
        }
        break;
        
    case 'move':
        // Move a tree node to a new parent
        $id = $_POST['id'] ?? null;
        $new_parent_id = $_POST['parent_id'] ?? null;
        
        // Convert empty string to null for parent_id
        if ($new_parent_id === '') {
            $new_parent_id = null;
        }
        
        if (!$id) {
            respond('error', [], 'ID is required');
        }
        
        // Prevent moving a node into its own descendants
        if ($new_parent_id !== null) {
            $stmt = $pdo->prepare("
                WITH RECURSIVE descendants AS (
                    SELECT id FROM tree_nodes WHERE id = ?
                    UNION ALL
                    SELECT t.id FROM tree_nodes t
                    INNER JOIN descendants d ON t.parent_id = d.id
                )
                SELECT id FROM descendants WHERE id = ?
            ");
            $stmt->execute([$id, $new_parent_id]);
            if ($stmt->fetch()) {
                respond('error', [], 'Cannot move a node into its own descendant');
            }
            
            // Validate new parent exists
            $stmt = $pdo->prepare("SELECT id FROM tree_nodes WHERE id = ?");
            $stmt->execute([$new_parent_id]);
            if (!$stmt->fetch()) {
                respond('error', [], 'New parent node not found');
            }
        }
        
        // Get new sort_order
        if ($new_parent_id !== null) {
            $stmt = $pdo->prepare("SELECT MAX(sort_order) as max_sort FROM tree_nodes WHERE parent_id = ?");
            $stmt->execute([$new_parent_id]);
        } else {
            $stmt = $pdo->prepare("SELECT MAX(sort_order) as max_sort FROM tree_nodes WHERE parent_id IS NULL");
            $stmt->execute();
        }
        $result = $stmt->fetch();
        $sort_order = ($result['max_sort'] ?? 0) + 1;
        
        $stmt = $pdo->prepare("
            UPDATE tree_nodes 
            SET parent_id = ?, sort_order = ?, updated_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        
        try {
            $stmt->execute([$new_parent_id, $sort_order, $id]);
            
            if ($stmt->rowCount() === 0) {
                respond('error', [], 'Node not found');
            }
            
            respond('ok', [
                'id' => $id,
                'parent_id' => $new_parent_id,
                'sort_order' => $sort_order
            ], 'Node moved successfully');
        } catch (Exception $e) {
            respond('error', [], 'Failed to move node: ' . $e->getMessage());
        }
        break;
        
    case 'delete':
        // Delete a tree node (with cascade to children)
        $id = $_POST['id'] ?? null;
        $block = ($_POST['block'] ?? 'false') === 'true';
        
        if (!$id) {
            respond('error', [], 'ID is required');
        }
        
        // Check if node has children
        $stmt = $pdo->prepare("SELECT COUNT(*) as child_count FROM tree_nodes WHERE parent_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        
        if ($result['child_count'] > 0 && !$block) {
            respond('error', [], 'Cannot delete node with children. Use block=true to delete with children.');
        }
        
        if ($block && $result['child_count'] > 0) {
            // Delete with cascade (will delete all descendants due to FK constraint)
            $stmt = $pdo->prepare("DELETE FROM tree_nodes WHERE id = ?");
        } else {
            $stmt = $pdo->prepare("DELETE FROM tree_nodes WHERE id = ?");
        }
        
        try {
            $stmt->execute([$id]);
            
            if ($stmt->rowCount() === 0) {
                respond('error', [], 'Node not found');
            }
            
            respond('ok', ['id' => $id, 'deleted_children' => $block], 'Node deleted successfully');
        } catch (Exception $e) {
            respond('error', [], 'Failed to delete node: ' . $e->getMessage());
        }
        break;
        
    case 'get_tree':
        // Get the entire tree structure
        $stmt = $pdo->query("
            SELECT id, parent_id, name, type, sort_order, metadata, created_at, updated_at
            FROM tree_nodes
            ORDER BY (parent_id IS NULL) DESC, parent_id ASC, sort_order ASC
        ");
        
        $nodes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Build tree structure
        $tree = [];
        $nodeMap = [];
        
        // First pass: create all nodes
        foreach ($nodes as $node) {
            $node['children'] = [];
            $node['metadata'] = $node['metadata'] ? json_decode($node['metadata'], true) : null;
            $nodeMap[$node['id']] = $node;
        }
        
        // Second pass: build hierarchy
        foreach ($nodeMap as $id => $node) {
            if ($node['parent_id'] === null) {
                $tree[] = &$nodeMap[$id];
            } else {
                if (isset($nodeMap[$node['parent_id']])) {
                    $nodeMap[$node['parent_id']]['children'][] = &$nodeMap[$id];
                }
            }
        }
        
        respond('ok', $tree, 'Tree retrieved successfully');
        break;
        
    default:
        respond('error', [], 'Invalid action. Use: create, rename, move, delete, get_tree');
}
