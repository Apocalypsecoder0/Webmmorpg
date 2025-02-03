<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

echo "Welcome to the Real Time Turn Base
Massively Multiplayer Online Role-Playing Game , " . $_SESSION['username'] . "!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game</title>
</head>
<body>
    <h1>Your Game Starts Here!</h1>
    <!-- Game content goes here -->
      <a href="php/home.php">Home</a>
        <a href="php/commandcenter.php">Command Center</a>
        <a href="php/attack.php">Attack HQ</a>

        <a href="php/combat.php">Combat Log Center</a>
        <a href="php/chat.php">Chat</a>
        <a href="php/traincenter.php">Training Center</a>

        <a href="php/fleetmanagement.php">Fleet Management</a>
        <a href="php/resourcemanagement.php">Resource Management</a>
        <a href="php/researchmanagement.php">Research Management</a>
        <a href="php/technologymanagement.php">Technology Management</a>
        
        <a href="php/alliance.php">Alliance Management</a>
        <a href="php/guild.php">Guild Management</a>
    
    <a href="logout.php">Logout</a>
</body>
</html>