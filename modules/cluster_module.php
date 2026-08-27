<?php
require_once __DIR__ . '/../kernel/kernel_boot.php';

kernel_validate_runtime();

$pdo = kernel_db();
$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM clusters WHERE id = ?");
$stmt->execute([$id]);
$cluster = $stmt->fetch();

$stmt = $pdo->prepare("SELECT * FROM page WHERE cluster_id = ?");
$stmt->execute([$id]);
$rows = $stmt->fetchAll();
?>

<h2><?= htmlspecialchars($cluster['name'] ?? 'Cluster') ?></h2>

<p><?= htmlspecialchars($cluster['summary'] ?? '') ?></p>

<div class="card-grid">
<?php foreach ($rows as $r): ?>
<div class="service-card">
    <h3><?= htmlspecialchars($r['title']) ?></h3>
    <a href="view.php?id=<?= $r['id'] ?>">Open</a>
</div>
<?php endforeach; ?>
</div>