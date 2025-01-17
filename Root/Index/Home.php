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
    <div class="container">
        <div class="sidebar left-sidebar">
            <h2>Left Sidebar</h2>
<body>
            <p>  <a href="php/home.php">Home/a>
        <a href="php/commandcenter.php">CommandCenter/a>
        <a href="php/attack.php.php">Attack HQ/a>

        <a href="php/combat.php"/CombatlogCenter/a>
        <a href="php/chat.php">chat/a>
        <a href="php/traincenter.php">Training Center/a>

        <a href="php/fleetmanagement.php">FleetManagement</a>
        <a href="php/resourcemanagement.php">FleetManagement</a>
        <a href="php/researchmanagement.php">ResearchManagement</a>
        <a href="php/technologymanagement.php">TechnogyManagement</a>
        
        <a href="php/alliance.php">AllianceManagement</a>
        <a href="php/guild.php">GuildManagement</a>
         <a href="php/options.php">options</a>
          <a href="php/settings.php.php">settings.php</a>
          <a href="php/options.php.php">options.php</a>
    </div>
        <div class="main-content">
            <h1>Main Content Area</h1>
            <p>This is where the main content will be displayed.</p>
        </div>
        <div class="sidebar right-sidebar">
            <h2>Right Sidebar</h2>
<body>
    
    <div class="content">
</body>
</html>
                <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>maingui-like Menu</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

<?php
// Include footer
include 'footer.php';
?>
