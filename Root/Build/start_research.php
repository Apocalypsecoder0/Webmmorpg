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
    $research_id = $_POST['research_id'];

    // Ensure the research exists and has not been started yet
    $check_research_query = "SELECT * FROM research_topics WHERE id = '$research_id'";
    $check_research_result = $conn->query($check_research_query);

    if ($check_research_result->num_rows > 0) {
        $research = $check_research_result->fetch_assoc();
        // Check if the user has already started the research
        $check_user_research_query = "SELECT * FROM user_research WHERE user_id = '$user_id' AND research_id = '$research_id'";
        $check_user_research_result = $conn->query($check_user_research_query);

        if ($check_user_research_result->num_rows == 0) {
            // Insert a new research record for the user
            $start_research_query = "INSERT INTO user_research (user_id, research_id, progress) VALUES ('$user_id', '$research_id', 0)";
            if ($conn->query($start_research_query) === TRUE) {
                // Successfully started the research
                header("Location: research.php?status=success");
            } else {
                // Error starting the research
                echo "Error: " . $conn->error;
            }
        } else {
            // The user has already started this research
            header("Location: research.php?status=already_started");
        }
    } else {
        // The research does not exist
        header("Location: research.php?status=not_found");
    }
}

$conn->close();
?>
