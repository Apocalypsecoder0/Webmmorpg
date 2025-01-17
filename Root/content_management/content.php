<?php
// Simulating a database with an associative array
$data = [
    "overview" => "This is the overview section where you can see your overall status.",
    "resources" => "This section shows your resources like metal, crystal, and deuterium.",
    "fleet" => "Manage your fleet here. View, send, or build ships.",
    "research" => "Research new technologies to improve your capabilities.",
    "buildings" => "Manage your buildings and upgrade them.",
    "defense" => "View and manage your defense structures.",
    "settings" => "Adjust your game settings and preferences."
];

// Get the section from the request
$section = $_GET['section'] ?? 'overview';

// Return the content for the requested section or a default message
echo isset($data[$section]) ? $data[$section] : "Section not found.";
?>
