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
