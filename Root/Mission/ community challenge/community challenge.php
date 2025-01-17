<?php
include 'db.php'; // Include your database connection

// Fetch active community challenges
$currentDate = date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM community_challenges WHERE start_date <= ? AND end_date >= ? AND is_active = TRUE");
$stmt->execute([$currentDate, $currentDate]);
$communityChallenges = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Challenges</title>
</head>
<body>
    <h1>Community Challenges</h1>

    <ul>
        <?php foreach ($communityChallenges as $challenge) : ?>
            <li>
                <strong><?php echo htmlspecialchars($challenge['challenge_name']); ?></strong>: 
                <?php echo htmlspecialchars($challenge['description']); ?> 
                <br>Target: <?php echo htmlspecialchars($challenge['target_count']); ?> resources
                <br>Current Progress: <?php echo htmlspecialchars($challenge['current_count']); ?> resources
                <br>Reward: <?php echo htmlspecialchars($challenge['reward']); ?> points
                <br>Duration: <?php echo htmlspecialchars($challenge['start_date']); ?> to <?php echo htmlspecialchars($challenge['end_date']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
