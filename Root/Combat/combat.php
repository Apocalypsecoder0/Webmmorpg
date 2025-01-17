<?php
include 'db.php';

// Function to get units from the database
function getUnits($pdo, $unitIds) {
    $placeholders = implode(',', array_fill(0, count($unitIds), '?'));
    $stmt = $pdo->prepare("SELECT * FROM units WHERE id IN ($placeholders)");
    $stmt->execute($unitIds);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to calculate damage considering strengths and weaknesses
function calculateDamage($attacker, $defender) {
    $baseDamage = max(0, $attacker['attack_power'] - $defender['defense']);
    
    // Check for strengths and weaknesses
    if (strpos($attacker['strengths_weaknesses'], $defender['type']) !== false) {
        $baseDamage *= 1.5; // 50% more damage if strong
    } elseif (strpos($defender['strengths_weaknesses'], $attacker['type']) !== false) {
        $baseDamage *= 0.5; // 50% less damage if weak
    }

    return $baseDamage;
}

// Function to apply special abilities
function applySpecialAbility($unit, &$target) {
    switch ($unit['special_ability']) {
        case 'Critical Strike':
            return calculateDamage($unit, $target) * 2; // Double damage
        case 'Shield':
            $target['defense'] += 10; // Increase defense temporarily
            return 0; // No damage dealt
        case 'Repair':
            $unit['hp'] += 20; // Heal the unit
            return 0; // No damage dealt
        default:
            return 0; // No special ability
    }
}
// Function to apply special abilities with cooldowns
function applySpecialAbility($unit, &$target) {
    if ($unit['cooldown'] > 0) {
        return 0; // Ability is on cooldown
    }

    switch ($unit['special_ability']) {
        case 'Backstab':
            $unit['cooldown'] = 3; // Set cooldown
            return calculateDamage($unit, $target) * 2; // Double damage
        case 'Fireball':
            $unit['cooldown'] = 2; // Set cooldown
            return calculateDamage($unit, $target) * 1.5; // 50% more damage
        case 'Fortify':
            $unit['cooldown'] = 4; // Set cooldown
            $target['defense'] += 20; // Increase defense temporarily
            return 0; // No damage dealt
        case 'Heal':
            $unit['cooldown'] = 1; // Set cooldown
            $unit['hp'] += 20; // Heal the unit
            return 0; // No damage dealt
        default:
            return 0; // No special ability
    }
}

// Function to simulate combat with cooldowns
function simulateCombat($attackerUnits, $defenderUnits) {
    $combatLog = [];
    $attackerTotalHP = array_sum(array_column($attackerUnits, 'hp'));
    $defenderTotalHP = array_sum(array_column($defenderUnits, 'hp'));

    // Combat loop
    while ($attackerTotalHP > 0 && $defenderTotalHP > 0) {
        // Attack phase
        foreach ($attackerUnits as $attacker) {
            // Apply special ability if applicable
            $specialDamage = applySpecialAbility($attacker, $defenderUnits[0]);
            if ($specialDamage > 0) {
                $defenderTotalHP -= $specialDamage;
                $combatLog[] = "{$attacker['name']} uses {$attacker['special_ability']} on {$defenderUnits[0]['name']} for $specialDamage damage.";
            } else {
                $damage = calculateDamage($attacker, $defenderUnits[0]);
                $defenderTotalHP -= $damage;
                $combatLog[] = "{$attacker['name']} attacks {$defenderUnits[0]['name']} for $damage damage.";
            }

            // Check if defender is defeated
            if ($defenderTotalHP <= 0) {
                $combatLog[] = "{$defenderUnits[0]['name']} is defeated!";
                break 2; // Break out of both loops
            }
        }

        // Defender retaliates
        foreach ($defenderUnits as $defender) {
            $damage = calculateDamage($defender, $attackerUnits[0]);
            $attackerTotalHP -= $damage;
            $combatLog[] = "{$defender['name']} attacks {$attackerUnits[0]['name']} for $damage damage.";
            
            // Check if attacker is defeated
            if ($attackerTotalHP <= 0) {
                $combatLog[] = "{$attackerUnits[0]['name']} is defeated!";
                break 2; // Break out of both loops
            }
        }

        // Reduce cooldowns
        foreach ($attackerUnits as &$unit) {
            if ($unit['cooldown'] > 0) {
                $unit['cooldown']--;
            }
        }
        foreach ($defenderUnits as &$unit) {
            if ($unit['cooldown'] > 0) {
                $unit['cooldown']--;
            }
        }
    }

    return $combatLog;
}

// Function to simulate combat
function simulateCombat($attackerUnits, $defenderUnits) {
    $combatLog = [];
    $attackerTotalHP = array_sum(array_column($attackerUnits, 'hp'));
    $defenderTotalHP = array_sum(array_column($defenderUnits, 'hp'));

    // Combat loop
    while ($attackerTotalHP > 0 && $defenderTotalHP > 0) {
        // Attack phase
        foreach ($attackerUnits as $attacker) {
            // Apply special ability if applicable
            $specialDamage = applySpecialAbility($attacker, $defenderUnits[0]);
            if ($specialDamage > 0) {
                $defenderTotalHP -= $specialDamage;
                $combatLog[] = "{$attacker['name']} uses {$attacker['special_ability']} on {$defenderUnits[0]['name']} for $specialDamage damage.";
            } else {
                $damage = calculateDamage($attacker, $defenderUnits[0]);
                $defenderTotalHP -= $damage;
                $combatLog[] = "{$attacker['name']} attacks {$defenderUnits[0]['name']} for $damage damage.";
            }

            // Check if defender is defeated
            if ($defenderTotalHP <= 0) {
                $combatLog[] = "{$defenderUnits[0]['name']} is defeated!";
                break 2; // Break out of both loops
            }
        }

        // Defender retaliates
        foreach ($defenderUnits as $defender) {
            $damage = calculateDamage($defender, $attackerUnits[0]);
            $attackerTotalHP -= $damage;
            $combatLog[] = "{$defender['name']} attacks {$attackerUnits[0]['name']} for $damage damage.";
            
            // Check if attacker is defeated
            if ($attackerTotalHP <= 0) {
                $combatLog[] = "{$attackerUnits[0]['name']} is defeated!";
                break 2; // Break out of both loops
            }
        }
    }

    return $combatLog;
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user-selected unit IDs from the form
    $attackerUnitIds = $_POST['attacker_units']; // Array of selected attacker unit IDs
    $defenderUnitIds = $_POST['defender_units']; // Array of selected defender unit IDs

    // Fetch units from the database
    $attackerUnits = getUnits($pdo, $attackerUnitIds);
    $defenderUnits = getUnits($pdo, $defenderUnitIds);

    // Simulate combat
    $combatLog = simulateCombat($attackerUnits, $defenderUnits);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat Simulation</title>
</head>
<body>
    <h1>Combat Simulation</h1>

    <form method="POST">
        <h2>Select Attacker Units:</h2>
        <select name="attacker_units[]" multiple>
            <?php
            // Fetch all units for selection
            $stmt = $pdo->query("SELECT * FROM units");
            while ($unit = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$unit['id']}'>{$unit['name']} (Type: {$unit['type']})</option>";
            }
            ?>
        </select>

        <h2>Select Defender Units:</h2>
        <select name="defender_units[]" multiple>
            <?php
            // Fetch all units for selection
            $stmt->execute(); // Reset the statement to fetch again
            while ($unit = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$unit['id']}'>{$unit['name']} (Type: {$unit['type']})</option>";
            }
            ?>
        </select>

        <button type="submit">Start Combat</button>
    </form>

    <?php if (isset($combatLog)) : ?>
        <h2>Combat Log:</h2>
        <ul>
            <?php foreach ($combatLog as $logEntry) : ?>
                <li><?php echo $logEntry; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
