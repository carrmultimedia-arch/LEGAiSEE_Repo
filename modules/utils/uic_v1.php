<?php
declare(strict_types=1);

if (!function_exists('uic_artifact')) {
    function uic_artifact(string $title, string $summary = '', array $signals = [], array $entities = [], float $confidence = 0.0, array $meta = []): array {
        return ["type"=>"artifact","title"=>$title,"summary"=>$summary,"signals"=>$signals,"entities"=>$entities,"confidence"=>$confidence,"timestamp"=>date('c'),"meta"=>$meta];
    }
}

if (!function_exists('uic_dataset')) {
    function uic_dataset(array $records, string $source = 'unknown', array $meta = []): array {
        return ["type"=>"dataset","records"=>$records,"meta"=>array_merge(["count"=>count($records),"source"=>$source,"timestamp"=>date('c')],$meta)];
    }
}

if (!function_exists('uic_system')) {
    function uic_system(string $message, array $meta = []): array {
        return ["type"=>"system","message"=>$message,"timestamp"=>date('c'),"meta"=>$meta];
    }
}

if (!function_exists('uic_render')) {
    function uic_render($data): string {
        if (!is_array($data)) return "<div class='data-text'>" . htmlspecialchars((string)$data) . "</div>";
        if (!isset($data['type'])) return render_generic($data);
        switch ($data['type']) {
            case 'artifact':  return render_artifact($data);
            case 'dataset':   return render_dataset($data);
            case 'system':    return render_system($data);
            case 'list':      return render_list($data);
            case 'grid':      return render_grid($data);
            default:          return render_generic($data);
        }
    }
}

/* =====================================================
 * SHARED STYLE CONSTANTS
 * ===================================================== */

function uic_input_style(): string {
    return 'width:100%;padding:8px 10px;border-radius:8px;border:1px solid rgba(255,255,255,0.08);background:#111;color:#F4E185;font-size:13px;font-family:inherit;box-sizing:border-box';
}

function uic_label_style(): string {
    return 'display:block;font-size:10px;color:#89612B;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px';
}

/* =====================================================
 * TRUNCATE HELPER — prevents content overflow
 * ===================================================== */

function uic_truncate(string $content, int $maxLen = 200): string {
    if (strlen($content) <= $maxLen) return $content;
    return substr($content, 0, $maxLen) . '…';
}

/* =====================================================
 * RENDERERS
 * ===================================================== */

function render_artifact(array $a): string {
    $signals = '';
    foreach ($a['signals'] ?? [] as $s) {
        $signals .= "<div class='uic-signal'>• " . htmlspecialchars((string)$s) . "</div>";
    }
    return "<div class='uic-card'>
        <div class='uic-title'>" . htmlspecialchars($a['title'] ?? '') . "</div>
        <div class='uic-summary'>" . htmlspecialchars($a['summary'] ?? '') . "</div>
        <div class='uic-block'><div class='uic-label'>Signals</div>{$signals}</div>
        <div class='uic-footer'>Confidence: " . number_format(($a['confidence'] ?? 0) * 100, 1) . "%</div>
    </div>";
}

function render_dataset(array $d): string {
    $html = "<div class='exec-panel'>";
    foreach ($d['records'] ?? [] as $row) {
        $metric = htmlspecialchars((string)($row['metric'] ?? $row['title'] ?? ''));
        $value  = htmlspecialchars((string)($row['value'] ?? $row['meta'] ?? ''));
        $status = htmlspecialchars((string)($row['status'] ?? ''));
        $html .= "<div class='exec-line'>
            <span class='exec-key'>{$metric}</span>
            <span class='exec-value'>{$value} <span style='color:#89612B;font-size:11px'>{$status}</span></span>
        </div>";
    }
    return $html . "</div>";
}

function render_system(array $s): string {
    return "<div class='uic-system'>" . htmlspecialchars((string)($s['message'] ?? '')) . "</div>";
}

