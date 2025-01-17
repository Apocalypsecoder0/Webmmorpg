<?php
session_start();
require 'config.php'; // Database connection

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Handle content submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $body = trim($_POST['body']);
    $error = '';

    // Validate input
    if (empty($title) || empty($body)) {
        $error = "Title and body cannot be empty.";
    } else {
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO content (title, body) VALUES (?, ?)");
        if ($stmt->execute([$title, $body])) {
            header('Location: content_management.php');
            exit;
        } else {
            $error = "Failed to create content.";
        }
    }
}

// Fetch content from the database
$stmt = $pdo->query("SELECT id, title, created_at FROM content");
$content = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admincplanel.css">
    <title>Content Management</title>
</head>
<body>
    <h1>Content Management</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>
        <label for="body">Body:</label>
        <textarea name="body" required></textarea>
        <br>
        <button type="submit">Create Content</button>
    </form>
    <h2>Existing Content</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Created At</th>
        </tr>
        <?php foreach ($content as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['id']); ?></td>
            <td><?php echo htmlspecialchars($item['title']); ?></td>
            <td><?php echo htmlspecialchars($item['created_at']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="admin_cpanel.php">Back to Admin Panel</a></p>
</body>
</html>
