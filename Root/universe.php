<?php
require 'db.php';

// Fetch all universes from the database
$universes = $pdo->query("SELECT * FROM universes")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Universe Management</title>
    <link rel="stylesheet" href="../css/universes.css"> <!-- Link to a new CSS file if needed -->
</head>
<body>
    <h1>Universe Management</h1>
    <table>
        <thead>
            <tr>
                <th>Universe Name</th>
                <th>Galaxy Count</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($universes as $universe): ?>
                <tr>
                    <td><?= htmlspecialchars($universe['name']) ?></td>
                    <td><?= htmlspecialchars($universe['galaxy_count']) ?></td>
                    <td><?= htmlspecialchars($universe['description']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
