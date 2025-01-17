CREATE TABLE sectors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    x_coordinate INT NOT NULL,
    y_coordinate INT NOT NULL,
    terrain_type VARCHAR(50) NOT NULL
);
ALTER TABLE sectors ADD COLUMN terrain_type ENUM('forest', 'desert', 'mountain', 'river', 'plain') NOT NULL;
Modify the PHP Code to randomly assign more terrain types:
$terrainTypes = ['forest', 'desert', 'mountain', 'river', 'plain'];
$terrain = $terrainTypes[array_rand($terrainTypes)];
Update the JavaScript Rendering Logic:
sectors.forEach(sector => {
    const x = sector.x_coordinate * 5;
    const y = sector.y_coordinate * 5;

    switch (sector.terrain_type) {
        case 'forest':
            ctx.fillStyle = 'green';
            break;
        case 'desert':
            ctx.fillStyle = 'yellow';
            break;
        case 'mountain':
            ctx.fillStyle = 'gray';
            break;
        case 'river':
            ctx.fillStyle = 'blue';
            break;
        case 'plain':
            ctx.fillStyle = 'lightgreen';
            break;
    }

    ctx.fillRect(x, y, 5, 5);
    ctx.strokeText(sector.name, x, y);
});
