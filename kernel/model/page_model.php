<?php

function page_find(PDO $pdo, string $query): array
{
    $stmt = $pdo->prepare("
        SELECT p.id, p.title, pc.content
        FROM page p
        LEFT JOIN page_content pc ON pc.page_id = p.id
        WHERE p.title LIKE :q OR pc.content LIKE :q
        LIMIT 20
    ");

    $stmt->execute(['q' => "%$query%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}