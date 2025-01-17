<?php
// Start the session
session_start();

// Check if the installation is complete
if (isset($_SESSION['installed']) && $_SESSION['installed'] === true) {
    echo "<h1>Installation Complete</h1>";
    echo "<p>Your application is already installed.</p>";
    exit;
}

// Process the installation form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Here you would typically handle the installation logic, like database setup
    // For demonstration, we'll just set a session variable
    $_SESSION['installed'] = true;
    echo "<h1>Installation Successful</h1>";
    echo "<p>Your application has been installed successfully!</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="install.css">
    <title>Installation Page</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Installation</h1>
        <form method="POST" action="">
            <button type="submit">Install Application</button>
        </form>
    </div>
</body>
</html>
