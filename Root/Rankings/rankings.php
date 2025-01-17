<?php
// Database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch players and order by score
$sql = "SELECT username, score FROM players ORDER BY score DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ranking.css">
    <title>Player Rankings</title>
</head>
<body>
    <h1>Player Rankings</h1>
    <table>
        <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Score</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            $rank = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$rank}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['score']}</td>
                      </tr>";
                $rank++;
            }
        } else {
            echo "<tr><td colspan='3'>No players found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
