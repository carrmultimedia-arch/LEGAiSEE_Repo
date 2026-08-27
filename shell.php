<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/kernel/kernel_boot.php';
require_once __DIR__ . '/modules/utils/bootstrap.php';
require_once __DIR__ . '/modules/utils/uic_v1.php';

// ── EARLY INTERCEPTS FOR FILE DOWNLOADS ──────────────────────────────────────
// These must run before any HTML is output to prevent "headers already sent" errors.

// Report Generation (from report_module.php)
if (isset($_GET['module']) && $_GET['module'] === 'report' && isset($_POST['generate_report'])) {
    require __DIR__ . '/modules/report_module.php';
    exit;
}

// Vault Download (from vault_module.php)
if (isset($_GET['module']) && $_GET['module'] === 'vault' && isset($_GET['action']) && $_GET['action'] === 'download') {
    require __DIR__ . '/modules/vault_module.php';
    exit;
}

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
            ['module' => 'payment',   'title' => 'Payments',        'desc' => 'Stripe checkout & billing'],
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
    'dashboard' => 'Dashboard',
    'pm'        => 'Tasks',
    'brain'     => '🧠 Brain',
    'clients'   => 'Clients',
    'cases'     => 'Cases',
    'excavation'=> 'Excavation',
    'search'    => 'Search',
];

