<?php
declare(strict_types=1);

/* ===================================================== */
/* LEGAiSEE — CLIENT VAULT MODULE */
/* ===================================================== */

require_once __DIR__ . '/../kernel/kernel_boot.php';

try {

    $db = kernel_db();

    $stmt = $db->query("
        SELECT
            id,
            client_uid,
            name,
            industry,
            city,
            state,
            status
        FROM clients
        ORDER BY id DESC
        LIMIT 20
    ");

    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Throwable $e) {

    return [

        'type' => 'system',

        'message' => 'Vault Database Failure: ' .
            $e->getMessage()
    ];
}

/* ===================================================== */
/* EMPTY STATE */
/* ===================================================== */

if (empty($clients)) {

    return [

        'type' => 'system',

        'message' => 'No sovereign intelligence dossiers found.'
    ];
}

/* ===================================================== */
/* BUILD LIST ITEMS */
/* ===================================================== */

$items = [];

foreach ($clients as $client) {

    $items[] = [

        'link' => '/commandcenter/shell.php?module=client_view&id=' . $client['id'],

        'title' => $client['name'] ?: 'Unnamed Client',

        'meta' => $client['industry'] ?: 'Unknown Industry',

        'content' =>

            ($client['city'] ?: 'Unknown City') .

            ', ' .

            ($client['state'] ?: 'Unknown State') .

            ' • UID: ' .

            ($client['client_uid'] ?: 'unknown')
    ];
}

/* ===================================================== */
/* RETURN UIC LIST */
/* ===================================================== */

return [

    'type'  => 'list',

    'title' => 'Client Intelligence Vault',

    'items' => $items
];