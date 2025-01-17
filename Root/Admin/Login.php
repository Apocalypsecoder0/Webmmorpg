<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dummy credentials for demonstration
    $username = 'admin';
    $password = 'password123';

    // Get the posted username and password
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Check if the credentials are correct
    if ($input_username === $username && $input_password === $password) {
        $_SESSION['loggedin'] = true;
        header('Location: admin_cpanel.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admincplanel.css">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
