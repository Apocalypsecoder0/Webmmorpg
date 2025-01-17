<?php
session_start();
include 'db.php';

$userId = $_SESSION['user_id']; // Assuming user ID is stored in session

$stmt = $pdo->prepare("SELECT preferences FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$preferences = $stmt->fetchColumn();

echo $preferences ? $preferences : '';
?>
