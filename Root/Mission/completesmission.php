<?php
// Assume $userId and $missionId are obtained from the session or request
$userId = 1; // Example user ID
$missionId = 1; // Example mission ID

// Update user's current mission and give rewards
$sql = "UPDATE users SET current_mission_id = NULL WHERE id = $userId";
$conn->query($sql);

// Optionally, you can add logic to give rewards to the user here

// Mark the mission as completed (if needed)
$sql = "UPDATE missions SET is_active = FALSE WHERE id = $missionId";
$conn->query($sql);
?>
