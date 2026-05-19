<?php
declare(strict_types=1);

require_once __DIR__ . '/utils/bootstrap.php';

$cases   = load_json_dir(__DIR__ . '/../data/cases');
$clients = load_json_dir(__DIR__ . '/../data/clients');

$clientIndex = [];
foreach ($clients as $c) {
    if (!empty($c['id'])) $clientIndex[$c['id']] = $c;
}

ob_start();
echo "<div class='exec-panel'>";
echo "<div class='exec-line'>
    <span class='exec-key' style='color:#F4E185'>Cases</span>
    <span class='exec-value' style='color:#89612B'>" . count($cases) . " total</span>
</div>";

foreach ($cases as $case) {
    $id      = htmlspecialchars((string)($case['id'] ?? 'unknown'));
    $status  = htmlspecialchars((string)($case['status'] ?? 'unknown'));
    $cid     = $case['client_id'] ?? null;
    $client  = 'Unknown';
    if ($cid && isset($clientIndex[$cid])) {
        $client = htmlspecialchars((string)($clientIndex[$cid]['name'] ?? 'Unnamed'));
    }
    $patterns = $case['analysis']['patterns'] ?? [];
    $ptags    = '';
    foreach ($patterns as $p) {
        $ptags .= "<span style='background:#1a1a1a;border:1px solid rgba(255,255,255,0.06);border-radius:6px;padding:1px 6px;font-size:10px;margin-left:4px;color:#89612B'>" . htmlspecialchars((string)$p) . "</span>";
    }
    $statusColor = $status === 'open' ? '#4ade80' : '#89612B';
    echo "<div class='exec-line' style='flex-direction:column;align-items:flex-start;gap:4px'>
        <div style='display:flex;justify-content:space-between;width:100%'>
            <span class='exec-key'>{$id}</span>
            <span style='font-size:11px;color:{$statusColor}'>{$status}</span>
        </div>
        <div style='font-size:11px;color:#89612B'>{$client}{$ptags}</div>
    </div>";
}

echo "</div>";
return ob_get_clean();