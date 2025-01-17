<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $ship_type = $_POST['ship_type'];
    $quantity = (int)$_POST['quantity'];

    // Ship costs (example data)
    $ship_costs = [
        'fighter' => ['metal' => 500, 'crystal' => 300, 'deuterium' => 100],
        'cruiser' => ['metal' => 1500, 'crystal' => 1000, 'deuterium' => 500]
    ];

    $cost = $ship_costs[$ship_type];
    $total_cost = [
        'metal' => $cost['metal'] * $quantity,
        'crystal' => $cost['crystal'] * $quantity,
        'deuterium' => $cost['deuterium'] * $quantity
    ];

    // Check if user has enough resources
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $resources = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resources['metal'] >= $total_cost['metal'] &&
        $resources['crystal'] >= $total_cost['crystal'] &&
        $resources['deuterium'] >= $total_cost['deuterium']) {
        
        // Deduct resources and add ships
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("UPDATE resources SET metal = metal - ?, crystal = crystal - ?, deuterium = deuterium - ? WHERE user_id = ?");
        $stmt->execute([$total_cost['metal'], $total_cost['crystal'], $total_cost['deuterium'], $user_id]);

        $stmt = $pdo->prepare("INSERT INTO fleets (owner_id, ship_type, quantity) VALUES (?, ?, ?) 
                               ON DUPLICATE KEY UPDATE quantity = quantity + ?");
        $stmt->execute([$user_id, $ship_type, $quantity, $quantity]);

        $pdo->commit();
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Insufficient resources']);
    }
}
?>
