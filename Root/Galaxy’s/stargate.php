<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch origin planet and its Stargate
$origin_moon_id = $_GET['planet_id'];
$stmt = $pdo->prepare("
    SELECT s.id AS stargate_id, m.name AS origin_name, d.name AS destination_name, s.travel_cost 
    FROM stargates s
    JOIN moons m ON s.origin_planet_id = m.id
    JOIN moons d ON s.destination_planet_id = d.id
    WHERE s.origin_planet_id = ?");
$stmt->execute([$origin_moon_id]);
$stargates = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Fetch origin moon and its Stargate
$origin_moon_id = $_GET['moon_id'];
$stmt = $pdo->prepare("
    SELECT s.id AS stargate_id, m.name AS origin_name, d.name AS destination_name, s.travel_cost 
    FROM stargates s
    JOIN moons m ON s.origin_moon_id = m.id
    JOIN moons d ON s.destination_moon_id = d.id
    WHERE s.origin_moon_id = ?");
$stmt->execute([$origin_moon_id]);
$stargates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Travel to destination
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stargate_id = $_POST['stargate_id'];
    $stmt = $pdo->prepare("SELECT travel_cost FROM stargates WHERE id = ?");
    $stmt->execute([$stargate_id]);
    $travel_cost = $stmt->fetchColumn();

    // Check user's resources
    $stmt = $pdo->prepare("SELECT energy FROM resources WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $energy = $stmt->fetchColumn();

    if ($energy >= $travel_cost) {
        // Deduct energy
        $stmt = $pdo->prepare("UPDATE resources SET energy = energy - ? WHERE user_id = ?");
        $stmt->execute([$travel_cost, $user_id]);
        echo "Travel successful!";
    } else {
        echo "Not enough energy to travel.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stargate</title>
    <link rel="stylesheet" href="../css/stargate.css">
</head>
<body>
    <h1>Stargate Travel</h1>
    <h2>Available Destinations from <?= htmlspecialchars($stargates[0]['origin_name']) ?></h2>
    <ul>
        <?php foreach ($stargates as $stargate): ?>
            <li>
                <form method="post">
                    <strong><?= htmlspecialchars($stargate['destination_name']) ?></strong>
                    (Cost: <?= $stargate['travel_cost'] ?> Energy)
                    <input type="hidden" name="stargate_id" value="<?= $stargate['stargate_id'] ?>">
                    <button type="submit">Travel</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
