<?php
include 'db.php'; // Include your database connection

// Fetch active missions with scenarios
$stmt = $pdo->query("SELECT m.*, s.scenario_description FROM missions m LEFT JOIN scenarios s ON m.id = s.mission_id WHERE m.is_active = TRUE");
$missions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Combat Missions</title>
</head>
<body>
    <h1>Weekly Combat Missions</h1>

    <ul>
        <?php foreach ($missions as $mission) : ?>
            <li>
                <strong><?php echo htmlspecialchars($mission['mission_name']); ?></strong>: 
                <?php echo htmlspecialchars($mission['description']); ?> 
                <br>Reward: <?php echo htmlspecialchars($mission['reward']); ?> points
                <br>Scenario: <?php echo htmlspecialchars($mission['scenario_description']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
