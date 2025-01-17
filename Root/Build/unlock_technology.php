<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); // Redirect to login if not logged in
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $technology_id = $_POST['technology_id'];

    // Check if the technology exists
    $check_technology_query = "SELECT * FROM technologies WHERE id = '$technology_id'";
    $check_technology_result = $conn->query($check_technology_query);

    if ($check_technology_result->num_rows > 0) {
        $technology = $check_technology_result->fetch_assoc();
        $requirements = json_decode($technology['requirements'], true); // Assuming requirements are stored as JSON

        // Check if the user has the necessary resources or technologies to unlock this one
        // For simplicity, let's assume we check resources (e.g., resource_amount >= required_amount)
        $user_resources_query = "SELECT * FROM user_resources WHERE user_id = '$user_id'";
        $user_resources_result = $conn->query($user_resources_query);
        $user_resources = $user_resources_result->fetch_assoc();

        $can_unlock = true;
        foreach ($requirements as $resource => $required_amount) {
            if ($user_resources[$resource] < $required_amount) {
                $can_unlock = false;
                break;
            }
        }

        if ($can_unlock) {
            // Unlock the technology
            $unlock_technology_query = "INSERT INTO user_technologies (user_id, technology_id) VALUES ('$user_id', '$technology_id')";
            if ($conn->query($unlock_technology_query) === TRUE) {
                // Deduct resources
                foreach ($requirements as $resource => $required_amount) {
                    $new_amount = $user_resources[$resource] - $required_amount;
                    $update_resources_query = "UPDATE user_resources SET $resource = '$new_amount' WHERE user_id = '$user_id'";
                    $conn->query($update_resources_query);
                }
                // Successfully unlocked the technology
                header("Location: technology.php?status=success");
            } else {
                // Error unlocking technology
                echo "Error: " . $conn->error;
            }
        } else {
            // Not enough resources or requirements not met
            header("Location: technology.php?status=insufficient_resources");
        }
    } else {
        // Technology not found
        header("Location: technology.php?status=not_found");
    }
}

$conn->close();
?>
