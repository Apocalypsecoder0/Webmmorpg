<?php
// Start the session
session_start();

// Include header
include 'header.php';

// Fetch data from a database (example)
$posts = getPosts(); // Assume this function fetches posts from a database
?>
<link rel="icon" href="favicon-32x32.png" sizes="32x32" type="image/favion.png">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Layout</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar left-sidebar">
            <h2>Left Sidebar</h2>
            <p>  <a href="php/home.php">Home</a>
        <a href="php/commandcenter.php">Command Center</a>
        <a href="php/attack.php">Attack HQ</a>

        <a href="php/combat.php">Combat Log Center</a>
        <a href="php/chat.php">Chat</a>
        <a href="php/traincenter.php">Training Center</a>

        <a href="php/fleetmanagement.php">Fleet Management</a>
        <a href="php/resourcemanagement.php">Resource Management</a>
        <a href="php/researchmanagement.php">Research Management</a>
        <a href="php/technologymanagement.php">Technology Management</a>
        
        <a href="php/alliance.php">Alliance Management</a>
        <a href="php/guild.php">Guild Management</a>
         <a href="php/options.php">Options</a>
          <a href="php/settings.php">Settings</a>
          <a href="php/options.php">Options</a>
    </div>
        <div class="main-content">
            <h1>Main Content Area</h1>
            <p>This is where the main content will be displayed.</p>
        </div>
        <div class="sidebar right-sidebar">
            <h2>Right Sidebar</h2>
            <div class="content">
                <!-- Content can be added here -->
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Include footer
include 'footer.php';
?>