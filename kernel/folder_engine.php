<?php

function folder_get_tree(PDO $pdo, int $parent_id = 0): array {

    $stmt = $pdo->prepare("
        SELECT id, name
        FROM folders
        WHERE parent_id = :parent
        ORDER BY name
    ");

    $stmt->execute(['parent' => $parent_id]);
    $folders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($folders as &$f) {
        $f['children'] = folder_get_tree($pdo, $f['id']);
    }

    return $folders;
}

function folder_get_pages(PDO $pdo, int $folder_id): array {

    $stmt = $pdo->prepare("
        SELECT id, title
        FROM page
        WHERE folder_id = :fid
        ORDER BY id DESC
    ");

    $stmt->execute(['fid' => $folder_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function folder_create(PDO $pdo, string $name, int $parent_id = 0): void {

    $stmt = $pdo->prepare("
        INSERT INTO folders (name, parent_id)
        VALUES (:name, :parent)
    ");

    $stmt->execute([
        'name' => $name,
        'parent' => $parent_id
    ]);
}