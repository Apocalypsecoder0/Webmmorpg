CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    race VARCHAR(20) DEFAULT NULL
    factions VARCHAR(20) DEFAULT NULL
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE admin_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_name VARCHAR(50) NOT NULL UNIQUE,
    setting_value VARCHAR(255) NOT NULL
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE DATABASE admin_panel;

USE admin_panel;

-- Table for users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for content (e.g., posts)
CREATE TABLE content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE universes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    galaxy_count INT NOT NULL,
    description TEXT
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO universes (name, galaxy_count, description) VALUES
('Milky Way', 100, 'A barred spiral galaxy containing our solar system.'),
('Andromeda', 200, 'The nearest spiral galaxy to the Milky Way.'),
('Triangulum', 50, 'A spiral galaxy located in the Triangulum constellation.');
ALTER TABLE planets
ADD COLUMN diameter VARCHAR(50),
ADD COLUMN distance_from_sun VARCHAR(50),
ADD COLUMN fun_fact TEXT;

UPDATE planets SET 
diameter = '4,880 km', 
distance_from_sun = '57.91 million km', 
fun_fact = 'Mercury has no atmosphere.' 
WHERE name = 'Mercury';

UPDATE planets SET 
diameter = '12,104 km', 
distance_from_sun = '108.2 million km', 
fun_fact = 'Venus is the hottest planet in our solar system.' 
WHERE name = 'Venus';

UPDATE planets SET 
diameter = '12,742 km', 
distance_from_sun = '149.6 million km', 
fun_fact = 'Earth is the only planet known to support life.' 
WHERE name = 'Earth';

UPDATE planets SET 
diameter = '6,779 km', 
distance_from_sun = '227.9 million km', 
fun_fact = 'Mars has the largest dust storms in the solar system.' 
WHERE name = 'Mars';

UPDATE planets SET 
diameter = '139,820 km', 
distance_from_sun = '778.5 million km', 
fun_fact = 'Jupiter has a giant storm called the Great Red Spot.' 
WHERE name = 'Jupiter';

UPDATE planets SET 
diameter = '116,460 km', 
distance_from_sun = '1.434 billion km', 
fun_fact = 'Saturn is known for its stunning rings.' 
WHERE name = 'Saturn';

UPDATE planets SET 
diameter = '50,724 km', 
distance_from_sun = '2.871 billion km', 
fun_fact = 'Uranus rotates on its side.' 
WHERE name = 'Uranus';

UPDATE planets SET 
diameter = '49,244 km', 
distance_from_sun = '4.495 billion km', 
fun_fact = 'Neptune has the strongest winds in the solar system.' 
WHERE name = 'Neptune';

USE game_planets;

CREATE TABLE planets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL
);
INSERT INTO planets (name, description, image) VALUES
('Mercury', 'The closest planet to the Sun.', 'images/mercury.jpg'),
('Venus', 'The second planet from the Sun.', 'images/venus.jpg'),
('Earth', 'The third planet from the Sun and our home.', 'images/earth.jpg'),
('Mars', 'The fourth planet, known as the Red Planet.', 'images/mars.jpg'),
('Jupiter', 'The largest planet in our solar system.', 'images/jupiter.jpg'),
('Saturn', 'Known for its beautiful rings.', 'images/saturn.jpg'),
('Uranus', 'An ice giant with a unique tilt.', 'images/uranus.jpg'),
('Neptune', 'The farthest planet from the Sun.', 'images/neptune.jpg');
CREATE TABLE planets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    owner_id INT NULL,
    galaxy INT NOT NULL,
    system INT NOT NULL,
    position INT NOT NULL,
    FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE SET NULL
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE favorites (
    user_id INT,
    planet_id INT,
    PRIMARY KEY (user_id, planet_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (planet_id) REFERENCES planets(id)
);
CREATE TABLE moons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    planet_id INT NOT NULL,
    stargate_id INT NOT NULL,
    FOREIGN KEY (planet_id) REFERENCES planets(id) ON DELETE CASCADE,
    FOREIGN KEY (stargate_id) REFERENCES stargates(id) ON DELETE CASCADE
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE stargates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    origin_moon_id INT NOT NULL,
    destination_moon_id INT NOT NULL,
    travel_cost INT NOT NULL, -- Cost in energy or resources
    FOREIGN KEY (origin_moon_id) REFERENCES moons(id) ON DELETE CASCADE,
    FOREIGN KEY (destination_moon_id) REFERENCES moons(id) ON DELETE CASCADE
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE stargates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    origin_planet_id INT NOT NULL,
    destination_planet_id INT NOT NULL,
    travel_cost INT NOT NULL, -- Cost in energy or resources
    FOREIGN KEY (origin_planet_id) REFERENCES planet(id) ON DELETE CASCADE,
    FOREIGN KEY (destination_planet_id) REFERENCES planet(id) ON DELETE CASCADE
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE resources (
    user_id INT PRIMARY KEY,
    metal BIGINT DEFAULT 1000,
    crystal BIGINT DEFAULT 1000,
    deuterium BIGINT DEFAULT 1000,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
ALTER TABLE resources ADD COLUMN turns INT DEFAULT 0;
ALTER TABLE resources ADD COLUMN gold INT DEFAULT 0;
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    score INT NOT NULL
);

CREATE TABLE fleets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner_id INT NOT NULL,
    ship_type VARCHAR(50) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE combat_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attacker_id INT NOT NULL,
    defender_id INT NOT NULL,
    winner VARCHAR(50) NOT NULL,
    damage INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (attacker_id) REFERENCES users(id),
    FOREIGN KEY (defender_id) REFERENCES users(id)
);

