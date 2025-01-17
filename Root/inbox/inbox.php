<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch received messages
$stmt = $pdo->prepare("SELECT m.*, u.username AS sender_name 
                       FROM messages m 
                       JOIN users u ON m.sender_id = u.id 
                       WHERE m.receiver_id = ? 
                       ORDER BY m.sent_at DESC");
$stmt->execute([$user_id]);
$received_messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $receiver_name = $_POST['receiver_name'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    // Get receiver ID
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$receiver_name]);
    $receiver = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($receiver) {
        $receiver_id = $receiver['id'];
        $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, subject, body) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $receiver_id, $subject, $body]);
        $message = "Message sent successfully.";
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inbox</title>
    <link rel="stylesheet" href="../css/inbox.css">
</head>
<body>
    <h1>Inbox</h1>

    <?php if (isset($message)) echo "<p class='success'>$message</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <section>
        <h2>Received Messages</h2>
        <?php if (count($received_messages) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($received_messages as $message): ?>
                        <tr>
                            <td><?= htmlspecialchars($message['sender_name']) ?></td>
                            <td><?= htmlspecialchars($message['subject']) ?></td>
                            <td><?= $message['sent_at'] ?></td>
                            <td><button onclick="alert('<?= htmlspecialchars($message['body']) ?>')">View</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No messages received.</p>
        <?php endif; ?>
    </section>

    <section>
        <h2>Send Message</h2>
        <form method="post">
            <input type="text" name="receiver_name" placeholder="Recipient Username" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="body" placeholder="Message Body" required></textarea>
            <button type="submit" name="send_message">Send</button>
        </form>
    </section>
</body>
</html>
