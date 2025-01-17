<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $structureName = $_POST['structure_name'];
    $level = $_POST['level'];
    $userId = $_SESSION['user_id']; // Assuming user ID is stored in session

    $stmt = $pdo->prepare("INSERT INTO structures (user_id, structure_name, level) VALUES (:user_id, :structure_name, :level)");
    $stmt->execute(['user_id' => $userId, 'structure_name' => $structureName, 'level' => $level]);
}
?>
