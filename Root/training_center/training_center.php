<?php
include 'db.php';

// Function to get available units
function getAvailableUnits($pdo) {
    $stmt = $pdo->query("SELECT * FROM units");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to train a unit
function trainUnit($pdo, $userId, $unitId) {
    // Get unit details
    $stmt = $pdo->prepare("SELECT training_time FROM units WHERE id = ?");
    $stmt->execute([$unitId]);
    $unit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($unit) {
        // Calculate end time
        $startTime = date('Y-m-d H:i:s');
        $endTime = date('Y-m-d H:i:s', strtotime("+{$unit['training_time']} seconds"));

        // Insert into training queue
        $stmt = $pdo->prepare("INSERT INTO training_queue (user_id, unit_id, start_time) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $unitId, $startTime]);

        return "Training started for unit ID: $unitId. It will finish at $endTime.";
    } else {
        return "Unit not found.";
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = 1; // Example user ID, replace with actual user session ID
    $unitId = $_POST['unit_id'];
    $message = trainUnit($pdo, $userId, $unitId);
}

// Get available units
$units = getAvailableUnits($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Center</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>
<body>
    <h1>Training Center</h1>

    <?php if (isset($message)) : ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <h2>Available Units</h2>
    <form method="POST">
        <select name="unit_id">
            <?php foreach ($units as $unit) : ?>
                <option value="<?php echo $unit['id']; ?>">
                    <?php echo $unit['name']; ?> (Cost: <?php echo $unit['cost']; ?>, Time: <?php echo $unit['training_time']; ?>s)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Train Unit</button>
    </form>

    <h2>Unit List</h2>
    <ul class="unit-list">
        <?php foreach ($units as $unit) : ?>
            <li>
                <strong><?php echo $unit['name']; ?></strong><br>
                Type: <?php echo $unit['type']; ?><br>
                HP: <?php echo $unit['hp']; ?><br>
                Attack Power: <?php echo $unit['attack_power']; ?><br>
                Defense: <?php echo $unit['defense']; ?><br>
                Speed: <?php echo $unit['speed']; ?><br>
                Range: <?php echo $unit['range']; ?><br>
                Cost: <?php echo $unit['cost']; ?><br>
                Training Time: <?php echo $unit['training_time']; ?> seconds
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
