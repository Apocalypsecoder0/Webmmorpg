<?php
include 'db.php'; // Include your database connection

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playerName = $_POST['player_name'];
    $feedbackText = $_POST['feedback_text'];

    // Insert feedback into the database
    $stmt = $pdo->prepare("INSERT INTO feedback (player_name, feedback_text) VALUES (?, ?)");
    $stmt->execute([$playerName, $feedbackText]);
}

// Fetch existing feedback
$stmt = $pdo->query("SELECT * FROM feedback ORDER BY created_at DESC");
$feedbackList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Feedback</title>
</head>
<body>
    <h1>Player Feedback</h1>

    <form method="POST">
        <label for="player_name">Your Name:</label>
        <input type="text" id="player_name" name="player_name" required>
        
        <label for="feedback_text">Your Feedback:</label>
        <textarea id="feedback_text" name="feedback_text" required></textarea>
        
        <button type="submit">Submit Feedback</button>
    </form>

    <h2>Previous Feedback</h2>
    <ul>
        <?php foreach ($feedbackList as $feedback) : ?>
            <li>
                <strong><?php echo htmlspecialchars($feedback['player_name']); ?></strong> 
                (<?php echo $feedback['created_at']; ?>): 
                <p><?php echo htmlspecialchars($feedback['feedback_text']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
