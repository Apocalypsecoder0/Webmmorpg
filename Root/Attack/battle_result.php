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

// Pagination settings
$limit = 50; // Number of results per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch battle reports
$stmt = $conn->prepare("SELECT * FROM battle_reports ORDER BY timestamp DESC LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Count total battles for pagination
$total_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM battle_reports");
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_battles = $total_row['total'];
$total_pages = ceil($total_battles / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battle Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Battle Results</h1>
        <table>
            <tr>
                <th>Attacker ID</th>
                <th>Defender ID</th>
                <th>Result</th>
                <th>Timestamp</th>
            </tr>
            <?php while($battle = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($battle['attacker_id']); ?></td>
                <td><?php echo htmlspecialchars($battle['defender_id']); ?></td>
                <td><?php echo htmlspecialchars($battle['result']); ?></td>
                <td><?php echo htmlspecialchars($battle['timestamp']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>

        <a href="index.php">Back to Fleet Management</a>
    </div>
</body>
</html>

<?php
$stmt->close();
$total_stmt->close();
$conn->close();
?>
