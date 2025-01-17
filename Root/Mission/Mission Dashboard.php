<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .progress {
            height: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Mission Dashboard</h1>
        <div id="missions" class="mt-4">
            <!-- Mission items will be dynamically inserted here -->
        </div>
    </div>

    <script>
        // Example of fetching missions and displaying them
        async function fetchMissions() {
            const response = await fetch('api/get_missions.php'); // Replace with your API endpoint
            const missions = await response.json();
            const missionsContainer = document.getElementById('missions');

            missions.forEach(mission => {
                const missionElement = document.createElement('div');
                missionElement.className = 'card mb-3';
                missionElement.innerHTML = `
                    <div class="card-body">
                        <h5 class="card-title">${mission.description}</h5>
                        <p class="card-text">Status: ${mission.status}</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: ${mission.progress}%" aria-valuenow="${mission.progress}" aria-valuemin="0" aria-valuemax="100">${mission.progress}%</div>
                        </div>
                    </div>
                `;
                missionsContainer.appendChild(missionElement);
            });
        }

        // Call the function to fetch and display missions
        fetchMissions();
    </script>
</body>
</html>
