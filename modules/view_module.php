<?php

require_once __DIR__ . '/../kernel/kernel_boot.php';

kernel_validate_runtime();
require_once __DIR__ . '/../ui/ui_engine.php';
require_once __DIR__ . '/../kernel/nav_engine.php';
require_once __DIR__ . '/../lib/semantic_diff_engine.php';
require_once __DIR__ . '/../kernel/kernel.php';
$pdo = kernel_db();

$mode = $_GET['mode'] ?? 'compare';

$a_id = $_GET['a'] ?? null;
$b_id = $_GET['b'] ?? null;

$back = kernel_nav_back();

/* LOAD */
function load_record($pdo, $id) {
    if (!$id) return null;

    $stmt = $pdo->prepare("
        SELECT p.title, pc.content
        FROM page p
        JOIN page_content pc ON p.id = pc.page_id
        WHERE p.id = :id
        LIMIT 1
    ");
    $stmt->execute(['id'=>$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$A = load_record($pdo, $a_id);
$B = load_record($pdo, $b_id);

$list = $pdo->query("SELECT id, title FROM page ORDER BY id DESC LIMIT 200")
            ->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<style>
.exec-box {
    background: var(--obsidian-raised);
    border:1px solid #222;
    padding:15px;
    margin-bottom:15px;
}

.exec-title {
    color:var(--gold);
    margin-bottom:10px;
    font-weight:bold;
}

.exec-item {
    margin-bottom:8px;
    font-size:13px;
}

.tag {
    display:inline-block;
    padding:2px 6px;
    margin-right:6px;
    font-size:10px;
    border-radius:3px;
}

.tag-risk { background:#600; }
.tag-opportunity { background:#064; }
.tag-shift { background:#665200; }
</style>

<div class="view-toolbar">
    <div>
        <?php if ($back): ?>
            <a href="<?= htmlspecialchars($back) ?>">← Back</a>
        <?php endif; ?>
    </div>

    <div>
        <a href="?module=view&mode=compare&a=<?= $a_id ?>&b=<?= $b_id ?>">Compare</a>
        <a href="?module=view&mode=semantic&a=<?= $a_id ?>&b=<?= $b_id ?>">Semantic</a>
        <a href="?module=view&mode=executive&a=<?= $a_id ?>&b=<?= $b_id ?>">Executive</a>
    </div>
</div>

<div class="compare-grid">

    <!-- LEFT CONTROL -->
    <div class="compare-col">
        <div class="compare-controls">
            <select onchange="changeFile('a', this.value)">
                <?php foreach ($list as $f): ?>
                    <option value="<?= $f['id'] ?>" <?= $f['id']==$a_id?'selected':'' ?>>
                        <?= htmlspecialchars($f['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- RIGHT CONTROL -->
    <div class="compare-col">
        <div class="compare-controls">
            <select onchange="changeFile('b', this.value)">
                <?php foreach ($list as $f): ?>
                    <option value="<?= $f['id'] ?>" <?= $f['id']==$b_id?'selected':'' ?>>
                        <?= htmlspecialchars($f['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

</div>

<div id="exec"></div>

<script>

const A = <?= json_encode($A['content'] ?? '') ?>;
const B = <?= json_encode($B['content'] ?? '') ?>;

/*
|------------------------------------------------------------
| TOKEN / SENTENCE
|------------------------------------------------------------
*/
function words(t){ return t.toLowerCase().split(/\W+/).filter(Boolean); }
function sentences(t){ return t.split(/(?<=[.?!])\s+/); }

/*
|------------------------------------------------------------
| KEYWORD CLUSTERS
|------------------------------------------------------------
*/
const signals = {
    pricing: ["price","cost","fee","$","discount"],
    offer: ["offer","package","deal","service"],
    urgency: ["limited","deadline","now","today"],
    authority: ["years","experience","expert","certified"],
    risk: ["guarantee","risk","free","refund"],
};

/*
|------------------------------------------------------------
| DETECT SIGNALS
|------------------------------------------------------------
*/
function detectSignals(text){
    let w = words(text);
    let found = {};

    for (let key in signals){
        found[key] = w.filter(x => signals[key].includes(x)).length;
    }

    return found;
}

/*
|------------------------------------------------------------
| EXEC SUMMARY
|------------------------------------------------------------
*/
function buildExecutive(a, b){

    const sa = sentences(a);
    const sb = sentences(b);

    let added = [];
    let removed = [];
    let changed = [];

    for (let s of sa){
        if (!b.includes(s)) removed.push(s);
    }

    for (let s of sb){
        if (!a.includes(s)) added.push(s);
    }

    for (let s of sa){
        for (let t of sb){
            if (s !== t && s.substring(0,40) === t.substring(0,40)){
                changed.push(t);
            }
        }
    }

    let sigA = detectSignals(a);
    let sigB = detectSignals(b);

    let signalShift = [];

    for (let k in sigA){
        let diff = sigB[k] - sigA[k];
        if (Math.abs(diff) > 1){
            signalShift.push(`${k}: ${diff > 0 ? "increase" : "decrease"}`);
        }
    }

    return {added, removed, changed, signalShift};
}

/*
|------------------------------------------------------------
| RENDER
|------------------------------------------------------------
*/
function render(){

    const d = buildExecutive(A, B);

    let html = "";

    html += `<div class="exec-box">
        <div class="exec-title">Executive Summary</div>
        <div class="exec-item"><span class="tag tag-opportunity">ADDED</span> ${d.added.length} new elements</div>
        <div class="exec-item"><span class="tag tag-risk">REMOVED</span> ${d.removed.length} removed elements</div>
        <div class="exec-item"><span class="tag tag-shift">CHANGED</span> ${d.changed.length} modified elements</div>
    </div>`;

    html += `<div class="exec-box">
        <div class="exec-title">Signal Shifts</div>
        ${d.signalShift.map(s => `<div class="exec-item">${s}</div>`).join("") || "No major shifts"}
    </div>`;

    html += `<div class="exec-box">
        <div class="exec-title">Key Additions</div>
        ${d.added.slice(0,5).map(x => `<div class="exec-item">+ ${escape(x)}</div>`).join("")}
    </div>`;

    html += `<div class="exec-box">
        <div class="exec-title">Key Removals</div>
        ${d.removed.slice(0,5).map(x => `<div class="exec-item">- ${escape(x)}</div>`).join("")}
    </div>`;

    document.getElementById("exec").innerHTML = html;
}

function escape(str){
    return str.replace(/[&<>"']/g, m => ({
        '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
    }[m]));
}

render();

function changeFile(side,id){
    const p = new URLSearchParams(window.location.search);
    p.set(side,id);
    p.set("mode","executive");
    window.location.search = p.toString();
}

</script>

<?php
$body = ob_get_clean();
return ui_page("Executive Diff", $body);