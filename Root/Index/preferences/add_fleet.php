<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fleetName = $_POST['fleet_name'];
    $shipCount = $_POST['ship_count'];
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in session

    $stmt = $pdo->prepare("INSERT INTO fleets (user_id, fleet_name, ship_count) VALUES (:user_id, :fleet_name, :ship_count)");
    $stmt->execute(['user_id' => $userId, 'fleet_name' => $fleetName, 'ship_count' => $shipCount]);
}
?>
