<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "mmorpg_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO characters (user_id, name, class) VALUES ('$user_id', '$name', '$class')";

    if ($conn->query($sql) === TRUE) {
        echo " Goverment Character created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Goverment Character</title>
</head>
<body>
    <h2>Create Your Character</h2>
    <form method="POST" action="">
        <label for="name">Character Name:</label>
        <input type="text" name="name" required>
        <br>
        <label for="class">Goverment Character Class:</label>
        <select name="class" required>
            
<option value=""><h2>Democratic	Direct Democracy</h2>, <option>Representative Democracy </option>, <option>Republic Government</option>, <option>Parliamentary Government</option>,<option> Constitutional monarchy</option>
<option value=""><h2>Non-Democratic	Authoritarian</h2></option>, Totalitarian</option>, Dictatorship</option>, Absolute monarchy</option>
<option value=""><h2>Other Types:	Communist,</option> Colonialist</option>, <option value>Aristocratic</option>
        </select>
        <br>
        <input type="submit" value="Create Govement Character">
    </form>
</body>
</html>
