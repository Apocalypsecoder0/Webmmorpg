INSERT INTO users (username, password) VALUES ('admin', SHA2('admin', 256));
INSERT INTO planets (name, galaxy, system, position) VALUES
('Earth', 1, 1, 1),
('Mars', 1, 1, 2),
('Venus', 1, 1, 3);
INSERT INTO admin_settings (setting_name, setting_value) VALUES
('game_name', 'Sci-Fi Universe'),
('max_fleet_size', '100');
