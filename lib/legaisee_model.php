<?php

/**
 * LEGAiSEE MODEL LAYER
 * Unified abstraction over pages, files, clusters, relations, and workspace context
 */

require_once __DIR__ . '/../db.php';

/**
 * -----------------------------
 * CORE ENTITY ACCESS
 * -----------------------------
 */

/**
 * Get a PAGE entity with content + metadata
 */
function legaisee_get_page($id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT p.*,
               pc.content
        FROM page p
        LEFT JOIN page_content pc ON pc.page_id = p.id
        WHERE p.id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Get FILE entity
 */
function legaisee_get_file($id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM files
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Get FOLDER tree node
 */
function legaisee_get_folder($id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM folders
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * -----------------------------
 * RELATION ENGINE
 * -----------------------------
 */

function legaisee_get_relations($source_id, $limit = 50)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM page_relations
        WHERE source_id = :id
        ORDER BY weight DESC
        LIMIT $limit
    ");

    $stmt->execute(['id' => $source_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function legaisee_get_reverse_relations($target_id, $limit = 50)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM page_relations
        WHERE target_id = :id
        ORDER BY weight DESC
        LIMIT $limit
    ");

    $stmt->execute(['id' => $target_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * -----------------------------
 * CLUSTER INTELLIGENCE
 * -----------------------------
 */

function legaisee_get_cluster($id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM clusters
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function legaisee_get_cluster_pages($cluster_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM page
        WHERE cluster_id = :id
    ");

    $stmt->execute(['id' => $cluster_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * -----------------------------
 * WORKSPACE CONTEXT
 * -----------------------------
 */

function legaisee_get_workspace($id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM workspace
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * -----------------------------
 * FILE SYSTEM INTELLIGENCE
 * -----------------------------
 */

function legaisee_get_files_by_folder($folder_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM files
        WHERE folder_id = :id
        ORDER BY created_at DESC
    ");

    $stmt->execute(['id' => $folder_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function legaisee_get_folders($parent_id = null)
{
    global $pdo;

    if ($parent_id === null) {
        $stmt = $pdo->query("SELECT * FROM folders WHERE parent_id IS NULL");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $stmt = $pdo->prepare("
        SELECT *
        FROM folders
        WHERE parent_id = :id
    ");

    $stmt->execute(['id' => $parent_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * -----------------------------
 * SEMANTIC / AI LAYER
 * -----------------------------
 */

function legaisee_get_embedding($page_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT embedding
        FROM page
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $page_id]);
    return $stmt->fetchColumn();
}

function legaisee_get_ai_summary($page_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT ai_summary
        FROM page
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $page_id]);
    return $stmt->fetchColumn();
}

function legaisee_get_ai_tags($page_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT ai_tags
        FROM page
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $page_id]);
    return $stmt->fetchColumn();
}

function legaisee_get_ai_score($page_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT ai_score
        FROM page
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute(['id' => $page_id]);
    return $stmt->fetchColumn();
}

/**
 * -----------------------------
 * UNIFIED SEARCH HOOK (BRIDGE TO API V8)
 * -----------------------------
 */

function legaisee_search_intelligence($query)
{
    $url = "api/v8/predictor.php";

    $options = [
        "http" => [
            "header"  => "Content-type: application/x-www-form-urlencoded",
            "method"  => "POST",
            "content" => http_build_query([
                "query" => $query
            ])
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return json_decode($result, true);
}

/**
 * -----------------------------
 * CROSS-ENTITY GRAPH VIEW
 * -----------------------------
 */

function legaisee_entity_graph($id)
{
    return [
        "relations" => legaisee_get_relations($id),
        "reverse"   => legaisee_get_reverse_relations($id),
        "embedding" => legaisee_get_embedding($id),
        "tags"      => legaisee_get_ai_tags($id),
        "score"     => legaisee_get_ai_score($id),
    ];
}