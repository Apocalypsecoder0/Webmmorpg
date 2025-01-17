<?php
// planets.php

session_start(); // Start session to access user data

// Database connection parameters
$host = 'localhost';
$dbname = 'ogame_planets';
$username = 'your_username';
$password = 'your_password';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search, sort, and pagination variables
$search = '';
$sort = 'name'; // Default sorting by name
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$limit = 5; // Number of planets per page
$offset = ($page - 1) * $limit; // Offset for SQL query

if (isset($_POST['search'])) {
    $search = $_POST['search'];
}

if (isset($_POST['sort'])) {
    $sort = $_POST['sort'];
}

// Fetch planets from the database with search, sorting, and pagination functionality
$sql = "SELECT * FROM planets WHERE name LIKE '%$search%' ORDER BY $sort LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Get total number of planets for pagination
$total_sql = "SELECT COUNT(*) as total FROM planets WHERE name LIKE '%$search%'";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_planets = $total_row['total'];
$total_pages = ceil($total_planets / $limit);

// Handle favorite planet submission
if (isset($_POST['favorite']) && isset($_SESSION['user_id'])) {
    $planet_id = $_POST['planet_id'];
    $user_id = $_SESSION['user_id'];
    $favorite_sql = "INSERT INTO favorites (user_id, planet_id) VALUES ('$user_id', '$planet_id')";
    $conn->query($favorite_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planets</title>
    <link rel="stylesheet" href="planets.css">
</head>
<body>
    <h1>Planets in Our Solar System</h1>
    
    <!-- Search Form -->
    <form method="POST" action="">
        <input type="text" name="search" placeholder="Search for a planet..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
        
        <!-- Sort Dropdown -->
        <select name="sort" onchange="this.form.submit()">
            <option value="name" <?php if ($sort == 'name') echo 'selected'; ?>>Sort by Name</option>
            <option value="distance_from_sun" <?php if ($sort == 'distance_from_sun') echo 'selected'; ?>>Sort by Distance from Sun</option>
        </select>
    </form>

    <div class="planet-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($planet = $result->fetch_assoc()): ?>
                <div class="planet-item">
                    <img src="<?php echo $planet['image']; ?>" alt="<?php echo $planet['name']; ?>">
                    <h2><?php echo $planet['name']; ?></h2>
                    <p><?php echo $planet['description']; ?></p>
                    <p><strong>Diameter:</strong> <?php echo $planet['diameter']; ?></p>
                    <p><strong>Distance from Sun:</strong> <?php echo $planet['distance_from_sun']; ?></p>
                    <p><strong>Fun Fact:</strong> <?php echo $planet['fun_fact']; ?></p>
                    
                    <!-- Favorite Button -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="planet_id" value="<?php echo $planet['id']; ?>">
                            <button type="submit" name="favorite">Add to Favorites</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No planets found.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>">Previous</a>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>">Next</a>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
