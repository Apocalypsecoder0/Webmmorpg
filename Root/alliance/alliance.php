<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all alliances
$alliances = $pdo->query("SELECT * FROM alliances")->fetchAll(PDO::FETCH_ASSOC);

// Alliance Details
if (isset($_GET['alliance_id'])) {
    $alliance_id = $_GET['alliance_id'];
    $alliance = $pdo->prepare("SELECT * FROM alliances WHERE id = ?");
    $alliance->execute([$alliance_id]);
    $alliance = $alliance->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alliance Management</title>
    <link rel="stylesheet" href="../css/alliance.css">
</head>
<body>
    <h1>Alliance Management</h1>

    <section>
        <h2>Alliances</h2>
        <ul>
            <?php foreach ($alliances as $alliance): ?>
                <li>
                    <a href="?alliance_id=<?= $alliance['id'] ?>">
                        <?= htmlspecialchars($alliance['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <?php if (isset($alliance)): ?>
    <section>
        <h2>Alliance Details</h2>
        <p>Name: <?= htmlspecialchars($alliance['name']) ?></p>
        <p>Leader ID: <?= $alliance['leader_id'] ?></p>
        <p>Created At: <?= $alliance['created_at'] ?></p>
    </section>
    <?php endif; ?>
</body>
</html>
