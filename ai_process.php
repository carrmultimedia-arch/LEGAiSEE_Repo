include 'db.php';
include 'api/prompts.php';

$job = $conn->query("SELECT * FROM processing_queue WHERE status='pending' LIMIT 1")->fetch_assoc();

if (!$job) exit;

$case_id = $job['case_id'];
$task = $job['task_type'];

$data = $conn->query("SELECT * FROM raw_data WHERE case_id=$case_id ORDER BY id DESC LIMIT 1")->fetch_assoc();

$input = $data['website_history']."\n".$data['reviews']."\n".$data['social'];

$prompt = getPrompt($task, $input);

// CALL YOUR EXISTING AIs LAYER
$output = process_ai($prompt); // <- this should already exist in your system

// STORE TASK OUTPUT
$stmt = $conn->prepare("INSERT INTO tasks (case_id, task_type, output_data) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $case_id, $task, $output);
$stmt->execute();

// MARK COMPLETE
$conn->query("UPDATE processing_queue SET status='done' WHERE id=".$job['id']);