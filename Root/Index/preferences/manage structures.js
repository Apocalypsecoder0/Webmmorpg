function loadContent(section) {
    const contentDiv = document.querySelector('.content');
    const xhr = new XMLHttpRequest();

    xhr.open('GET', `content.php?section=${section}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            contentDiv.innerHTML = `<h1>${section.charAt(0).toUpperCase() + section.slice(1)}</h1><p>${xhr.responseText}</p>`;
            if (section === 'structures') {
                loadStructures();
            }
        } else {
            contentDiv.innerHTML = `<h1>Error</h1><p>Could not load content.</p>`;
        }
    };
    xhr.send();
}

function loadStructures() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_structures.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('structure-list').innerHTML = xhr.responseText;
        }
    };
    xhr.send();

    document.getElementById('structure-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const structureName = document.getElementById('structure_name').value;
        const level = document.getElementById('level').value;
        addStructure(structureName, level);
    });
}

function addStructure(structureName, level) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'add_structure.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Structure added successfully!');
            loadStructures(); // Refresh structure list
        }
    };
    xhr.send(`structure_name=${encodeURIComponent(structureName)}&level=${encodeURIComponent(level)}`);
}
