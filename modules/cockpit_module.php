<?php

declare(strict_types=1);

require_once __DIR__ . '/../kernel/db.php';

function cockpit_get_data(): array
{
    $pdo = kernel_db();
    $data = [
        'attention_items' => [],
        'diary_items' => [],
        'health_items' => [],
        'summary' => [
            'client_count' => 0,
            'case_count' => 0,
        ],
    ];

    try {
        // Summary Stats
        $data['summary']['client_count'] = $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
        $data['summary']['case_count'] = $pdo->query("SELECT COUNT(*) FROM cases")->fetchColumn();

        // Needs Your Attention: High-priority recommendations
        $stmt = $pdo->query("
            SELECT * FROM processing_queue 
            WHERE task_type = 'recommendation' AND status = 'pending'
            ORDER BY id DESC LIMIT 5
        ");
        $data['attention_items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // System Diary: Recent prospect ingests
        $prospectsTableExists = $pdo->query("SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = DATABASE() AND table_name = 'prospect_ingests' LIMIT 1")->fetch();
        if ($prospectsTableExists) {
             $stmt = $pdo->query("
                SELECT prospect_name, ingest_number, authority_score, created_at 
                FROM prospect_ingests 
                ORDER BY id DESC LIMIT 5
            ");
            $data['diary_items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // System Health: Check DB connection and key tables
        $data['health_items'][] = ['label' => 'Database Connection', 'status' => 'OK', 'value' => 'Connected'];
        $tables = ['clients', 'cases', 'entities', 'relationships', 'tree_nodes'];
        foreach ($tables as $table) {
            $count = $pdo->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
            $data['health_items'][] = ['label' => ucfirst(str_replace('_', ' ', $table)), 'status' => 'OK', 'value' => "$count records"];
        }

    } catch (Exception $e) {
        $data['health_items'][] = ['label' => 'System Health', 'status' => 'ERROR', 'value' => $e->getMessage()];
    }

    return $data;
}

$cockpit_data = cockpit_get_data();

?>

<style>
.cockpit-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}
.cockpit-widget {
    background: rgba(10, 10, 12, 0.82);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
}
.cockpit-widget-title {
    font-size: 1rem;
    font-weight: 500;
    letter-spacing: 1px;
    color: #F4E185;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
}
.cockpit-list-item {
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    font-size: 0.875rem;
    line-height: 1.6;
}
.cockpit-list-item:last-child { border-bottom: none; }
.cockpit-item-title { color: #CDAD69; }
.cockpit-item-meta { font-size: 0.75rem; color: #89612B; }
.health-item { display: flex; justify-content: space-between; align-items: center; }
.health-status-ok { color: #50c878; }
.health-status-error { color: #ff4d4d; font-weight: bold; }

.pillar-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 2.5rem;
}
.pillar-tile {
    background: linear-gradient(145deg, rgba(30,24,8,0.95), rgba(10,10,12,0.92));
    border: 1px solid rgba(230,194,86,0.20);
    border-radius: 16px;
    padding: 1.5rem;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
}
.pillar-tile:hover {
    transform: translateY(-4px);
    border-color: rgba(230,194,86,0.5);
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
}
.pillar-title {
    font-size: 1.2rem;
    font-weight: 400;
    color: #F4E185;
    margin-bottom: 0.5rem;
}
.pillar-desc {
    font-size: 0.85rem;
    color: #89612B;
    line-height: 1.6;
}
</style>

<div class="cockpit-grid">
    <!-- WIDGET 1: GOOD MORNING -->
    <div class="cockpit-widget">
        <h2 class="cockpit-widget-title">Good Morning, Operator</h2>
        <p class="cockpit-item-title" style="font-size: 1.2rem;">Today is <?= date('l, F jS, Y') ?>.</p>
        <p class="cockpit-item-meta" style="margin-top: auto;">
            System is monitoring <?= $cockpit_data['summary']['client_count'] ?> clients and <?= $cockpit_data['summary']['case_count'] ?> cases.
        </p>
    </div>

    <!-- WIDGET 2: NEEDS YOUR ATTENTION -->
    <div class="cockpit-widget">
        <h2 class="cockpit-widget-title">Needs Your Attention</h2>
        <?php if (empty($cockpit_data['attention_items'])): ?>
            <p class="cockpit-item-meta">No high-priority items found.</p>
        <?php else: ?>
            <?php foreach ($cockpit_data['attention_items'] as $item): ?>
                <div class="cockpit-list-item">
                    <div class="cockpit-item-title"><?= htmlspecialchars($item['task_type'] ?? 'Task') ?> for Case #<?= htmlspecialchars((string)($item['case_id'] ?? '')) ?></div>
                    <div class="cockpit-item-meta">Status: <?= htmlspecialchars($item['status'] ?? '') ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- WIDGET 3: SYSTEM DIARY -->
    <div class="cockpit-widget">
        <h2 class="cockpit-widget-title">System Diary</h2>
        <?php if (empty($cockpit_data['diary_items'])): ?>
            <p class="cockpit-item-meta">No recent activity logged.</p>
        <?php else: ?>
            <?php foreach ($cockpit_data['diary_items'] as $item): ?>
                <div class="cockpit-list-item">
                    <div class="cockpit-item-title">Prospect Ingest #<?= htmlspecialchars((string)($item['ingest_number'] ?? '')) ?>: <?= htmlspecialchars($item['prospect_name'] ?? '') ?></div>
                    <div class="cockpit-item-meta">Score: <?= htmlspecialchars((string)($item['authority_score'] ?? '')) ?> | <?= date('M j, g:i a', strtotime($item['created_at'])) ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- WIDGET 4: SYSTEM HEALTH -->
    <div class="cockpit-widget">
        <h2 class="cockpit-widget-title">System Health</h2>
        <?php foreach ($cockpit_data['health_items'] as $item): ?>
            <div class="cockpit-list-item health-item">
                <span class="cockpit-item-title"><?= htmlspecialchars($item['label']) ?></span>
                <span class="health-status-<?= strtolower($item['status']) ?>"><?= htmlspecialchars($item['value']) ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$pillars = [
    ['key' => 'clients', 'title' => 'Clients & Cases', 'desc' => 'Manage all client records and their associated case files.'],
    ['key' => 'excavation', 'title' => 'Excavation', 'desc' => 'Run artifact recovery, file browsing, and cross-archive search.'],
    ['key' => 'dig_review', 'title' => 'Dig Review', 'desc' => 'Verify, approve, or reject extracted entities and relationships.'],
    ['key' => 'graph', 'title' => 'Knowledge System', 'desc' => 'Explore the entity relationship map and knowledge graph.'],
    ['key' => 'vault', 'title' => 'Vault', 'desc' => 'Access the secure storage for all client artifacts and raw data.'],
    ['key' => 'payment', 'title' => 'Payments', 'desc' => 'Handle Stripe checkout sessions and view billing history.'],
    ['key' => 'ingest', 'title' => 'Intake', 'desc' => 'Ingest new documents, chat sessions, and other intelligence.'],
];
?>

<div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05);">
    <h2 class="cockpit-widget-title" style="text-align: center; font-size: 1.2rem;">System Pillars</h2>
</div>

<div class="pillar-grid">
    <?php foreach ($pillars as $pillar): ?>
        <a href="?module=<?= htmlspecialchars($pillar['key']) ?>" class="pillar-tile">
            <div class="pillar-title"><?= htmlspecialchars($pillar['title']) ?></div>
            <div class="pillar-desc"><?= htmlspecialchars($pillar['desc']) ?></div>
        </a>
    <?php endforeach; ?>
</div>