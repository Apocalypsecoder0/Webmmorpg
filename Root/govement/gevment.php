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

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM goverments WHERE user_id='$user_id'";
$result = $conn->query($sql);

echo "<h2>Your Characters</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Name: " . $row['name'] . " | Class: " . $row['class'] . " | Level: " . $row['level'] . "<br>";
    }
} else {
    echo "No characters found.";
}

$conn->close();
?>

<a href="logout.php">Logout</a>
