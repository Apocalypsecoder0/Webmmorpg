<?php
$servername = "localhost"; // Your database server
$username = "username"; // Your database username
$password = "password"; // Your database password
$dbname = "map_database"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a map using cellular automata
function generateMap($width, $height) {
    $map = [];
    // Initialize the map with random terrain
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $map[$x][$y] = rand(0, 1) ? 'forest' : 'desert'; // Initial random terrain
        }
    }

    // Apply rules for cellular automata
    for ($i = 0; $i < 5; $i++) { // Number of iterations
        for ($x = 1; $x < $width - 1; $x++) {
            for ($y = 1; $y < $height - 1; $y++) {
                $neighborCount = 0;
                // Count neighbors
                for ($nx = -1; $nx <= 1; $nx++) {
                    for ($ny = -1; $ny <= 1; $ny++) {
                        if ($map[$x + $nx][$y + $ny] === 'forest') {
                            $neighborCount++;
                        }
                    }
                }
                // Apply rules
                if ($neighborCount > 4) {
                    $map[$x][$y] = 'forest';
                } else {
                    $map[$x][$y] = 'desert';
                }
            }
        }
    }

    return $map;
}

// Call the function to generate a 20x20 grid
$generatedMap = generateMap(20, 20);

// Clear the sectors table before inserting new data
$conn->query("DELETE FROM sectors");

// Save the generated map to the database
foreach ($generatedMap as $x => $row) {
    foreach ($row as $y => $terrain) {
        $sql = "INSERT INTO sectors (name, x_coordinate, y_coordinate, terrain_type) VALUES ('Sector $x-$y', $x, $y, '$terrain')";
        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();

echo "Map generated and saved to the database successfully!";
?>
