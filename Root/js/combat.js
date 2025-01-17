async function initiateCombat(attackerId, defenderId, attackerFleet, defenderFleet) {
    const response = await fetch('combat.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ attacker_id: attackerId, defender_id: defenderId, attacker_fleet: attackerFleet, defender_fleet: defenderFleet })
    });

    const result = await response.json();
    alert(`Winner: ${result.winner}, Damage: ${result.damage}`);
}
