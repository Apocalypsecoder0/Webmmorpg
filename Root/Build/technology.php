<?php
// Include database connection
include('db_connection.php');

// Fetch available technologies from the database
$query = "SELECT * FROM technologies";
$result = $conn->query($query);

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technology System</title>
    <link rel="stylesheet" href="technology.css">
</head>
<body>
    <div class="technology-container">
        <h1>Available Technologies</h1>
        <table>
            <tr>
                <th>Technology Name</th>
                <th>Requirements</th>
                <th>Unlock</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['technology_name']; ?></td>
                <td><?php echo $row['requirements']; ?></td>
                <td>
                    <form method="POST" action="unlock_technology.php">
                        <input type="hidden" name="technology_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Unlock</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
