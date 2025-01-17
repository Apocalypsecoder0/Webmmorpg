<?php
session_start();
include 'db.php';

$userId = $_SESSION['user_id']; // Assuming user ID is stored in session

$stmt = $pdo->prepare("SELECT fleet_name, ship_count FROM fleets WHERE user_id = :user_id");
$stmt->execute(['user_id' => $userId]);
$fleets = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "<ul>";
foreach ($fleets as $fleet) {
    $output .= "<li>{$fleet['fleet_name']} - Ships: {$fleet['ship_count']}</li>";
}
$output .= "</ul>";

echo $output ? $output : 'No fleets found.';
?>