CREATE TABLE goverment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    class VARCHAR(50) NOT NULL,
    level INT DEFAULT 1,
    experience INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE guilds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    leader_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (leader_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE alliances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    leader_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (leader_id) REFERENCES users(id) ON DELETE CASCADE
);
ALTER TABLE users ADD COLUMN guild_id INT NULL;
ALTER TABLE users ADD COLUMN alliance_id INT NULL;

);
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE world_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE alliance_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alliance_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (alliance_id) REFERENCES alliances(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE guild_chat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guild_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (guild_id) REFERENCES guilds(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE research_topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    research_name VARCHAR(255) NOT NULL,
    description TEXT,
    required_level INT DEFAULT 1,   -- Optional: if you have levels of research
    duration INT NOT NULL,           -- Duration in minutes, for example
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE user_research (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    research_id INT NOT NULL,
    progress INT DEFAULT 0,  -- Progress percentage (0-100)
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),           -- Assuming 'users' table exists
    FOREIGN KEY (research_id) REFERENCES research_topics(id),
    UNIQUE(user_id, research_id) -- Each user can only research a topic once
);
CREATE TABLE user_technologies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    technology_id INT NOT NULL,
    unlocked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (technology_id) REFERENCES technologies(id),
    UNIQUE(user_id, technology_id)  -- Each user can unlock each technology only once
);
CREATE TABLE user_resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    minerals INT DEFAULT 0,
    energy INT DEFAULT 0,
    credits INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
SELECT t.id, t.technology_name, t.description
FROM technologies t
LEFT JOIN user_technologies ut ON t.id = ut.technology_id AND ut.user_id = {user_id}
WHERE ut.id IS NULL  -- User hasn't unlocked the technology yet
AND JSON_UNQUOTE(JSON_EXTRACT(t.requirements, '$.minerals')) <= (SELECT minerals FROM user_resources WHERE user_id = {user_id})
AND JSON_UNQUOTE(JSON_EXTRACT(t.requirements, '$.energy')) <= (SELECT energy FROM user_resources WHERE user_id = {user_id});
// Example of saving to the database (in faction.php after selection)
$selectedFaction = $_POST['faction'];
$userId = 1; // Replace with the actual user ID from your session or registration process

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    race VARCHAR(50),
    faction VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE users ADD COLUMN race VARCHAR(50);
ALTER TABLE users ADD COLUMN government VARCHAR(50);

CREATE TABLE races (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);
CREATE TABLE factions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    race_id INT,
    FOREIGN KEY (race_id) REFERENCES races(id)
);
INSERT INTO races (name, description) VALUES
('Human', 'Humans are versatile and adaptable.'),
('Elf', 'Elves are agile and skilled in magic.'),
('Orc', 'Orcs are strong and resilient warriors.'),
('Dwarf', 'Dwarves are tough and skilled craftsmen.');

