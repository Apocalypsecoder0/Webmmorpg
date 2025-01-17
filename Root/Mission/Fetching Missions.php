<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "game_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch active missions
$sql = "SELECT * FROM missions WHERE is_active = TRUE";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Mission: " . $row["description"]. " - Reward: " . $row["reward"]. "<br>";
    }
} else {
    echo "No active missions.";
}
$conn->close();
?>
