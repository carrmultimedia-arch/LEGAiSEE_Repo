<?php
/**
 * plain_english_helper.php
 * LEGAiSEE — Plain English Output Interpreter
 *
 * Every module currently shows raw numbers.
 * This helper converts them into sentences a client can read.
 *
 * Usage:
 *   require_once KERNEL_ROOT . 'engine/plain_english_helper.php';
 *   echo lee_interpret('entities', ['count' => 12, 'top_types' => ['PERSON' => 5, 'ORG' => 4]]);
 *
 * Location: engine/plain_english_helper.php
 */

if (!defined('KERNEL_ROOT')) {
    die('Direct access not permitted.');
}

// ─────────────────────────────────────────────────────────────────────────────
// Master dispatcher
// ─────────────────────────────────────────────────────────────────────────────

function lee_interpret(string $module, array $data): string {
    $fn = 'lee_interpret_' . $module;
    if (function_exists($fn)) {
        return $fn($data);
    }
    return lee_interpret_generic($module, $data);
}

/**
 * Wrap interpretation in a styled block for embedding in any module.
 */
function lee_interpret_block(string $module, array $data, string $heading = 'What This Means'): string {
    $text = lee_interpret($module, $data);
    if (!$text) return '';
    return '<div class="lee-plain-english">
        <div class="lee-pe-heading">' . htmlspecialchars($heading) . '</div>
        <div class="lee-pe-text">' . nl2br(htmlspecialchars($text)) . '</div>
    </div>
    <style>
    .lee-plain-english { background: rgba(137,97,43,.1); border: 1px solid rgba(244,225,133,.18);
        border-radius: 8px; padding: .8rem 1rem; margin: .8rem 0; }
    .lee-pe-heading { font-size: .7rem; text-transform: uppercase; letter-spacing: .06em;
        color: #89612B; margin-bottom: .4rem; font-weight: 700; }
    .lee-pe-text { font-size: .88rem; color: #c8bfa8; line-height: 1.6; }
    </style>';
}

// ─────────────────────────────────────────────────────────────────────────────
// Module-specific interpreters
// ─────────────────────────────────────────────────────────────────────────────

/**
 * relations — case/client relationship map, pattern co-occurrence
 * Expected keys: case_count, client_count, pattern_pairs, top_pattern
 */
function lee_interpret_relations(array $d): string {
    $cases   = intval($d['case_count']   ?? 0);
    $clients = intval($d['client_count'] ?? 0);
    $pairs   = intval($d['pattern_pairs'] ?? 0);
    $top     = $d['top_pattern'] ?? '';

    if ($cases === 0) {
        return "No case relationships have been mapped yet. Once cases are populated, this view will show how clients, cases, and patterns connect to each other.";
    }

    $out = "The system has mapped {$cases} " . ($cases === 1 ? 'case' : 'cases')
         . " across {$clients} " . ($clients === 1 ? 'client' : 'clients') . ". ";

    if ($pairs > 0) {
        $out .= "There are {$pairs} co-occurring pattern " . ($pairs === 1 ? 'pair' : 'pairs')
             . " — situations where the same business pattern appears in more than one case. ";
        if ($top) {
            $out .= "The most common recurring pattern is: {$top}. This suggests a systemic issue worth highlighting in authority reports.";
        }
    } else {
        $out .= "No co-occurring patterns have emerged yet — this may change as more cases are added.";
    }
    return $out;
}

/**
 * graph — entity and relationship counts
 * Expected keys: entity_count, relationship_count, entity_types, density
 */
function lee_interpret_graph(array $d): string {
    $ents = intval($d['entity_count']        ?? 0);
    $rels = intval($d['relationship_count']  ?? 0);
    $types = $d['entity_types'] ?? [];

    if ($ents === 0) {
        return "The knowledge graph is empty. Run an excavation on a client's artifacts to begin extracting entities and their relationships.";
    }

    $out = "The knowledge graph contains {$ents} named " . ($ents === 1 ? 'entity' : 'entities')
         . " and {$rels} " . ($rels === 1 ? 'relationship' : 'relationships') . ". ";

    if (!empty($types)) {
        $type_parts = [];
        foreach ($types as $type => $count) {
            $type_parts[] = "{$count} " . strtolower($type) . ($count > 1 ? 's' : '');
        }
        $out .= "Breakdown: " . implode(', ', $type_parts) . ". ";
    }

    $ratio = $ents > 0 ? round($rels / $ents, 1) : 0;
    if ($ratio >= 2) {
        $out .= "With {$ratio} relationships per entity on average, the network is well-connected — strong candidate for pattern analysis.";
    } elseif ($ratio >= 1) {
        $out .= "The network is taking shape with {$ratio} relationships per entity. More excavation will strengthen the connections.";
    } else {
        $out .= "Relationships are sparse so far. The extraction engine needs more source material to draw meaningful connections.";
    }
    return $out;
}

/**
 * anomaly — risk signals
 * Expected keys: risk_level (LOW/MEDIUM/HIGH/CRITICAL), anomaly_count, top_signal
 */
function lee_interpret_anomaly(array $d): string {
    $level  = strtoupper($d['risk_level']    ?? 'LOW');
    $count  = intval($d['anomaly_count']     ?? 0);
    $signal = $d['top_signal'] ?? '';

    $level_desc = [
        'LOW'      => "No significant anomalies detected. The data appears consistent and internally coherent.",
        'MEDIUM'   => "Some inconsistencies detected. These may be worth investigating before finalizing a report.",
        'HIGH'     => "Notable anomalies found. These signals suggest data conflicts or patterns that need operator review before any report is issued.",
        'CRITICAL' => "Critical anomalies detected. Do not issue a report until these are resolved — the data contains serious contradictions or red flags.",
    ];

    $out = $level_desc[$level] ?? "Risk level: {$level}.";

    if ($count > 0) {
        $out .= " {$count} specific " . ($count === 1 ? 'anomaly was' : 'anomalies were') . " flagged.";
        if ($signal) {
            $out .= " The most significant signal: {$signal}.";
        }
    }
    return $out;
}

/**
 * insight — case status distribution, trends
 * Expected keys: status_distribution (array), dominant_status, total
 */
function lee_interpret_insight(array $d): string {
    $total  = intval($d['total'] ?? 0);
    $dist   = $d['status_distribution'] ?? [];
    $dom    = $d['dominant_status'] ?? '';

    if ($total === 0) {
        return "No case data to interpret yet. Add cases to see pattern insights.";
    }

    $out = "Across {$total} " . ($total === 1 ? 'case' : 'cases') . ", ";

    if ($dom) {
        $dom_count = $dist[$dom] ?? 0;
        $pct = $total > 0 ? round(($dom_count / $total) * 100) : 0;
        $out .= "the most common status is '{$dom}' ({$dom_count} " . ($dom_count === 1 ? 'case' : 'cases')
             . ", {$pct}% of total). ";
    }

    if (count($dist) > 1) {
        $out .= "The case mix shows " . count($dist) . " distinct statuses, indicating an active and varied pipeline.";
    } else {
        $out .= "All cases share the same status — the pipeline may need diversification.";
    }
    return $out;
}

/**
 * recommendation — suggested next actions
 * Expected keys: recommendation_count, top_recommendation, confidence
 */
function lee_interpret_recommendation(array $d): string {
    $count  = intval($d['recommendation_count'] ?? 0);
    $top    = $d['top_recommendation'] ?? '';
    $conf   = floatval($d['confidence'] ?? 0);

    if ($count === 0) {
        return "No recommendations generated yet. The system needs more case data and confirmed entity relationships to produce meaningful recommendations.";
    }

    $out = "The system has generated {$count} " . ($count === 1 ? 'recommendation' : 'recommendations')
         . " based on current data. ";

    if ($top) {
        $out .= "Top priority: {$top}. ";
    }

    if ($conf >= 0.8) {
        $out .= "Confidence is high — these recommendations are well-supported by the data.";
    } elseif ($conf >= 0.5) {
        $out .= "Confidence is moderate. Review the supporting evidence before acting on these.";
    } else {
        $out .= "Confidence is low — more data needed before these recommendations should be acted on.";
    }
    return $out;
}

/**
 * cluster — semantic groupings
 * Expected keys: cluster_count, largest_cluster_size, top_theme
 */
function lee_interpret_cluster(array $d): string {
    $clusters = intval($d['cluster_count'] ?? 0);
    $largest  = intval($d['largest_cluster_size'] ?? 0);
    $theme    = $d['top_theme'] ?? '';

    if ($clusters === 0) {
        return "No clusters formed yet. The clustering engine needs entities and documents to work with.";
    }

    $out = "The system has identified {$clusters} semantic " . ($clusters === 1 ? 'cluster' : 'clusters')
         . " — groups of related content that share a common thread. ";

    if ($largest > 0) {
        $out .= "The largest cluster contains {$largest} " . ($largest === 1 ? 'item' : 'items') . ". ";
    }
    if ($theme) {
        $out .= "The dominant theme across clusters is: {$theme}.";
    }
    return $out;
}

/**
 * cross_case — patterns appearing across multiple clients
 * Expected keys: pattern_count, client_overlap_count, top_cross_pattern
 */
function lee_interpret_cross_case(array $d): string {
    $patterns = intval($d['pattern_count'] ?? 0);
    $overlap  = intval($d['client_overlap_count'] ?? 0);
    $top      = $d['top_cross_pattern'] ?? '';

    if ($patterns === 0) {
        return "Cross-case intelligence requires data from multiple clients. Once you have 2+ clients with excavated cases, this module will surface patterns that no single client would see on their own.";
    }

    $out = "The system has detected {$patterns} " . ($patterns === 1 ? 'pattern' : 'patterns')
         . " appearing across {$overlap} " . ($overlap === 1 ? 'client' : 'clients') . ". ";

    if ($top) {
        $out .= "The most significant cross-client pattern: {$top}. ";
    }
    $out .= "This cross-client intelligence is a competitive moat — insights derived from aggregate patterns that individual clients cannot see themselves.";
    return $out;
}

/**
 * time_intelligence — trend analysis
 * Expected keys: trend_direction (up/down/flat), active_window, peak_period, event_count
 */
function lee_interpret_time_intelligence(array $d): string {
    $direction  = strtolower($d['trend_direction'] ?? 'flat');
    $window     = $d['active_window'] ?? '';
    $peak       = $d['peak_period']   ?? '';
    $events     = intval($d['event_count'] ?? 0);

    if ($events === 0) {
        return "No temporal data yet. As events, documents, and cases are added with dates, this module will show activity trends over time.";
    }

    $trend_map = [
        'up'   => "Activity is trending upward",
        'down' => "Activity is trending downward",
        'flat' => "Activity has been relatively stable",
    ];
    $out = ($trend_map[$direction] ?? "Trend: {$direction}") . " across {$events} tracked "
         . ($events === 1 ? 'event' : 'events') . ". ";

    if ($window)  $out .= "Active window: {$window}. ";
    if ($peak)    $out .= "Peak activity period: {$peak}.";
    return $out;
}

// ─────────────────────────────────────────────────────────────────────────────
// Generic fallback
// ─────────────────────────────────────────────────────────────────────────────

function lee_interpret_generic(string $module, array $data): string {
    $total = 0;
    foreach ($data as $v) {
        if (is_numeric($v)) $total += $v;
    }
    if ($total === 0) {
        return "This module is ready but has no data yet.";
    }
    return "The {$module} module is active with data loaded. Review the figures above for details.";
}