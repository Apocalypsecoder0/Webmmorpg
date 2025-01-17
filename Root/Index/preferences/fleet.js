function loadContent(section) {
    const contentDiv = document.querySelector('.content');
    const xhr = new XMLHttpRequest();

    xhr.open('GET', `content.php?section=${section}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            contentDiv.innerHTML = `<h1>${section.charAt(0).toUpperCase() + section.slice(1)}</h1><p>${xhr.responseText}</p>`;
            if (section === 'fleet') {
                loadFleets();
            }
        } else {
            contentDiv.innerHTML = `<h1>Error</h1><p>Could not load content.</p>`;
        }
    };
    xhr.send();
}

function loadFleets() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_fleets.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('fleet-list').innerHTML = xhr.responseText;
        }
    };
    xhr.send();

    document.getElementById('fleet-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const fleetName = document.getElementById('fleet_name').value;
        const shipCount = document.getElementById('ship_count').value;
        addFleet(fleetName, shipCount);
    });
}

function addFleet(fleetName, shipCount) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_fleet.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Fleet added successfully!');
            loadFleets(); // Refresh fleet list
        }
    };
    xhr.send(`fleet_name=${encodeURIComponent(fleetName)}&ship_count=${encodeURIComponent(shipCount)}`);
}
