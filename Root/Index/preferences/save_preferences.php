<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preferences = $_POST['preferences'];
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in session

    $stmt = $pdo->prepare("UPDATE users SET preferences = :preferences WHERE id = :id");
    $stmt->execute(['preferences' => $preferences, 'id' => $userId]);
}
?>
