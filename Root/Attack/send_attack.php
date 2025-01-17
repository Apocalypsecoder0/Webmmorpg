<?php
$servername = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "ogame";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $attacker_id = 1; // Example attacker ID
    $target = intval($_POST['target']);
    $ship_type = $_POST['ship_type'];
    $quantity = intval($_POST['quantity']);

    // Validate input
    if ($quantity <= 0) {
        die("Invalid quantity.");
    }

    // Fetch target player defenses
    $stmt = $conn->prepare("SELECT * FROM defenses WHERE player_id = ?");
    $stmt->bind_param("i", $target);
    $stmt->execute();
    $result_defenses = $stmt->get_result();

    // Calculate battle outcome
    $total_defense = 0;
    while ($defense = $result_defenses->fetch_assoc()) {
        $total_defense += $defense['quantity']; // Simplified defense calculation
    }

    // Simplified battle logic
    if ($quantity > $total_defense) {
        $result = "Attack successful! You destroyed the defenses.";
    } else {
        $result = "Attack failed! Your ships were repelled.";
    }

    // Store battle report
    $stmt = $conn->prepare("INSERT INTO battle_reports (attacker_id, defender_id, result) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $attacker_id, $target, $result);
    $stmt->execute();

    // Display battle result
    echo "<h1>Battle Result</h1>";
    echo "<p>$result</p>";
    echo "<a href='fleetmanagement.php'>Back to Fleet Management</a>";
}
 // Store battle report
    $stmt = $conn->prepare("INSERT INTO battle_reports (attacker_id, defender_id, result) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $attacker_id, $target, $result);
    $stmt->execute();

    // Redirect to battle results page
    header("Location: battle_result.php");
    exit();
}

$stmt->close();
$conn->close();
?>
