
<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's alliance ID
$stmt = $pdo->prepare("SELECT alliance_id FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$alliance_id = $stmt->fetchColumn();

if (!$alliance_id) {
    echo "You are not part of an alliance.";
    exit();
}

// Fetch recent alliance chat messages
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT ac.message, ac.sent_at, u.username 
                           FROM alliance_chat ac 
                           JOIN users u ON ac.user_id = u.id 
                           WHERE ac.alliance_id = ? 
                           ORDER BY ac.sent_at DESC LIMIT 50");
    $stmt->execute([$alliance_id]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($messages);
    exit();
}

// Post a new message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO alliance_chat (alliance_id, user_id, message) VALUES (?, ?, ?)");
        $stmt->execute([$alliance_id, $user_id, $message]);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alliance Chat</title>
    <link rel="stylesheet" href="../css/alliance_chat.css">
    <script>
        async function fetchMessages() {
            const response = await fetch('alliance_chat.php');
            const messages = await response.json();
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = messages.map(msg => 
                `<div class="chat-message">
                    <span class="chat-user">${msg.username}</span>: 
                    <span class="chat-text">${msg.message}</span>
                    <span class="chat-time">${msg.sent_at}</span>
                </div>`
            ).join('');
        }

        async function sendMessage(event) {
            event.preventDefault();
            const messageInput = document.getElementById('message-input');
            const message = messageInput.value.trim();
            if (message) {
                await fetch('alliance_chat.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `message=${encodeURIComponent(message)}`
                });
                messageInput.value = '';
                fetchMessages();
            }
        }

        setInterval(fetchMessages, 2000); // Refresh chat every 2 seconds
        document.addEventListener('DOMContentLoaded', fetchMessages);
    </script>
</head>
<body>
    <h1>Alliance Chat</h1>
    <div id="chat-box"></div>
    <form id="chat-form" onsubmit="sendMessage(event)">
        <input type="text" id="message-input" placeholder="Type your message..." required>
        <button type="submit">Send</button>
    </form>
</body>
</html>
