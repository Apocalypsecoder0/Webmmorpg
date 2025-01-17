<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $structureName = $_POST['structure_name'];
    $level = (int)$_POST['level'];
    $userId = $_SESSION['user_id'];

    // Define resource costs for building (example values)
    $resourceCosts = [
        'metal' => 100 * $level, // Example cost calculation
        'crystal' => 50 * $level,
        'deuterium' => 25 * $level
    ];

    // Fetch current resources
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $resources = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user has enough resources
    if ($resources['metal'] >= $resourceCosts['metal'] &&
        $resources['crystal'] >= $resourceCosts['crystal'] &&
        $resources['deuterium'] >= $resourceCosts['deuterium']) {

        // Deduct resources
        $stmt = $pdo->prepare("UPDATE resources SET metal = metal - :metal, crystal = crystal - :crystal, deuterium = deuterium - :deuterium WHERE user_id = :user_id");
        $stmt->execute([
            'metal' => $resourceCosts['metal'],
            'crystal' => $resourceCosts['crystal'],
            'deuterium' => $resourceCosts['deuterium'],
            'user_id' => $userId
        ]);

        // Build the structure
        $stmt = $pdo->prepare("INSERT INTO advanced_structures (user_id, structure_name, level) VALUES (:user_id, :structure_name, :level)");
        $stmt->execute(['user_id' => $userId, 'structure_name' => $structureName, 'level' => $level]);

        echo "Built $structureName at level $level.";
    } else {
        echo "Not enough resources to build $structureName.";
    }
}
?>
