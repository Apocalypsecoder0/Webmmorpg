<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Display</title>
    <style>
        #map {
            width: 500px;
            height: 500px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <canvas id="map"></canvas>
    <script>
        const sectors = <?php echo json_encode($sectors); ?>; // Get sectors from PHP

        const canvas = document.getElementById('map');
        const ctx = canvas.getContext('2d');

        sectors.forEach(sector => {
            const x = sector.x_coordinate * 5; // Scale for better visibility
            const y = sector.y_coordinate * 5; // Scale for better visibility
            ctx.fillStyle = sector.terrain_type === 'forest' ? 'green' : 'yellow';
            ctx.fillRect(x, y, 5, 5); // Draw sector as a small square
            ctx.strokeText(sector.name, x, y);
        });
    </script>
        canvas.addEventListener('click', function(event) {
    const rect = canvas.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    sectors.forEach(sector => {
        const sectorX = sector.x_coordinate * 5; // Scale for visibility
        const sectorY = sector.y_coordinate * 5; // Scale for visibility
        if (x >= sectorX && x <= sectorX + 5 && y >= sectorY && y <= sectorY + 5) {
            alert(`Sector: ${sector.name}\nTerrain: ${sector.terrain_type}`);
        }
    });
});
</body>
</html>
