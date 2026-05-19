<?php
/* EXPECTS:
 * $title
 * $subtitle (optional)
 * $content
 * $footer (optional)
 */

?>

<div class="ui-card">
    <?php if (!empty($title)): ?>
        <div class="ui-card-title"><?= htmlspecialchars($title) ?></div>
    <?php endif; ?>

    <?php if (!empty($subtitle)): ?>
        <div class="ui-card-subtitle"><?= htmlspecialchars($subtitle) ?></div>
    <?php endif; ?>

    <div class="ui-card-body">
        <?= $content ?? '' ?>
    </div>

    <?php if (!empty($footer)): ?>
        <div class="ui-card-footer">
            <?= $footer ?>
        </div>
    <?php endif; ?>
</div>