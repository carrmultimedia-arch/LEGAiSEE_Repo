<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/kernel/kernel_boot.php';
require_once __DIR__ . '/modules/utils/bootstrap.php';
require_once __DIR__ . '/modules/utils/uic_v1.php';

// ── MODULE REGISTRY ───────────────────────────────────────────────────────────
$registry = require __DIR__ . '/kernel/module_registry.php';

// ── ROUTE ────────────────────────────────────────────────────────────────────
$requestedModule = trim($_GET['module'] ?? '');

// ── MODULE RENDERER ───────────────────────────────────────────────────────────
function renderModule(string $name, array $registry): string {
    if (!isset($registry[$name])) {
        return "<div class='empty'>Module not registered: " . htmlspecialchars($name) . "</div>";
    }

    $file = __DIR__ . '/modules/' . $registry[$name];
    if (!file_exists($file)) {
        return "<div class='empty'>Module file not found: " . htmlspecialchars($registry[$name]) . "</div>";
    }

    try {
        ob_start();
        $result = require $file;
        $buffer = ob_get_clean();

        if (!empty(trim($buffer))) return $buffer;

        if (is_string($result)) return $result;

        if (is_array($result)) {
            if (isset($result[0]) && is_array($result[0]) && isset($result[0]['type'])) {
                $html = '';
                foreach ($result as $item) $html .= uic_render($item);
                return $html;
            }
            if (isset($result['type'])) return uic_render($result);
            if (isset($result['title']) && isset($result['items'])) {
                return render_inspector($result);
            }
            $html = "<div class='exec-panel'>";
            foreach ($result as $k => $v) {
                if (is_array($v)) $v = count($v) . ' records';
                $html .= "<div class='exec-line'>
                    <span class='exec-key'>" . htmlspecialchars((string)$k) . "</span>
                    <span class='exec-value'>" . htmlspecialchars((string)$v) . "</span>
                </div>";
            }
            return $html . "</div>";
        }

        return "<div class='data-text'>" . htmlspecialchars((string)$result) . "</div>";

    } catch (Throwable $e) {
        return "<div class='error'>Error in module " . htmlspecialchars($name) . ": " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

function render_inspector(array $data): string {
    $html = "<div class='inspector'>";
    foreach ($data['items'] as $item) {
        $html .= "<div class='inspector-card'>
            <div class='inspector-title'>" . htmlspecialchars($item['title']) . "</div>
            <div class='inspector-meta'>" . htmlspecialchars($item['meta'] ?? '') . "</div>
            <pre class='inspector-content'>" . htmlspecialchars($item['content'] ?? '') . "</pre>
        </div>";
    }
    return $html . "</div>";
}

// ── DASHBOARD CARDS (shown when no ?module) ───────────────────────────────────
$dashboardGroups = [
    [
        'label'   => 'Command',
        'cards'   => [
            ['module' => 'dashboard',              'title' => 'System Dashboard',      'desc' => 'Case & client overview'],
            ['module' => 'intelligence_dashboard', 'title' => 'Intel Dashboard',       'desc' => 'Executive intelligence overview'],
            ['module' => 'brain',                  'title' => 'Brain',                 'desc' => 'System intelligence & module registry'],
        ]
    ],
    [
        'label'   => 'Planning',
        'cards'   => [
            ['module' => 'pm', 'title' => 'Project Board', 'desc' => 'Tasks by project — Backlog to Done'],
        ]
    ],
    [
        'label'   => 'Clients & Cases',
        'cards'   => [
            ['module' => 'clients',   'title' => 'Client Vault',    'desc' => 'All client records'],
            ['module' => 'cases',     'title' => 'Cases',           'desc' => 'Case archive & status'],
            ['module' => 'vault',     'title' => 'Vault',           'desc' => 'Secure artifact storage'],
            ['module' => 'report',    'title' => 'Reports',         'desc' => 'Generated authority reports'],
        ]
    ],
    [
        'label'   => 'Excavation',
        'cards'   => [
            ['module' => 'excavation', 'title' => 'Excavation',     'desc' => 'Artifact recovery & ingest'],
            ['module' => 'ingest',     'title' => 'Memory Ingest',  'desc' => 'AI chat & document ingestion'],
            ['module' => 'files',      'title' => 'Files',          'desc' => 'File inspector'],
            ['module' => 'search',     'title' => 'Search',         'desc' => 'Archive search'],
        ]
    ],
    [
        'label'   => 'Intelligence Engines',
        'cards'   => [
            ['module' => 'anomaly_engine',    'title' => 'Anomaly',          'desc' => 'Risk & anomaly detection'],
            ['module' => 'insight',           'title' => 'Insight',          'desc' => 'Case status intelligence'],
            ['module' => 'recommendation',    'title' => 'Recommendation',   'desc' => 'Action recommendations'],
            ['module' => 'decision',          'title' => 'Decision Engine',  'desc' => 'Decision logic'],
            ['module' => 'predictive', 'title' => 'Predictive',  'desc' => 'Pattern transition forecasting'],
            ['module' => 'time_intelligence', 'title' => 'Time Intelligence','desc' => 'Temporal trend analysis'],
        ]
    ],
    [
        'label'   => 'Graph & Entities',
        'cards'   => [
            ['module' => 'graph',             'title' => 'Network Graph',    'desc' => 'Entity relationship map'],
            ['module' => 'entity_resolution', 'title' => 'Entities', 'desc' => 'Entity resolution & aliases'],
            ['module' => 'relations',         'title' => 'Relations',        'desc' => 'Case-client relationship map'],
            ['module' => 'root_cause',        'title' => 'Root Cause',       'desc' => 'Root cause graph analysis'],
            ['module' => 'cluster',           'title' => 'Clusters',         'desc' => 'Semantic case clusters'],
            ['module' => 'semantic_cluster',  'title' => 'Semantic Cluster', 'desc' => 'Deep semantic clustering'],
            ['module' => 'cross_case_engine', 'title' => 'Cross-Case',       'desc' => 'Pattern correlation across cases'],
        ]
    ],
    [
        'label'   => 'Tools',
        'cards'   => [
            ['module' => 'compare',    'title' => 'Compare',    'desc' => 'Dual-document intelligence compare'],
            ['module' => 'view',       'title' => 'View',       'desc' => 'Artifact viewer'],
        ]
    ],
];

// ── NAV LINKS (always visible) ────────────────────────────────────────────────
$navLinks = [
    ''          => 'Lobby',
   'governance' => 'Governance',
    'dashboard' => 'Dashboard',
    'pm'        => 'Tasks',
    'brain'     => '🧠 Brain',
    'clients'   => 'Clients',
    'cases'     => 'Cases',
    'excavation'=> 'Excavation',
    'search'    => 'Search',
];

// Prospect Dig is a standalone workaround — links out
$standaloneLinks = [
    '/commandcenter/prospect.php' => '⛏ Prospect Dig',
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LEGAiSEE<?= $requestedModule ? ' — ' . htmlspecialchars(ucfirst($requestedModule)) : ' — Grand Lobby' ?></title>
<link rel="stylesheet" href="/commandcenter/ui/global.css">
</head>
<body>

<div class="app-shell">

    <div class="top-nav">
        <div class="top-nav-brand">
            <span class="top-nav-title">LEGAiSEE</span>
            <span class="top-nav-sub">Sovereign Intelligence Environment</span>
        </div>
        <div class="top-nav-links">
            <?php foreach ($navLinks as $mod => $label):
                $href    = '/commandcenter/shell.php' . ($mod ? '?module=' . $mod : '');
                $active  = ($requestedModule === $mod) ? ' active' : '';
            ?>
                <a href="<?= $href ?>" class="<?= $active ?>"><?= htmlspecialchars($label) ?></a>
            <?php endforeach; ?>
            <?php foreach ($standaloneLinks as $href => $label): ?>
                <a href="<?= $href ?>"><?= htmlspecialchars($label) ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="app-body">

        <?php if ($requestedModule): ?>

            <div class="module-view">
                <div class="module-view-header">
                    <a class="module-back" href="/commandcenter/shell.php">← Grand Lobby</a>
                    <h1 class="module-view-title"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $requestedModule))) ?></h1>
                </div>
                <div class="module-view-body">
                    <?= renderModule($requestedModule, $registry) ?>
                </div>
            </div>

        <?php else: ?>

            <div class="lobby-hero">
                <div class="lobby-label">Sovereign Intelligence Environment</div>
                <h1 class="lobby-title">Grand Lobby</h1>
                <p class="lobby-text">Select a module to begin. Click any card to open the full module view.</p>
            </div>

            <?php foreach ($dashboardGroups as $group): ?>
            <div class="dashboard-group">
                <div class="dashboard-group-label"><?= htmlspecialchars($group['label']) ?></div>
                <div class="layout-grid">
                    <?php foreach ($group['cards'] as $card): ?>
                    <a class="ui-card ui-card-link" href="/commandcenter/shell.php?module=<?= urlencode($card['module']) ?>">
                        <div class="ui-card-title"><?= htmlspecialchars($card['title']) ?></div>
                        <div class="ui-card-body"><?= htmlspecialchars($card['desc']) ?></div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>

</body>
</html>