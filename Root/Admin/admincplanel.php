<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admincplanel.css">
    <title>Admin Control Panel</title>
</head>
<body>
    <h1>Welcome to the Admin Control Panel</h1>
    <p><a href="logout.php">Logout</a></p>
    <!-- Add more admin functionalities here -->
</body>
</html>
