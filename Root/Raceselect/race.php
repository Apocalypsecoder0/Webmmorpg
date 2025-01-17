<?php
// race.php

// Sample array of races
$races = [
    'Human' => 'Humans are versatile and adaptable.',
    'Elf' => 'Elves are agile and skilled in magic.',
    'Orc' => 'Orcs are strong and resilient warriors.',
    'Dwarf' => 'Dwarves are tough and skilled craftsmen.',
];

// Check if a race has been selected
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedRace = $_POST['race'];
    // Redirect to the faction selection page with the selected race
    header("Location: faction.php?race=" . urlencode($selectedRace));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Race</title>
</head>
<body>
    <h1>Select Your Race</h1>
    <form method="POST">
        <?php foreach ($races as $race => $description): ?>
            <div>
                <input type="radio" id="<?php echo $race; ?>" name="race" value="<?php echo $race; ?>" required>
                <label for="<?php echo $race; ?>"><?php echo $race; ?>: <?php echo $description; ?></label>
            </div>
        <?php endforeach; ?>
        <button type="submit">Next</button>
    </form>
</body>
</html>
