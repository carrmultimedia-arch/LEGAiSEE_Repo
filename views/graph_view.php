<?php
require_once __DIR__ . '/../kernel/kernel_boot.php';

// Get graph data from root_cause_graph_module.php via shell to avoid redeclaration
$graphData = [];
$clientsDir = __DIR__ . '/../data/clients';
$cases = [];

if (is_dir($clientsDir)) {
    foreach (glob($clientsDir . '/*/cases/*/meta.json') as $metaFile) {
        $meta = json_decode(file_get_contents($metaFile), true);
        if ($meta) {
            $cases[] = $meta;
        }
    }
}

$caseToClient = [];
$clientToCases = [];
$caseToPatterns = [];

foreach ($cases as $c) {
    $caseId = $c['id'] ?? '';
    $clientId = $c['client_id'] ?? '';
    
    if ($caseId && $clientId) {
        $caseToClient[$caseId] = $clientId;
        if (!isset($clientToCases[$clientId])) {
            $clientToCases[$clientId] = [];
        }
        $clientToCases[$clientId][] = $caseId;
    }
    
    $patterns = $c['analysis']['patterns'] ?? [];
    $caseToPatterns[$caseId] = $patterns;
}

// Build graph nodes
$nodes = [];
$edges = [];

foreach ($cases as $c) {
    $caseId = $c['id'] ?? '';
    $clientId = $c['client_id'] ?? '';
    
    if ($caseId) {
        $nodes[] = [
            'id' => $caseId,
            'label' => $caseId,
            'type' => 'case',
            'degree' => 0
        ];
    }
    
    if ($clientId && !in_array($clientId, array_column($nodes, 'id'))) {
        $nodes[] = [
            'id' => $clientId,
            'label' => $clientId,
            'type' => 'client',
            'degree' => 0
        ];
    }
    
    $patterns = $c['analysis']['patterns'] ?? [];
    foreach ($patterns as $p) {
        $patternId = 'pattern_' . $p;
        if (!in_array($patternId, array_column($nodes, 'id'))) {
            $nodes[] = [
                'id' => $patternId,
                'label' => $p,
                'type' => 'pattern',
                'degree' => 0
            ];
        }
    }
}

// Build graph edges
foreach ($cases as $c) {
    $caseId = $c['id'] ?? '';
    $clientId = $c['client_id'] ?? '';
    
    if ($caseId && $clientId) {
        $edges[] = [
            'from' => $caseId,
            'to' => $clientId,
            'weight' => 1
        ];
    }
    
    $patterns = $c['analysis']['patterns'] ?? [];
    foreach ($patterns as $p) {
        $patternId = 'pattern_' . $p;
        $edges[] = [
            'from' => $caseId,
            'to' => $patternId,
            'weight' => 1
        ];
    }
}

// Calculate degrees
foreach ($edges as $e) {
    $fromId = $e['from'];
    $toId = $e['to'];
    
    foreach ($nodes as &$n) {
        if ($n['id'] === $fromId || $n['id'] === $toId) {
            $n['degree'] = ($n['degree'] ?? 0) + 1;
        }
    }
}

$graphData = [
    'items' => [[
        'content' => json_encode(['nodes' => $nodes, 'edges' => $edges])
    ]]
];

$graphJson = $graphData['items'][0]['content'] ?? '{}';
$graph = json_decode($graphJson, true);

$nodes = $graph['nodes'] ?? [];
$edges = $graph['edges'] ?? [];

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Relationship Graph Explorer</title>
    <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #1a1a2e;
            color: #eee;
        }
        #graph-container {
            width: 100vw;
            height: 100vh;
        }
        #info-panel {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 300px;
            background: rgba(26, 26, 46, 0.95);
            border: 1px solid #444;
            border-radius: 8px;
            padding: 15px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }
        #info-panel h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #ffd700;
            border-bottom: 1px solid #444;
            padding-bottom: 8px;
        }
        .info-item {
            margin: 8px 0;
            font-size: 13px;
        }
        .info-label {
            color: #888;
            font-size: 11px;
            text-transform: uppercase;
        }
        .info-value {
            color: #eee;
            word-break: break-word;
        }
        .legend {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: rgba(26, 26, 46, 0.95);
            border: 1px solid #444;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 12px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin: 5px 0;
        }
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div id="graph-container"></div>
    
    <div id="info-panel">
        <h3>Node Details</h3>
        <div id="node-info">
            <div class="info-item">Click a node to inspect</div>
        </div>
    </div>

    <div class="legend">
        <div class="legend-item"><div class="legend-color" style="background: #4a90e2;"></div>Case</div>
        <div class="legend-item"><div class="legend-color" style="background: #50c878;"></div>Client</div>
        <div class="legend-item"><div class="legend-color" style="background: #ffd700;"></div>Pattern</div>
    </div>

    <script>
        const nodes = new vis.DataSet(<?php echo json_encode($nodes); ?>);
        const edges = new vis.DataSet(<?php echo json_encode($edges); ?>);

        const container = document.getElementById('graph-container');
        const data = { nodes: nodes, edges: edges };
        
        const options = {
            nodes: {
                shape: 'dot',
                size: 16,
                font: {
                    size: 12,
                    color: '#eee'
                },
                borderWidth: 2,
                shadow: true
            },
            edges: {
                width: 2,
                color: { color: '#888', highlight: '#ffd700' },
                smooth: { type: 'continuous' },
                arrows: { to: { enabled: true, scaleFactor: 0.5 } }
            },
            physics: {
                stabilization: true,
                barnesHut: {
                    gravitationalConstant: -2000,
                    springConstant: 0.04,
                    springLength: 95
                }
            },
            interaction: {
                hover: true,
                tooltipDelay: 200,
                zoomView: true,
                dragView: true
            }
        };

        const network = new vis.Network(container, data, options);

        // Color nodes by type
        network.on('beforeDrawing', function(ctx) {
            nodes.forEach(node => {
                const type = node.type || 'unknown';
                let color = '#888';
                if (type === 'case') color = '#4a90e2';
                else if (type === 'client') color = '#50c878';
                else if (type === 'pattern') color = '#ffd700';
                
                node.color = {
                    background: color,
                    border: color,
                    highlight: { background: '#fff', border: color }
                };
            });
        });

        // Show node details on click
        network.on('click', function(params) {
            if (params.nodes.length > 0) {
                const nodeId = params.nodes[0];
                const node = nodes.get(nodeId);
                
                const infoPanel = document.getElementById('node-info');
                infoPanel.innerHTML = `
                    <div class="info-item">
                        <div class="info-label">ID</div>
                        <div class="info-value">${node.id}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Label</div>
                        <div class="info-value">${node.label || node.id}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Type</div>
                        <div class="info-value">${node.type || 'unknown'}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Connections</div>
                        <div class="info-value">${node.degree || 0}</div>
                    </div>
                `;
            }
        });

        // Fit graph on load
        network.once('stabilizationIterationsDone', function() {
            network.fit();
        });
    </script>
</body>
</html>
<?php
return ob_get_clean();
