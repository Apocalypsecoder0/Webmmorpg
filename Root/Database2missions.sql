CREATE TABLE missions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    reward INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE user_missions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    mission_id INT,
    status ENUM('not_started', 'in_progress', 'completed', 'failed'),
    progress INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (mission_id) REFERENCES missions(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_id INT,
    resource_type ENUM('resources', 'items', 'experience'),
    amount INT,
    FOREIGN KEY (mission_id) REFERENCES missions(id)
);
INSERT INTO rewards (mission_id, resource_type, amount) VALUES
(1, 'resources', 100),
(2, 'items', 1),
(3, 'experience', 50);
CREATE TABLE user_missions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    mission_id INT,
    status ENUM('not_started', 'in_progress', 'completed', 'failed'),
    progress INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (mission_id) REFERENCES missions(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_id INT,
    resource_type ENUM('resources', 'items', 'experience'),
    amount INT,
    FOREIGN KEY (mission_id) REFERENCES missions(id)
);
-- Insert sample missions
INSERT INTO missions (mission_name, description, reward) VALUES
('Defend the Castle', 'Protect the castle from invading forces.', 100),
('Rescue the Hostage', 'Save the hostage from the enemy camp.', 150),
('Eliminate the Bandit Leader', 'Take down the bandit leader terrorizing the village.', 200);
INSERT INTO missions (mission_name, description, reward) VALUES
('Infiltrate the Enemy Base', 'Sneak into the enemy base and gather intelligence.', 250),
('Protect the Caravan', 'Guard the merchant caravan from bandit attacks.', 300),
('Defeat the Dragon', 'Slay the dragon terrorizing the village.', 500),
('Gather Resources', 'Collect resources from the enchanted forest.', 150),
('Investigate the Haunted Ruins', 'Explore the haunted ruins and uncover their secrets.', 200);
CREATE TABLE scenarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mission_id INT NOT NULL,
    scenario_description TEXT NOT NULL,
    difficulty_level INT NOT NULL,
    FOREIGN KEY (mission_id) REFERENCES missions(id)
);

-- Insert sample scenarios
INSERT INTO scenarios (mission_id, scenario_description, difficulty_level) VALUES
(1, 'The base is heavily guarded; players must find a way to distract the guards.', 3),
(2, 'The caravan is ambushed at night; players must defend against surprise attacks.', 4),
(3, 'The dragon has a protective shield; players must find a way to disable it.', 5),
(4, 'The enchanted forest is filled with magical creatures that can hinder progress.', 2),
(5, 'The haunted ruins are cursed; players must avoid traps while exploring.', 3);

CREATE TABLE seasonal_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    reward INT NOT NULL
);
CREATE TABLE missions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('exploration', 'daily', 'side', 'tutorial', 'mainstay'),
    description TEXT,
    reward TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(255),
    current_mission_id INT,
    FOREIGN KEY (current_mission_id) REFERENCES missions(id)
);

INSERT INTO missions (type, description, reward) VALUES
('exploration', 'Explore a new planet.', '100 resources'),
('daily', 'Complete your daily tasks.', '50 resources'),
('side', 'Help a neighbor with their tasks.', '30 resources'),
('tutorial', 'Learn the basics of the game.', '20 resources'),
('mainstay', 'Defend your base from attacks.', '150 resources');
-- Insert sample seasonal events
INSERT INTO seasonal_events (event_name, description, start_date, end_date, reward) VALUES
('Winter Festival', 'Participate in the Winter Festival and complete special missions.', '2023-12-01', '2023-12-31', 400),
('Spring Awakening', 'Help restore the balance of nature during the Spring Awakening.', '2024-03-01', '2024-03-31', 300),
('Summer Showdown', 'Compete in the Summer Showdown against other players.', '2024-06-01', '2024-06-30', 500),
('Autumn Harvest', 'Gather resources and prepare for winter during the Autumn Harvest.', '2024-09-01', '2024-09-30', 350);
ALTER TABLE missions ADD COLUMN start_date DATE NULL;
ALTER TABLE missions ADD COLUMN end_date DATE NULL;

-- Insert limited-time missions
INSERT INTO missions (mission_name, description, reward, start_date, end_date) VALUES
('Limited Time: Capture the Flag', 'Capture the enemy flag within 24 hours.', 200, '2024-01-01', '2024-01-02'),
('Limited Time: Defend the Fortress', 'Hold the fortress against waves of enemies for 48 hours.', 300, '2024-01-05', '2024-01-07');
ALTER TABLE seasonal_events ADD COLUMN special_reward INT DEFAULT 0;

-- Update existing seasonal events with special rewards
UPDATE seasonal_events SET special_reward = 500 WHERE event_name = 'Winter Festival';
UPDATE seasonal_events SET special_reward = 300 WHERE event_name = 'Spring Awakening';
UPDATE seasonal_events SET special_reward = 600 WHERE event_name = 'Summer Showdown';
UPDATE seasonal_events SET special_reward = 400 WHERE event_name = 'Autumn Harvest';
CREATE TABLE community_challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    challenge_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    target_count INT NOT NULL,
    current_count INT DEFAULT 0,
    reward INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL
);

-- Insert sample community challenges
INSERT INTO community_challenges (challenge_name, description, target_count, reward, start_date, end_date) VALUES
('Collect 1000 Resources', 'Players must collectively gather 1000 resources.', 1000, 300, '2024-01-01', '2024-01-31'),
('Defeat 500 Enemies', 'Players must work together to defeat 500 enemies.', 500, 500, '2024-01-01', '2024-01-CREATE TABLE community_leaderboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_id INT NOT NULL,
    challenge_id INT NOT NULL,
    contribution INT NOT NULL,
    FOREIGN KEY (player_id) REFERENCES players(id),
    FOREIGN KEY (challenge_id) REFERENCES community_challenges(id)
);
    ALTER TABLE missions ADD COLUMN unique_reward INT DEFAULT 0;

-- Update existing limited-time missions with unique rewards
UPDATE missions SET unique_reward = 500 WHERE mission_name = 'Limited Time: Capture the Flag';
UPDATE missions SET unique_reward = 700 WHERE mission_name = 'Limited Time: Defend the Fortress';
CREATE TABLE special_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    reward INT NOT NULL
);

-- Insert sample special events
INSERT INTO special_events (event_name, description, start_date, end_date, reward) VALUES
('Double Points Weekend', 'Earn double points on all missions this weekend!', '2024-02-01', '2024-02-03', 0),
('Mystery Box Event', 'Complete missions to earn mystery boxes with random rewards!', '2024-02-10', '2024-02-17', 0);
    
};
CREATE TABLE special_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    reward INT NOT NULL
);

-- Insert sample special events
INSERT INTO special_events (event_name, description, start_date, end_date, reward) VALUES
('Double Points Weekend', 'Earn double points on all missions this weekend!', '2024-02-01', '2024-02-03', 0),
('Mystery Box Event', 'Complete missions to earn mystery boxes with random rewards!', '2024-02-10', '2024-02-17', 0);
    CREATE TABLE community_leaderboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_id INT NOT NULL,
    challenge_id INT NOT NULL,
    contribution INT NOT NULL,
    FOREIGN KEY (player_id) REFERENCES players(id),
    FOREIGN KEY (challenge_id) REFERENCES community_challenges(id)
);
