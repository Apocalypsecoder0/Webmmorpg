<?php
session_start();
include 'db.php'; // Include database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['race'] = $user['race'];
        $_SESSION['abilities'] = $user['abilities'];
        $_SESSION['role'] = $user['role']; // Store user role in session
        $_SESSION['factions'] = $user['factions'];
        if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['race'] = $user['race'];
    $_SESSION['abilities'] = $user['abilities'];
    $_SESSION['factions'] = $user['factions'];
    // Fetch and store user role
    $stmt = $pdo->prepare("SELECT r.name AS role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = :id");
    $stmt->execute(['id' => $user['id']]);
    $role = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['role'] = $role['role_name'];

    header("Location: selectEmpire.php"); // Redirect to selectEmpire page
    exit();
}
        // In login.php, after verifying the password
$stmt = $pdo->prepare("SELECT r.name AS role_name FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = :id");
$stmt->execute(['id' => $user['id']]);
$role = $stmt->fetch(PDO::FETCH_ASSOC);

// Store role in session
$_SESSION['role'] = $role['role_name'];
        header("Location: profile.php"); // Redirect to profile page
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>
function hasPermission($permission) {
    global $pdo;
    $user_id = $_SESSION['user_id'];

    // Get the user's role_id
    $stmt = $pdo->prepare("SELECT role_id FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $role_id = $stmt->fetchColumn();

    // Check if the role has the permission
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM role_permissions rp 
                            JOIN permissions p ON rp.permission_id = p.id 
                            WHERE rp.role_id = :role_id AND p.name = :permission");
    $stmt->execute(['role_id' => $role_id, 'permission' => $permission]);
    
    return $stmt->fetchColumn() > 0;
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
