<?php
session_start();
require 'config.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Fetch users from the database
$stmt = $pdo->query("SELECT id, username FROM users");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admincplanel.css">
    <title>User Management</title>
</head>
<body>
    <h1>User Management</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="admin_cpanel.php">Back to Admin Panel</a></p>
</body>
</html>
