<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's guild ID
$stmt = $pdo->prepare("SELECT guild_id FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$guild_id = $stmt->fetchColumn();

if (!$guild_id) {
    echo "You are not part of a guild.";
    exit();
}

// Fetch recent guild chat messages
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT gc.message, gc.sent_at, u.username 
                           FROM guild_chat gc 
                           JOIN users u ON gc.user_id = u.id 
                           WHERE gc.guild_id = ? 
                           ORDER BY gc.sent_at DESC LIMIT 50");
    $stmt->execute([$guild_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($messages);
    exit();
}

// Post a new message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO guild_chat (guild_id, user_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$guild_id, $user_id, $message]);
    }
    exit();
}
?>
