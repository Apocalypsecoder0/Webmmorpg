<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's moons
$stmt = $pdo->prepare("
    SELECT m.id, m.name, p.name AS planet_name 
    FROM moons m 
    JOIN planets p ON m.planet_id = p.id 
    WHERE p.owner_id = ?");
$stmt->execute([$user_id]);
$moons = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moons</title>
    <link rel="stylesheet" href="../css/moons.css">
</head>
<body>
    <h1>Your Moons</h1>
    <ul>
        <?php foreach ($moons as $moon): ?>
            <li>
                <strong><?= htmlspecialchars($moon['name']) ?></strong> 
                (Orbiting: <?= htmlspecialchars($moon['planet_name']) ?>)
                <a href="stargate.php?moon_id=<?= $moon['id'] ?>">Enter Stargate</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