function render_list(array $d): string {
    $items = $d['items'] ?? [];
    if (empty($items)) return "<div class='empty'>No items found</div>";
    $html = "<div class='exec-panel'>";
    foreach ($items as $item) {
        $title   = htmlspecialchars((string)($item['title'] ?? ''));
        $meta    = htmlspecialchars((string)($item['meta'] ?? ''));
        $content = (string)($item['content'] ?? '');
        $decoded = json_decode($content, true);
        if (is_array($decoded)) {
            $inner = "<div class='exec-panel' style='margin-top:8px'>";
            foreach ($decoded as $k => $v) {
                $kk = htmlspecialchars((string)$k);
                $vv = is_array($v)
                    ? htmlspecialchars(uic_truncate(json_encode($v), 120))
                    : htmlspecialchars(uic_truncate((string)$v, 120));
                $inner .= "<div class='exec-line'>
                    <span class='exec-key'>{$kk}</span>
                    <span class='exec-value'>{$vv}</span>
                </div>";
            }
            $content_html = $inner . "</div>";
        } else {
            $content_html = "<span class='data-text'>" . htmlspecialchars(uic_truncate($content, 300)) . "</span>";
        }
        $html .= "<div class='exec-line' style='flex-direction:column;align-items:flex-start;gap:6px'>
            <span class='exec-key'>{$title} <span style='color:#89612B;font-size:11px'>{$meta}</span></span>
            <div style='width:100%;overflow:hidden'>{$content_html}</div>
        </div>";
    }
    return $html . "</div>";
}

function render_grid(array $d): string {
    $items = $d['items'] ?? [];
    if (empty($items)) return "<div class='empty'>No files found — add artifacts via the Excavation pipeline</div>";
    $html = "<div class='exec-panel'>";
    foreach ($items as $item) {
        $title = htmlspecialchars(uic_truncate((string)($item['title'] ?? $item['name'] ?? 'Untitled'), 60));
        $meta  = htmlspecialchars((string)($item['meta'] ?? $item['type'] ?? ''));
        $html .= "<div class='exec-line'>
            <span class='exec-key'>{$title}</span>
            <span class='exec-value'>{$meta}</span>
        </div>";
    }
    return $html . "</div>";
}

function render_generic(array $d): string {
    $items = $d['items'] ?? $d['records'] ?? [];
    if (empty($items)) {
        // Try key=>value rendering for flat arrays
        $skip = ['type','title','timestamp'];
        $html = "<div class='exec-panel'>";
        $hasRows = false;
        foreach ($d as $k => $v) {
            if (in_array($k, $skip) || is_array($v)) continue;
            $hasRows = true;
            $html .= "<div class='exec-line'>
                <span class='exec-key'>" . htmlspecialchars((string)$k) . "</span>
                <span class='exec-value'>" . htmlspecialchars(uic_truncate((string)$v, 100)) . "</span>
            </div>";
        }
        if (!$hasRows) {
            $msg = $d['message'] ?? $d['title'] ?? 'No data';
            return "<div class='empty'>" . htmlspecialchars((string)$msg) . "</div>";
        }
        return $html . "</div>";
    }
    $html = "<div class='exec-panel'>";
    foreach ($items as $item) {
        if (!is_array($item)) {
            $html .= "<div class='exec-line'><span class='exec-value'>" . htmlspecialchars(uic_truncate((string)$item, 100)) . "</span></div>";
            continue;
        }
        $title = htmlspecialchars(uic_truncate((string)($item['title'] ?? $item['metric'] ?? $item['name'] ?? $item['label'] ?? ''), 60));
        $meta  = htmlspecialchars(uic_truncate((string)($item['meta'] ?? $item['status'] ?? $item['value'] ?? $item['count'] ?? ''), 60));
        $html .= "<div class='exec-line'>
            <span class='exec-key'>{$title}</span>
            <span class='exec-value'>{$meta}</span>
        </div>";
    }
    return $html . "</div>";
}

function render_fallback($data): string {
    return "<div class='data-text' style='font-size:11px;overflow:hidden;word-break:break-word'>"
        . htmlspecialchars(uic_truncate(print_r($data, true), 400))
        . "</div>";
}

/* =====================================================
 * DROPDOWN STYLE HELPER
 * Use this in any module that renders <select> elements
 * ===================================================== */

function uic_select(string $name, array $options, string $selected = ''): string {
    $style = uic_input_style();
    $html  = "<select name='{$name}' style='{$style}'>";
    foreach ($options as $val => $label) {
        $sel   = ($val == $selected) ? "selected" : "";
        $vv    = htmlspecialchars((string)$val);
        $ll    = htmlspecialchars((string)$label);
        $html .= "<option value='{$vv}' style='background:#111;color:#F4E185' {$sel}>{$ll}</option>";
    }
    return $html . "</select>";
}