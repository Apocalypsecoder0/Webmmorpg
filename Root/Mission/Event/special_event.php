<?php
include 'db.php'; // Include your database connection

// Fetch active special events
$currentDate = date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM special_events WHERE start_date <= ? AND end_date >= ?");
$stmt->execute([$currentDate, $currentDate]);
$specialEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Events</title>
</head>
<body>
    <h1>Current Special Events</h1>

    <ul>
        <?php foreach ($specialEvents as $event) : ?>
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
