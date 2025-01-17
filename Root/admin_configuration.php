<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $setting_name = $_POST['setting_name'];
    $setting_value = $_POST['setting_value'];

    $stmt = $pdo->prepare("INSERT INTO admin_settings (setting_name, setting_value) VALUES (?, ?)
                           ON DUPLICATE KEY UPDATE setting_value = ?");
    $stmt->execute([$setting_name, $setting_value, $setting_value]);
}

$settings = $pdo->query("SELECT * FROM admin_settings")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Configuration</title>
    <link rel="stylesheet" href="../css/admin_configuration.css">
</head>
<body>
    <h1>Admin Configuration</h1>
    <form method="post">
        <input type="text" name="setting_name" placeholder="Setting Name" required>
        <input type="text" name="setting_value" placeholder="Setting Value" required>
        <button type="submit">Save</button>
    </form>
    <h2>Current Settings</h2>
    <ul>
        <?php foreach ($settings as $setting): ?>
            <li><?= htmlspecialchars($setting['setting_name']) ?>: <?= htmlspecialchars($setting['setting_value']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
