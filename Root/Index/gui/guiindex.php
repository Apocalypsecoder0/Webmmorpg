/* Responsive Design */
@media (max-width: 768px) {
    .container {
        flex-direction: column; /* Stack elements vertically on smaller screens */
    }

    .sidebar {
        width: 100%; /* Full width for sidebars */
        border: none; /* Remove borders for a cleaner look */
    }

    .main-content {
        width: 100%; /* Full width for main content */
    }
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main-Menu</title>
    <link rel="stylesheet" href="guistyles.css"> <!-- Link to your CSS file -->
</head>
     <div class="container">
        <div class="sidebar left-sidebar">
            <h2>Left Sidebar</h2>
            <p>index.php</p>
        </div>
        <div class="main-content">
            <h1>Main Content Area</h1>
            <p>This is where the main content will be displayed.</p>
        </div>
        <div class="sidebar right-sidebar">
            <h2>Right Sidebar</h2>
<body>
    
    <div class="content">
        <h1>Welcome to the game</h1>
        <p>Your content goes here.</p>
    </div>
    <script src="guiscript.js"></script> <!-- Link to your JavaScript file -->
</body>
</html>
