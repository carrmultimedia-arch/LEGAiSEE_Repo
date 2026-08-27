<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/kernel/kernel_boot.php';

$caseId = $_GET['case_id'] ?? null;

if (!$caseId) {
    echo "<div class='error'>No Case ID provided for graph view.</div>";
    return;
}

// The graph data is in a file, not the database.
$graph_file_path = __DIR__ . "/data/cases/{$caseId}/network.json";

if (!file_exists($graph_file_path)) {
    echo "<div class='empty'>No graph data file found for this client case.</div>";
    return;
}
$network_data_json = file_get_contents($graph_file_path);

if (!$network_data_json || empty(json_decode($network_data_json, true)['nodes'])) {
    echo "<div class='empty'>No graph data yet for this client case.</div>";
    return;
}

$network_data = json_decode($network_data_json, true);

// Prepare data for vis-network
$nodes = [];
$edges = [];

foreach ($network_data['nodes'] ?? [] as $node) {
    $nodes[] = [
        'id' => $node['id'],
        'label' => $node['label'],
        'group' => $node['type'] ?? 'default',
        'title' => "Type: " . ($node['type'] ?? 'N/A')
    ];
}

foreach ($network_data['edges'] ?? [] as $edge) {
    $edges[] = [
        'from' => $edge['from'],
        'to' => $edge['to'],
        'label' => $edge['label'] ?? ''
    ];
}

?>

<div id="vis-network-graph" style="height: 600px; width: 100%; background: #0a0a0c; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);"></div>
<script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>

<script type="text/javascript">
    const nodes = new vis.DataSet(<?= json_encode($nodes, JSON_UNESCAPED_SLASHES) ?>);
    const edges = new vis.DataSet(<?= json_encode($edges, JSON_UNESCAPED_SLASHES) ?>);

    const container = document.getElementById('vis-network-graph');
    const data = { nodes: nodes, edges: edges };

    const options = {
        nodes: {
            shape: 'dot',
            size: 16,
            font: {
                size: 14,
                color: '#e0e0e0'
            },
            borderWidth: 2
        },
        edges: {
            width: 2,
            color: {
                color: '#333',
                highlight: '#d4af37'
            },
            arrows: {
                to: { enabled: true, scaleFactor: 0.5 }
            }
        },
        physics: {
            enabled: true,
            solver: 'forceAtlas2Based',
            forceAtlas2Based: {
                gravitationalConstant: -50,
                centralGravity: 0.01,
                springLength: 100,
                springConstant: 0.08,
                avoidOverlap: 0.5
            }
        },
        interaction: {
            hover: true,
            tooltipDelay: 200
        },
        groups: {
            person: { color: { background: '#e6c256', border: '#c0a040' } },
            organization: { color: { background: '#4f8a8b', border: '#3a6a6b' } },
            location: { color: { background: '#a5678e', border: '#8e4a75' } },
            default: { color: { background: '#666', border: '#444' } }
        }
    };

    const network = new vis.Network(container, data, options);

    network.on("click", function (params) {
        if (params.nodes.length > 0) {
            const nodeId = params.nodes[0];
            const node = nodes.get(nodeId);
            console.log('Clicked node:', node);
        }
    });
</script>