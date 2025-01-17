<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process race selection
    $_SESSION['race'] = $_POST['race'];
    header("Location: commandcenter.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/race_select.css">
    <title>Select Your Race</title>
</head>
<body>
    <h1>Select Your Race</h1>
    <form method="post">
        <label>
            <input type="radio" name="race" value="Human" required> Human
        </label><br>
        <label>
            <input type="radio" name="race" value="Alien" required> Alien
        </label><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
