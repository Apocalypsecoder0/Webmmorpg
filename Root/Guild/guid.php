<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$guild_name = "";

// Create Guild
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_guild'])) {
    $guild_name = $_POST['guild_name'];
    $stmt = $pdo->prepare("INSERT INTO guilds (name, leader_id) VALUES (?, ?)");
    $stmt->execute([$guild_name, $user_id]);
    echo "Guild created successfully.";
}

// Join Guild
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['join_guild'])) {
    $guild_id = $_POST['guild_id'];
    $stmt = $pdo->prepare("UPDATE users SET guild_id = ? WHERE id = ?");
    $stmt->execute([$guild_id, $user_id]);
    echo "Joined guild successfully.";
}

// Fetch all guilds
$guilds = $pdo->query("SELECT * FROM guilds")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guild Management</title>
    <link rel="stylesheet" href="../css/guild.css">
</head>
<body>
    <h1>Guild Management</h1>
    
    <section>
        <h2>Create Guild</h2>
        <form method="post">
            <input type="text" name="guild_name" placeholder="Guild Name" required>
            <button type="submit" name="create_guild">Create Guild</button>
        </form>
    </section>
    
    <section>
        <h2>Join Guild</h2>
        <form method="post">
            <select name="guild_id">
                <?php foreach ($guilds as $guild): ?>
                    <option value="<?= $guild['id'] ?>"><?= htmlspecialchars($guild['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="join_guild">Join Guild</button>
        </form>
    </section>
</body>
</html>
