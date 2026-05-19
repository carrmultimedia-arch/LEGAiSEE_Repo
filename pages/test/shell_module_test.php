<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (file_exists(__DIR__ . '/kernel/kernel_boot.php')) {
    require_once __DIR__ . '/kernel/kernel_boot.php';
}
if (file_exists(__DIR__ . '/modules/utils/bootstrap.php')) {
    require_once __DIR__ . '/modules/utils/bootstrap.php';
}
require_once __DIR__ . '/modules/utils/uic_v1.php';

function renderModule($name) {
    static $loaded = [];
    $file = __DIR__ . "/modules/{$name}_module.php";
    if (!file_exists($file)) {
        return "<div class='empty'>Module not built yet: {$name}</div>";
    }
    // prevent double-loading same module
    if (isset($loaded[$name])) {
        return "<div class='empty'>Already loaded: {$name}</div>";
    }
    $loaded[$name] = true;
    try {
        $result = require $file;
        if (is_string($result)) return $result;
        if (is_array($result)) {
            if (isset($result[0]['type'])) {
                $html = '';
                foreach ($result as $item) { $html .= uic_render($item); }
                return $html;
            }
            if (isset($result['type'])) return uic_render($result);
            $html = "<div class='exec-panel'>";
            foreach ($result as $k => $v) {
                if (is_array($v)) $v = count($v) . " records";
                $html .= "<div class='exec-line'>
                    <span class='exec-key'>" . htmlspecialchars((string)$k) . "</span>
                    <span class='exec-value'>" . htmlspecialchars((string)$v) . "</span>
                </div>";
            }
            return $html . "</div>";
        }
        return "<div class='data-text'>" . htmlspecialchars((string)$result) . "</div>";
    } catch (Throwable $e) {
        return "<div class='error'>" . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

// Wing definition — label, title, module name
$wings = [
    ['Executive Intelligence',   'Strategic Command',         'intelligence_dashboard'],
    ['Dashboard',                'System Dashboard',          'dashboard'],
    ['Excavation Wing',          'Artifact Recovery',         'excavation'],
    ['Files',                    'File Inspector',            'files'],
    ['Relationship Intelligence','Network Observatory',       'graph'],
    ['Client Vault',             'Sovereign Vault',           'clients'],
    ['Cases',                    'Cases',                     'cases'],
    ['Brain',                    'Brain',                     'brain'],
    ['Memory / Ingest',          'AI Memory Bank',            'ingest'],
    ['Anomaly',                  'Anomalies',                 'anomaly_engine'],
    ['Cluster',                  'Cluster',                   'cluster'],
    ['Compare',                  'Compare',                   'compare'],
    ['Decision',                 'Decision Engine',           'decision'],
    ['Entity Resolution',        'Entity Resolution',         'entity_resolution'],
    ['Insight',                  'Insight Engine',            'insight'],
    ['Predictive',               'Predictive',                'predictive'],
    ['Recommendation',           'Recommendation',            'recommendation'],
    ['Relations',                'Relations',                 'relations'],
    ['Report',                   'Report',                    'report'],
    ['Root Cause',               'Root Cause Graph',          'root_cause_graph'],
    ['Search',                   'Search',                    'search'],
    ['Semantic Cluster',         'Semantic Cluster',          'semantic_cluster_module_v1'],
    ['Time Intelligence',        'Time Intelligence',         'time_intelligence'],
    ['Vault',                    'Vault',                     'vault'],
    ['View',                     'View',                      'view'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LEGAiSEE — Grand Lobby</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
html,body{width:100%;min-height:100%;overflow-x:hidden}
body{font-family:Inter,system-ui,sans-serif;color:#CDAD69;
background:linear-gradient(rgba(0,0,0,0.70),rgba(0,0,0,0.82)),
url('/commandcenter/ui/images/dark-room-with-black-wall-black-wall-with-carved-design_902639-63079-upscale-4x.jpg');
background-size:cover;background-position:center;background-attachment:fixed}
body::before{content:"";position:fixed;inset:0;
background:radial-gradient(circle at center,rgba(0,0,0,0.08) 0%,rgba(0,0,0,0.55) 55%,rgba(0,0,0,0.90) 100%);
pointer-events:none;z-index:0}
*::-webkit-scrollbar{width:6px}
*::-webkit-scrollbar-track{background:transparent}
*::-webkit-scrollbar-thumb{background:linear-gradient(#e6c256,#ce9008,#e7ca5d);border-radius:999px}
.topbar{position:sticky;top:0;z-index:100;width:100%;height:88px;display:flex;align-items:center;
justify-content:space-between;padding:0 50px;backdrop-filter:blur(18px);
background:linear-gradient(rgba(10,10,10,0.60),rgba(10,10,10,0.35));
border-bottom:1px solid rgba(255,255,255,0.05);box-shadow:0 10px 40px rgba(0,0,0,0.55)}
.brand{display:flex;flex-direction:column;gap:4px}
.brand-title{font-size:18px;letter-spacing:4px;color:#F4E185;font-weight:300}
.brand-sub{font-size:11px;letter-spacing:2px;color:#89612B;text-transform:uppercase}
.nav{display:flex;gap:10px;flex-wrap:wrap}
.nav a{text-decoration:none;color:#CDAD69;padding:8px 14px;border-radius:999px;
background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);font-size:12px;transition:0.3s}
.nav a:hover{color:#F4E185;border-color:rgba(230,194,86,0.35);transform:translateY(-2px)}
.lobby{position:relative;z-index:2;width:100%;max-width:1800px;margin:auto;padding:70px 50px 120px}
.hero{margin-bottom:60px;padding:70px;border-radius:32px;
background:linear-gradient(180deg,rgba(22,22,24,0.78),rgba(10,10,12,0.62));
backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,0.05);
box-shadow:0 40px 100px rgba(0,0,0,0.70),inset 0 1px 0 rgba(255,255,255,0.04);
position:relative;overflow:hidden}
.hero::before{content:"";position:absolute;inset:0;
background:radial-gradient(circle at top center,rgba(244,225,133,0.08),transparent 55%);pointer-events:none}
.hero-label{font-size:12px;letter-spacing:3px;text-transform:uppercase;color:#89612B;margin-bottom:24px}
.hero-title{font-size:72px;line-height:0.95;font-weight:200;color:#F4E185;max-width:1000px;margin-bottom:30px}
.hero-text{max-width:820px;font-size:18px;line-height:1.8;color:#AC8B56}
.wing-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(380px,1fr));gap:40px}
.wing{position:relative;border-radius:28px;padding:28px;overflow:hidden;
background:linear-gradient(180deg,rgba(24,24,26,0.82),rgba(10,10,12,0.72));
backdrop-filter:blur(18px);border:1px solid rgba(255,255,255,0.05);
box-shadow:0 30px 80px rgba(0,0,0,0.65),inset 0 1px 0 rgba(255,255,255,0.04);
transition:transform 0.45s ease,border-color 0.45s ease,box-shadow 0.45s ease}
.wing:hover{transform:translateY(-8px);border-color:rgba(230,194,86,0.28);
box-shadow:0 45px 110px rgba(0,0,0,0.82),0 0 30px rgba(230,194,86,0.08)}
.wing::before{content:"";position:absolute;top:-20%;left:-10%;width:140%;height:120%;
background:radial-gradient(circle,rgba(244,225,133,0.06),transparent 60%);pointer-events:none}
.pedestal{position:relative;margin-top:26px;padding:24px;border-radius:22px;
background:linear-gradient(180deg,rgba(38,38,42,0.92),rgba(16,16,18,0.92));
border:1px solid rgba(255,255,255,0.03);
box-shadow:inset 0 1px 0 rgba(255,255,255,0.03),0 25px 45px rgba(0,0,0,0.55);
overflow:hidden;min-width:0;max-width:100%}
.pedestal *{min-width:0;max-width:100%}
.wing-label{font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#89612B;margin-bottom:16px}
.wing-title{font-size:34px;font-weight:300;color:#F4E185;margin-bottom:14px}
.wing-text{color:#AC8B56;line-height:1.8;font-size:15px}
.exec-panel{display:flex;flex-direction:column;gap:10px}
.exec-line{display:flex;justify-content:space-between;align-items:flex-start;gap:20px;padding:12px 14px;
border-radius:12px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.03)}
.exec-key{color:#89612B;flex:0 0 140px;min-width:0;word-break:break-word;font-size:13px}
.exec-value{color:#F4E185;flex:1;min-width:0;text-align:right;word-break:break-word;font-size:13px}
.data-text{width:100%;word-break:break-word;line-height:1.7;color:#CDAD69;font-size:13px}
.uic-card{margin-bottom:12px}
.uic-title{color:#F4E185;font-size:14px;font-weight:500;margin-bottom:6px}
.uic-summary{color:#AC8B56;font-size:12px;line-height:1.7;margin-bottom:10px}
.uic-label{color:#89612B;font-size:10px;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px}
.uic-signal{color:#CDAD69;font-size:12px;padding:2px 0;line-height:1.6}
.uic-footer{color:#89612B;font-size:11px;margin-top:8px}
.uic-system{color:#89612B;font-size:12px;font-style:italic;padding:6px 0;
border-top:1px solid rgba(255,255,255,0.04);margin-top:8px}
.empty{color:#89612B;font-size:12px;font-style:italic}
.error{color:#ff7d7d;font-size:12px}
@media(max-width:768px){
    .topbar{padding:0 20px;flex-direction:column;height:auto;gap:12px;padding:16px 20px}
    .hero{padding:40px}.hero-title{font-size:40px}.lobby{padding:30px 20px 60px}}
</style>
</head>
<body>

<div class="topbar">
    <div class="brand">
        <div class="brand-title">LEGAiSEE</div>
        <div class="brand-sub">Business Archaeology Operating System</div>
    </div>
    <div class="nav">
        <a href="/commandcenter/shell.php">Lobby</a>
        <a href="/commandcenter/ingest.php">Ingest</a>
        <a href="#">Clients</a>
        <a href="#">Cases</a>
        <a href="#">Reports</a>
    </div>
</div>

<div class="lobby">
    <section class="hero">
        <div class="hero-label">Sovereign Intelligence Environment</div>
        <h1 class="hero-title">The Grand Lobby</h1>
        <div class="hero-text">
            LEGAiSEE is an executive-grade business archaeology and authority reconstruction
            environment designed to recover, synthesize, and reposition abandoned institutional
            intelligence into modern strategic authority systems.
        </div>
    </section>

    <section class="wing-grid">
        <?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| BRAIN MODULE
|--------------------------------------------------------------------------
| SYSTEM INTELLIGENCE INSPECTION LAYER
|--------------------------------------------------------------------------
| - NO UI LOGIC
| - NO FILE WRITING
| - READ-ONLY SYSTEM AWARENESS
|--------------------------------------------------------------------------
*/

$modules = require __DIR__ . '/../kernel/module_registry.php';

$dataRoot = __DIR__ . '/../data';

function dir_summary(string $path): array
{
    if (!is_dir($path)) {
        return [
            'exists' => false,
            'path' => $path,
            'count' => 0
        ];
    }

    $items = array_values(array_filter(scandir($path), function ($f) {
        return $f !== '.' && $f !== '..';
    }));

    return [
        'exists' => true,
        'path' => $path,
        'count' => count($items)
    ];
}

$brain = [

    'system' => [
        'status' => 'ACTIVE',
        'mode' => 'INSPECTION_ONLY',
        'shell' => 'CONNECTED'
    ],

    'modules' => [
        'registered_count' => count($modules),
        'active_modules' => array_keys($modules)
    ],

    'data_layer' => [
        'files' => dir_summary($dataRoot . '/files'),
        'clients' => dir_summary($dataRoot . '/clients'),
        'cases' => dir_summary($dataRoot . '/cases'),
        'memory' => dir_summary($dataRoot . '/memory'),
    ],

    'engines' => [
        'cross_case_engine' => file_exists(__DIR__ . '/../system/cross_case_engine.php'),
        'insight_engine' => file_exists(__DIR__ . '/../system/system_insight_engine.php'),
        'decision_engine' => file_exists(__DIR__ . '/../system/decision_engine_v2.php'),
        'recommendation_engine' => file_exists(__DIR__ . '/../system/system_recommendation_engine.php'),
        'policy_engine' => file_exists(__DIR__ . '/../system/policy_enforcement_engine.php'),
    ],

    'health' => [
        'data_layer_ready' =>
            is_dir($dataRoot . '/files') &&
            is_dir($dataRoot . '/clients') &&
            is_dir($dataRoot . '/cases') &&
            is_dir($dataRoot . '/memory')
    ]
];

return [
    'title' => 'Brain',
    'type' => 'inspector',
    'items' => [
        [
            'title' => 'System Status',
            'meta' => $brain['system']['status'],
            'content' => json_encode($brain['system'], JSON_PRETTY_PRINT)
        ],
        [
            'title' => 'Module Registry',
            'meta' => count($modules) . ' modules',
            'content' => json_encode($brain['modules'], JSON_PRETTY_PRINT)
        ],
        [
            'title' => 'Data Layer',
            'meta' => $brain['health']['data_layer_ready'] ? 'READY' : 'INCOMPLETE',
            'content' => json_encode($brain['data_layer'], JSON_PRETTY_PRINT)
        ],
        [
            'title' => 'Engines',
            'meta' => 'system scan',
            'content' => json_encode($brain['engines'], JSON_PRETTY_PRINT)
        ]
    ] 
];
  
