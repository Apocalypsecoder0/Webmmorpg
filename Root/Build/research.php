<?php
// Include database connection
include('db_connection.php');

// Fetch available research topics from the database
$query = "SELECT * FROM research_topics";
$result = $conn->query($query);

// Fetch user's current research status
$user_id = $_SESSION['user_id']; // Assuming you have a user session
$current_research_query = "SELECT * FROM user_research WHERE user_id = '$user_id'";
$current_research_result = $conn->query($current_research_query);

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research System</title>
    <link rel="stylesheet" href="research.css">
</head>
<body>
    <div class="research-container">
        <h1>Available Research Topics</h1>
        <table>
            <tr>
                <th>Research Name</th>
                <th>Progress</th>
                <th>Start Research</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['research_name']; ?></td>
                <td>
                    <?php
                    $progress_query = "SELECT progress FROM user_research WHERE research_id = '" . $row['id'] . "' AND user_id = '$user_id'";
                    $progress_result = $conn->query($progress_query);
                    if ($progress_result->num_rows > 0) {
                        $progress_row = $progress_result->fetch_assoc();
                        echo $progress_row['progress'] . '%';
                    } else {
                        echo "Not Started";
                    }
                    ?>
                </td>
                <td>
                    <?php if ($progress_row['progress'] == 100) : ?>
                        <button disabled>Completed</button>
                    <?php else : ?>
                        <form method="POST" action="start_research.php">
                            <input type="hidden" name="research_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Start Research</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
