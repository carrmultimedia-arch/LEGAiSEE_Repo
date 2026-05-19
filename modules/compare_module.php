<?php
declare(strict_types=1);

$a    = htmlspecialchars((string)($_GET['a'] ?? ''));
$b    = htmlspecialchars((string)($_GET['b'] ?? ''));
$is   = 'width:100%;padding:8px 10px;border-radius:8px;border:1px solid rgba(255,255,255,0.08);background:#111;color:#F4E185;font-size:13px;font-family:inherit;box-sizing:border-box';
$ls   = 'font-size:10px;color:#89612B;text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:4px';

ob_start(); ?>
<div style="margin-bottom:10px;font-size:12px;color:#89612B;text-transform:uppercase;letter-spacing:1px">Compare Intelligence</div>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:12px">
    <div><label style="<?= $ls ?>">Set A</label>
    <input type="text" value="<?= $a ?>" placeholder="Case ID..." style="<?= $is ?>"></div>
    <div><label style="<?= $ls ?>">Set B</label>
    <input type="text" value="<?= $b ?>" placeholder="Case ID..." style="<?= $is ?>"></div>
</div>
<?php if ($a && $b): ?>
<div class="exec-panel">
    <div class="exec-line"><span class="exec-key">Set A</span><span class="exec-value"><?= $a ?></span></div>
    <div class="exec-line"><span class="exec-key">Set B</span><span class="exec-value"><?= $b ?></span></div>
</div>
<?php else: ?>
<div class="empty">Enter two case IDs above to compare</div>
<?php endif;
return ob_get_clean();