INSERT INTO factions (name, race_id) VALUES
('Knights of Valor', 1),  -- Human
('The Merchant Guild', 1), 
('The Silver Circle', 2),  -- Elf
('The Arcane Order', 2), 
('The Iron Horde', 3),     -- Orc
('The Blood Pact', 3), 
('The Stone Clan', 4),     -- Dwarf
('The Forge Brotherhood', 4);

CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    resources INT DEFAULT 1000
);

CREATE TABLE ships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_id INT,
    ship_type VARCHAR(50),
    quantity INT,
    FOREIGN KEY (player_id) REFERENCES players(id)
);

CREATE TABLE defenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_id INT,
    defense_type VARCHAR(50),
    quantity INT,
    FOREIGN KEY (player_id) REFERENCES players(id)
);
CREATE TABLE battle_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attacker_id INT,
    defender_id INT,
    result TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (attacker_id) REFERENCES players(id),
    FOREIGN KEY (defender_id) REFERENCES players(id)
);
CREATE DATABASE game_db;

USE game_db;

-- Table for Units
CREATE TABLE units (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    type VARCHAR(20) NOT NULL,
    hp INT NOT NULL,
    attack_power INT NOT NULL,
    defense INT NOT NULL,
    speed INT NOT NULL,
    range INT NOT NULL,
    training_time INT NOT NULL, -- in seconds
    cost INT NOT NULL
);

-- Table for Training Queue
CREATE TABLE training_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    unit_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    FOREIGN KEY (unit_id) REFERENCES units(id)
);

CREATE TABLE units (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    attack_power INT NOT NULL,
    defense INT NOT NULL,
    hp INT NOT NULL,
    speed INT NOT NULL,
    cost INT NOT NULL,
    type VARCHAR(50),
    strengths_weaknesses TEXT
);

INSERT INTO units (name, attack_power, defense, hp, speed, cost, type, strengths_weaknesses) VALUES
('Fighter', 50, 20, 100, 30, 200, 'Fighter', 'Cruiser: Strong, Battleship: Weak'),
('Cruiser', 40, 30, 150, 25, 300, 'Cruiser', 'Battleship: Strong, Fighter: Weak'),
('Battleship', 60, 50, 200, 15, 500, 'Battleship', 'Fighter: Strong, Cruiser: Weak');
ALTER TABLE units ADD COLUMN special_ability VARCHAR(100);

UPDATE units SET special_ability = 'Critical Strike' WHERE id = 1; -- Fighter
UPDATE units SET special_ability = 'Shield' WHERE id = 2; -- Cruiser
UPDATE units SET special_ability = 'Repair' WHERE id = 3; -- Battleship

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(50) NOT NULL,
    feedback_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert new unit types
INSERT INTO units (name, type, attack_power, defense, special_ability, strengths_weaknesses) VALUES
('Assassin', 'Stealth', 70, 30, 'Backstab', 'Fighter'),
('Mage', 'Magic', 60, 20, 'Fireball', 'Cruiser'),
('Tank', 'Heavy', 50, 80, 'Fortify', 'Assassin'),
('Healer', 'Support', 20, 30, 'Heal', 'None');

-- Update existing units with cooldowns
ALTER TABLE units ADD COLUMN cooldown INT DEFAULT 0;

-- Example of setting cooldowns for special abilities
UPDATE units SET cooldown = 3 WHERE special_ability = 'Backstab'; -- Assassin
UPDATE units SET cooldown = 2 WHERE special_ability = 'Fireball'; -- Mage
UPDATE units SET cooldown = 4 WHERE special_ability = 'Fortify'; -- Tank
UPDATE units SET cooldown = 1 WHERE special_ability = 'Heal'; -- Healer

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    preferences TEXT
);

CREATE TABLE fleets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    fleet_name VARCHAR(50),
    ship_count INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE structures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    structure_name VARCHAR(50),
    level INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE advanced_structures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    structure_name VARCHAR(50),
    level INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE attacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attacker_id INT NOT NULL,
    defender_id INT NOT NULL,
    result VARCHAR(255),
    FOREIGN KEY (attacker_id) REFERENCES users(id),
    FOREIGN KEY (defender_id) REFERENCES users(id)
);
