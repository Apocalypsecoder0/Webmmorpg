<?php
include 'db.php'; // Include your database connection

// Fetch leaderboard for a specific challenge
$challengeId = $_GET['challenge_id']; // Get challenge ID from URL
$stmt = $pdo->prepare("SELECT p.username, SUM(cl.contribution) AS total_contribution 
                        FROM community_leaderboard cl 
                        JOIN players p ON cl.player_id = p.id 
                        WHERE cl.challenge_id = ? 
                        GROUP BY p.username 
                        ORDER BY total_contribution DESC");
$stmt->execute([$challengeId]);
$leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Challenge Leaderboard</title>
</head>
<body>
    <h1>Leaderboard for Challenge ID: <?php echo htmlspecialchars($challengeId); ?></h1>

    <ul>
        <?php foreach ($leaderboard as $entry) : ?>
            <li>
                <strong><?php echo htmlspecialchars($entry['username']); ?></strong>: 
                <?php echo htmlspecialchars($entry['total_contribution']); ?> contributions
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