// ── SIDEBAR MODULES (all modules from WO-A audit) ─────────────────────────────
$sidebarModules = [
    [
        'label' => 'Command',
        'modules' => [
            ['key' => 'dashboard', 'title' => 'System Dashboard', 'status' => 'working'],
            ['key' => 'intelligence_dashboard', 'title' => 'Intel Dashboard', 'status' => 'working'],
            ['key' => 'executive', 'title' => 'Executive Dashboard', 'status' => 'working'],
            ['key' => 'brain', 'title' => 'Brain', 'status' => 'working'],
            ['key' => 'cockpit', 'title' => 'Cockpit', 'status' => 'working'],
        ]
    ],
    [
        'label' => 'Planning',
        'modules' => [
            ['key' => 'pm', 'title' => 'Project Board', 'status' => 'working'],
        ]
    ],
    [
        'label' => 'Clients & Cases',
        'modules' => [
            ['key' => 'clients', 'title' => 'Client Vault', 'status' => 'working'],
            ['key' => 'cases', 'title' => 'Cases', 'status' => 'working'],
            ['key' => 'vault', 'title' => 'Vault', 'status' => 'working'],
            ['key' => 'report', 'title' => 'Reports', 'status' => 'working'],
            ['key' => 'payment', 'title' => 'Payments', 'status' => 'working'],
        ]
    ],
    [
        'label' => 'Excavation',
        'modules' => [
            ['key' => 'excavation', 'title' => 'Excavation', 'status' => 'working'],
            ['key' => 'ingest', 'title' => 'Memory Ingest', 'status' => 'working'],
            ['key' => 'ingest_view', 'title' => 'Ingest View', 'status' => 'working'],
            ['key' => 'files', 'title' => 'Files', 'status' => 'working'],
            ['key' => 'search', 'title' => 'Search', 'status' => 'working'],
            ['key' => 'dig_review', 'title' => 'Dig Review', 'status' => 'working'],
        ]
    ],
    [
        'label' => 'Intelligence Engines',
        'modules' => [
            ['key' => 'anomaly_engine', 'title' => 'Anomaly Engine', 'status' => 'working'],
            ['key' => 'insight', 'title' => 'Insight', 'status' => 'working'],
            ['key' => 'recommendation', 'title' => 'Recommendation', 'status' => 'working'],
            ['key' => 'decision', 'title' => 'Decision Engine', 'status' => 'working'],
            ['key' => 'predictive', 'title' => 'Predictive', 'status' => 'working'],
            ['key' => 'predictive_link_module_v1', 'title' => 'Predictive Link V1', 'status' => 'working'],
            ['key' => 'time_intelligence', 'title' => 'Time Intelligence', 'status' => 'working'],
        ]
    ],
    [
        'label' => 'Graph & Entities',
        'modules' => [
            ['key' => 'graph', 'title' => 'Network Graph', 'status' => 'working'],
            ['key' => 'entity_resolution', 'title' => 'Entity Resolution', 'status' => 'working'],
            ['key' => 'relations', 'title' => 'Relations', 'status' => 'working'],
            ['key' => 'root_cause', 'title' => 'Root Cause', 'status' => 'working'],
            ['key' => 'cluster', 'title' => 'Clusters', 'status' => 'working'],
            ['key' => 'semantic_cluster', 'title' => 'Semantic Cluster', 'status' => 'working'],
            ['key' => 'cross_case_engine', 'title' => 'Cross-Case Engine', 'status' => 'working'],
        ]
    ],
    [
        'label' => 'Tools',
        'modules' => [
            ['key' => 'compare', 'title' => 'Compare', 'status' => 'working'],
            ['key' => 'view', 'title' => 'View', 'status' => 'working'],
            ['key' => 'alert', 'title' => 'Alert', 'status' => 'working'],
        ]
    ],
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

        <div class="sidebar">
            <div class="sidebar-header">All Modules</div>
            <?php foreach ($sidebarModules as $group): ?>
                <div class="sidebar-group">
                    <div class="sidebar-group-label"><?= htmlspecialchars($group['label']) ?></div>
                    <?php foreach ($group['modules'] as $mod): ?>
                        <?php
                            $isWorking = ($mod['status'] === 'working');
                            $isRegistered = isset($registry[$mod['key']]);
                            $statusClass = $isWorking && $isRegistered ? 'sidebar-link' : 'sidebar-link sidebar-link-broken';
                            $statusText = ($isWorking && $isRegistered) ? '' : ' (Not Yet Working)';
                            
                            // Preserve session/case context
                            $queryParams = ['module' => $mod['key']];
                            if (!empty($_GET['client'])) $queryParams['client'] = $_GET['client'];
                            if (!empty($_GET['session'])) $queryParams['session'] = $_GET['session'];
                            if (!empty($_GET['case'])) $queryParams['case'] = $_GET['case'];
                            
                            $href = ($isWorking && $isRegistered) ? '/commandcenter/shell.php?' . http_build_query($queryParams) : '#';
                        ?>
                        <a href="<?= $href ?>" class="<?= $statusClass ?><?= ($requestedModule === $mod['key']) ? ' sidebar-link-active' : '' ?>" <?= (!$isWorking || !$isRegistered) ? 'onclick="return false;"' : '' ?>>
                            <?= htmlspecialchars($mod['title']) ?><?= $statusText ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="main-content">
            <?php if ($requestedModule): ?>

                <div class="module-view">
                    <div class="module-view-header">
                        <a class="module-back" href="/commandcenter/shell.php">← Grand Lobby</a>
                        <h1 class="module-view-title"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $requestedModule))) ?></h1>
                    </div>
                    <div class="module-view-body">
                        <?php if ($requestedModule === 'ingest'): ?>
                            <div class="layout-grid-three-col">
                                <div class="grid-col-main">
                                    <h2 class="module-view-subtitle">Ingest New Data</h2>
                                    <?= renderModule('ingest', $registry) ?>
                                </div>
                                <div class="grid-col-side">
                                    <h2 class="module-view-subtitle">Browse Files</h2>
                                    <?= renderModule('files', $registry) ?>
                                </div>
                                <div class="grid-col-side">
                                    <h2 class="module-view-subtitle">Search Archive</h2>
                                    <?= renderModule('search', $registry) ?>
                                </div>
                            </div>
                        <?php elseif ($requestedModule === 'excavation'): ?>
                            <div class="layout-grid-uneven">
                                <div class="grid-col-main">
                                    <h2 class="module-view-subtitle">Browse Files</h2>
                                    <?= renderModule('files', $registry) ?>
                                </div>
                                <div class="grid-col-side">
                                    <h2 class="module-view-subtitle">Search Archive</h2>
                                    <?= renderModule('search', $registry) ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <?= renderModule($requestedModule, $registry, ['registry' => $registry]) ?>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>

                <div class="lobby-hero">
                    <div class="lobby-label">Sovereign Intelligence Environment</div>
                    <h1 class="lobby-title">Grand Lobby</h1>
                    <p class="lobby-text">Select a module to begin. Click any card to open the full module view, or use the sidebar to navigate all modules.</p>
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

</div>

</body>
</html>