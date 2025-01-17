
<?php
// faction.php

// Sample array of factions based on race
$factions = [
    'Human' => ['Knights of Valor', 'The Merchant Guild'],
    'Elf' => ['The Silver Circle', 'The Arcane Order'],
    'Orc' => ['The Iron Horde', 'The Blood Pact'],
    'Dwarf' => ['The Stone Clan', 'The Forge Brotherhood'],
];

// Get the selected race from the URL
$selectedRace = $_GET['race'] ?? null;

// Check if the race is valid
if (!array_key_exists($selectedRace, $factions)) {
    die("Invalid race selected.");
}

// Check if a faction has been selected
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedFaction = $_POST['faction'];
    // Here you would typically save the selected race and faction to the database
    // For demonstration, we'll just display the selection
    echo "You have selected the race: $selectedRace and the faction: $selectedFaction.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Faction</title>
</head>
<body>
    <h1>Select Your Faction for <?php echo htmlspecialchars($selectedRace); ?></h1>
    <form method="POST">
        <?php foreach ($factions[$selectedRace] as $faction): ?>
            <div>
                <input type="radio" id="<?php echo $faction; ?>" name="faction" value="<?php echo $faction; ?>" required>
                <label for="<?php echo $faction; ?>"><?php echo $faction; ?></label>
            </div>
        <?php endforeach; ?>
        <button type="submit">Register</button>
    </form>
</body>
</html>
