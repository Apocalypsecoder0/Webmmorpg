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

// Fetch player data
$player_id = 1; // Example player ID
$stmt = $conn->prepare("SELECT * FROM players WHERE id = ?");
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result = $stmt->get_result();
$player = $result->fetch_assoc();

// Fetch ships
$stmt = $conn->prepare("SELECT * FROM ships WHERE player_id = ?");
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result_ships = $stmt->get_result();

// Fetch defenses
$stmt = $conn->prepare("SELECT * FROM defenses WHERE player_id = ?");
$stmt->bind_param("i", $player_id);
$stmt->execute();
$result_defenses = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OGame Fleet Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($player['username']); ?></h1>
        <h2>Your Resources: <?php echo htmlspecialchars($player['resources']); ?></h2>

        <h3>Your Ships</h3>
        <table>
            <tr>
                <th>Ship Type</th>
                <th>Quantity</th>
            </tr>
            <?php while($ship = $result_ships->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($ship['ship_type']); ?></td>
                <td><?php echo htmlspecialchars($ship['quantity']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h3>Your Defenses</h3>
        <table>
            <tr>
                <th>Defense Type</th>
                <th>Quantity</th>
            </tr>
            <?php while($defense = $result_defenses->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($defense['defense_type']); ?></td>
                <td><?php echo htmlspecialchars($defense['quantity']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h3>Send Attack</h3>
        <form action="send_attack.php" method="post">
            <label for="target">Target Player ID:</label>
            <input type="number" id="target" name="target" required>
            <label for="ship_type">Ship Type:</label>
            <input type="text" id="ship_type" name="ship_type" required>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>
            <button type="submit">Send Attack</button>
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>

        <h3>Send Attack</h3>
        <form action="send_attack.php" method="post">
            <label for="target">Target Player ID:</label>
            <input type="number" id="target" name="target" required>
            <label for="ship_type">Ship Type:</label>
            <input type="text" id="ship_type" name="ship_type" required>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>
            <button type="submit">Send Attack</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
