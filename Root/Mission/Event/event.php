<?php
include 'db.php'; // Include your database connection

// Fetch active seasonal events
$currentDate = date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM seasonal_events WHERE start_date <= ? AND end_date >= ?");
$stmt->execute([$currentDate, $currentDate]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seasonal Events</title>
</head>
<body>
    <h1>Current Seasonal Events</h1>

    <ul>
        <?php foreach ($events as $event) : ?>
            <li>
                <strong><?php echo htmlspecialchars($event['event_name']); ?></strong>: 
                <?php echo htmlspecialchars($event['description']); ?> 
                <br>Reward: <?php echo htmlspecialchars($event['reward']); ?> points
                <br>Duration: <?php echo htmlspecialchars($event['start_date']); ?> to <?php echo htmlspecialchars($event['end_date']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
