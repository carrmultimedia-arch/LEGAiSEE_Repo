<?php
$network_id = "net_69eee12e374d30_99173905";
$file = __DIR__ . "/data/network/" . $network_id . ".json";
$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

$nodes = $data['nodes'] ?? [];
$edges = $data['edges'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Force Graph</title>

<script src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>

<style>
body { margin:0; background:#0a0a0f; color:#FFD700; }
#network { width:100%; height:100vh; }
</style>
</head>

<body>

<div id="network"></div>

<script>

const nodes = new vis.DataSet([
<?php foreach($nodes as $n): ?>
{
    id: "<?= $n['id'] ?>",
    label: "<?= $n['type'] ?> (<?= $n['strength'] ?>)",
    color: "<?= $n['type']=='anomaly' ? '#ff4444' : '#00ff88' ?>"
},
<?php endforeach; ?>
]);

const edges = new vis.DataSet([
<?php foreach($edges as $e): ?>
{ from:"<?= $e['from'] ?>", to:"<?= $e['to'] ?>" },
<?php endforeach; ?>
]);

const container = document.getElementById("network");

new vis.Network(container, {nodes,edges}, {
    physics:{enabled:true}
});
</script>

</body>
</html>