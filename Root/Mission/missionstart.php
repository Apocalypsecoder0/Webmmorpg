<?php
// Database connection
$servername = "localhost";
$username = "username"; // Replace with your database username
$password = "password"; // Replace with your database password
$dbname = "game_db"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to start a mission
function startMission($userId, $missionId, $conn) {
    $sql = "INSERT INTO user_missions (user_id, mission_id, status) VALUES ($userId, $missionId, 'in_progress')";
    if ($conn->query($sql) === TRUE) {
        echo "Mission started successfully.<br>";
    } else {
        echo "Error: " . $conn->error . "<br>";
    }
}

// Function to update user progress
function updateProgress($userId, $missionId, $progress, $conn) {
    $sql = "UPDATE user_missions SET progress = $progress WHERE user_id = $userId AND mission_id = $missionId";
    if ($conn->query($sql) === TRUE) {
        echo "Progress updated successfully.<br>";
    } else {
        echo "Error: " . $conn->error . "<br>";
    }
}

// Function to complete a mission and grant rewards
function completeMission($userId, $missionId, $conn) {
    // Update the mission status to completed
    $sql = "UPDATE user_missions SET status = 'completed' WHERE user_id = $userId AND mission_id = $missionId";
    $conn->query($sql);

    // Fetch rewards for the completed mission
    $rewardSql = "SELECT resource_type, amount FROM rewards WHERE mission_id = $missionId";
    $rewardResult = $conn->query($rewardSql);

    if ($rewardResult->num_rows > 0) {
        while ($row = $rewardResult->fetch_assoc()) {
            // Logic to add the reward to the user's account
            if ($row["resource_type"] == 'resources') {
                // Add resources to user's account
                echo "Added " . $row["amount"] . " resources to user account.<br>";
            } elseif ($row["resource_type"] == 'items') {
                // Add items to user's inventory
                echo "Added " . $row["amount"] . " items to user inventory.<br>";
            } elseif ($row["resource_type"] == 'experience') {
                // Add experience points to user's profile
                echo "Added " . $row["amount"] . " experience points to user profile.<br>";
            }
        }
    }
}

// Function to display user missions
function displayUserMissions($userId, $conn) {
    $sql = "SELECT m.description, um.status, um.progress FROM user_missions um JOIN missions m ON um.mission_id = m.id WHERE um.user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Mission: " . $row["description"] . " - Status: " . $row["status"] . " - Progress: " . $row["progress"] . "%<br>";
        }
    } else {
        echo "No missions found.<br>";
    }
}

// Example usage
$userId = 1; // Replace with the actual user ID

// Start a mission
startMission($userId, 1, $conn); // Replace 1 with the actual mission ID

// Update progress
updateProgress($userId, 1, 50, $conn); // Replace 50 with the actual progress percentage

// Complete a mission
completeMission($userId, 1, $conn); // Replace 1 with the actual mission ID

// Display user missions
echo "<h1>Your Missions</h1>";
displayUserMissions($userId, $conn);

// Close connection
$conn->close();
?>
