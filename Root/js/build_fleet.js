async function buildFleet(userId, shipType, quantity) {
    // Create a new Ship instance
    const ship = new Ship(shipType, quantity);

    const response = await fetch('build_fleet.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_id: userId, ship_type: ship.type, quantity: ship.quantity })
    });

    const result = await response.json();
    if (result.status === 'success') {
        alert('Fleet built successfully!');
    } else {
        alert(`Error: ${result.message}`);
    }
}
class Ship {
    constructor(type, quantity, speed, capacity, defense, attackPower, hullIntegrity, manufacturer) {
        this.type = type;
        this.quantity = quantity;
        this.speed = speed;
        this.capacity = capacity;
        this.defense = defense;
        this.attackPower = attackPower;
        this.hullIntegrity = hullIntegrity;
        this.manufacturer = manufacturer;
    }

    getDetails() {
        return `Type: ${this.type}, Quantity: ${this.quantity}`;
    }

    calculateTravelTime(distance) {
        return distance / this.speed; // Returns time in hours
    }

    upgrade(attribute, amount) {
        if (this.hasOwnProperty(attribute)) {
            this[attribute] += amount;
            return `${attribute} upgraded by ${amount}. New value: ${this[attribute]}`;
        }
        return 'Attribute not found';
    }

    displayInfo() {
        return `Ship Type: ${this.type}, Quantity: ${this.quantity}, Speed: ${this.speed}, Capacity: ${this.capacity}, Defense: ${this.defense}, Attack Power: ${this.attackPower}, Hull Integrity: ${this.hullIntegrity}, Manufacturer: ${this.manufacturer}`;
    }

    engageCombat(opponentShip) {
        const damageToOpponent = this.attackPower - opponentShip.defense;
        const damageToSelf = opponentShip.attackPower - this.defense;

        return {
            opponentDamage: damageToOpponent > 0 ? damageToOpponent : 0,
            selfDamage: damageToSelf > 0 ? damageToSelf : 0
        };
    }
}
