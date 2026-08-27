<?php
/**
 * LEGAiSEE Setup - Initialize Database
 */

$db_file = 'legaisee.db';
$exists = file_exists($db_file);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new SQLite3($db_file);

        // Create chats table
        $db->exec('CREATE TABLE IF NOT EXISTS chats (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            platform TEXT,
            title TEXT,
            content TEXT,
            date_created DATETIME DEFAULT CURRENT_TIMESTAMP
        )');

        // Create clients table
        $db->exec('CREATE TABLE IF NOT EXISTS clients (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT,
            industry TEXT,
            website TEXT,
            created DATETIME DEFAULT CURRENT_TIMESTAMP
        )');

        // Create artifacts table
        $db->exec('CREATE TABLE IF NOT EXISTS artifacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            client_id INTEGER,
            title TEXT,
            era TEXT,
            channel TEXT,
            content TEXT,
            created DATETIME DEFAULT CURRENT_TIMESTAMP
        )');

        $success = true;
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Setup - LEGAiSEE</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #0a0a0f 0%, #1a1a2e 100%);
            color: #e0e0e0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .setup-box {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,215,0,0.3);
            border-radius: 20px;
            padding: 50px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .logo {
            width: 200px;
            margin-bottom: 30px;
        }
        h1 {
            color: #FFD700;
            margin-bottom: 10px;
        }
        p {
            color: #888;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #000;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        .success {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid #4CAF50;
            color: #4CAF50;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .btn-secondary {
            background: transparent;
            border: 1px solid #FFD700;
            color: #FFD700;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="setup-box">
        <img src="https://www.legaisee.com/Images/Legaisee-sm-300.png" alt="LEGAiSEE" class="logo">

        <?php if (isset($success)): ?>
            <div class="success">
                ✓ Setup Complete!
            </div>
            <p>Your LEGAiSEE Command Center is ready</p>
            <a href="index.php" class="btn">Go to Dashboard →</a>
        <?php else: ?>
            <h1>Welcome</h1>
            <p>LEGAiSEE Command Center v1.0<br>Archaeology Intelligence Platform</p>

            <?php if (isset($error)): ?>
                <div style="color: #f44336; margin-bottom: 20px;">Error: <?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($exists): ?>
                <p style="color: #4CAF50;">✓ Database already exists</p>
                <a href="index.php" class="btn">Go to Dashboard →</a>
            <?php else: ?>
                <form method="POST">
                    <button type="submit" class="btn">Initialize System</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
