<?php
require 'db.php';

$galaxies = $pdo->query("SELECT * FROM planets")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Galaxy Management</title>
    <link rel="stylesheet" href="../css/galaxys.css">
</head>
<body>
    <a href="universe.php">Go to Universe Management</a>
    <h1>Galaxy Management</h1>
    <table>
        <thead>
            <tr>
                <th>Galaxy</th>
                <th>System</th>
                <th>Position</th>
                <th>Planet Name</th>
                <th>Owner</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($galaxies as $planet): ?>
                <tr>
                    <td><?= $planet['galaxy'] ?></td>
                    <td><?= $planet['system'] ?></td>
                    <td><?= $planet['position'] ?></td>
                    <td><?= htmlspecialchars($planet['name']) ?></td>
                    <td><?= $planet['owner_id'] ? htmlspecialchars($planet['owner_id']) : 'Unowned' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
