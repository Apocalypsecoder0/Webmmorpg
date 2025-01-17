<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "map_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate sectors
function generateSectors($numSectors) {
    global $conn;
    for ($i = 0; $i < $numSectors; $i++) {
        $name = "Sector " . ($i + 1);
        $x = rand(0, 100); // Random x coordinate
        $y = rand(0, 100); // Random y coordinate
        $terrain = rand(0, 1) ? 'forest' : 'desert'; // Random terrain type

        $sql = "INSERT INTO sectors (name, x_coordinate, y_coordinate, terrain_type) VALUES ('$name', $x, $y, '$terrain')";
        $conn->query($sql);
    }
}

// Call the function to generate 10 sectors
generateSectors(10);

// Fetch sectors for display
$result = $conn->query("SELECT * FROM sectors");
$sectors = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
