<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: php/home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Home</title>
</head>
<body>
    <header>
        <h1>Welcome to Sci-Fi Universe</h1>
    </header>
    <nav>
         <a href="php/aboutus.php">Aboutus</a>
        <a href="php/home.php">Home</a>
        <a href="php/login.php">Login</a>
        <a href="php/register.php">Register</a>

         <a href="php/fourm.php">Fourm</a>
    </nav>
</body>
</html>
