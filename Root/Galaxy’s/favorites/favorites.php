<?php
// favorites.php

session_start();

// Database connection parameters
$host = 'localhost';
$dbname = 'ogame_planets';
$username = 'your_username';
$password = 'your_password';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
<?php
session_start(); // Start the session

// Assuming user ID is stored in session
$user_id = $_SESSION['user_id'];

if (isset($user_id)) {
    $stmt = $pdo->prepare("SELECT * FROM favorites WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Please log in to see your favorites.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorites</title>
    <link rel="stylesheet" href="favoritesstyles.css"> <!-- Optional CSS file -->
</head>
<body>
    <h1>Your Favorite Items</h1>
    
    <?php if (count($favorites) > 0): ?>
        <ul>
            <?php foreach ($favorites as $favorite): ?>
                <li><?php echo htmlspecialchars($favorite['item_name']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You have no favorite items.</p>
    <?php endif; ?>
    
</body>
</html>



    
