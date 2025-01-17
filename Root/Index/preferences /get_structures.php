<?php
session_start();
include 'db.php';

$userId = $_SESSION['user_id']; // Assuming user ID is stored in session

$stmt = $pdo->prepare("SELECT structure_name, level FROM structures WHERE user_id = :user_id");
$stmt->execute(['user_id' => $userId]);
$structures = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = "<ul>";
foreach ($structures as $structure) {
    $output .= "<li>{$structure['structure_name']} - Level: {$structure['level']}</li>";
}
$output .= "</ul>";

echo $output ? $output : 'No structures found.';
?>
