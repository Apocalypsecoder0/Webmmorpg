<?php
session_start();
require 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $race = trim($_POST['race']);
    $government = trim($_POST['government']);
    $error = '';

    // Validate input
    if (empty($username) || empty($password) || empty($race) || empty($government)) {
        $error = "All fields are required.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO users (username, password, race, government) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $hashed_password, $race, $government])) {
            header('Location: login.php');
            exit;
        } else {
            $error = "Registration failed. Username may already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admincplanel.css">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="race">Race:</label>
        <select name="race" required>
            <option value="">Select your race</option>
            <option value="Human.php">Human</option>
            <option value="andriond.php">Android</option>
            <option value="alien.php">Alien</option>
            <option value="orc.php">Orc</option>
            <option value="elf.php">Elf</option>
        </select>
          <select name="factions" required>
            <option value="">Select your race</option>
            <option value="Human.php">Human</option>
            <option value="elf.php">Elf</option>
            <option value="orc.php">Orc</option>
            <option value="dwarf.php">Dwarf</option>
        </select>
      
        <br>
        <label for="government">Government Type:</label>
        <select name="government" required>
            <option value="">Select your government type</option>
            <option value="Democracy.php">Democracy</option>
            <option value="Republic.php">Republic</option>
            <option value="Monarchy.php">Monarchy</option>
            <option value="Dictatorship.php">Dictatorship</option>
            <option value="Other.php">Other</option>
        </select>
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
