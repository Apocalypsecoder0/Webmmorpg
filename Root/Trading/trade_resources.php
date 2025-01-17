<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tradeType = $_POST['trade_type'];
    $tradeAmount = (int)$_POST['trade_amount'];
    $userId = $_SESSION['user_id'];

    // Fetch current resources
    $stmt = $pdo->prepare("SELECT * FROM resources WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $resources = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user has enough resources
    if ($resources[$tradeType] >= $tradeAmount) {
        // Deduct resources
        $stmt = $pdo->prepare("UPDATE resources SET $tradeType = $tradeType - :trade_amount WHERE user_id = :user_id");
        $stmt->execute(['trade_amount' => $tradeAmount, 'user_id' => $userId]);
        echo "Trade successful! You traded $tradeAmount $tradeType.";
    } else {
        echo "Not enough $tradeType to trade.";
    }
}
?>
