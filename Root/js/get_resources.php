<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_GET['user_id'];

    // Prepare the SQL statement to include turns and gold
    $stmt = $pdo->prepare("SELECT metal, crystal, deuterium, turns, gold FROM resources WHERE user_id = ?");
    $stmt->execute([$user_id]);

    // Fetch the resources including turns and gold
    $resources = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if resources were found
    if ($resources) {
        echo json_encode($resources);
    } else {
        // Return an error message if no resources found
        echo json_encode(['error' => 'No resources found for this user.']);
    }
}
?>
