function loadContent(section) {
    const contentDiv = document.querySelector('.content');
    const xhr = new XMLHttpRequest();

    xhr.open('GET', `content.php?section=${section}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            contentDiv.innerHTML = `<h1>${section.charAt(0).toUpperCase() + section.slice(1)}</h1><p>${xhr.responseText}</p>`;
            if (section === 'preferences') {
                loadPreferences();
            }
        } else {
            contentDiv.innerHTML = `<h1>Error</h1><p>Could not load content.</p>`;
        }
    };
    xhr.send();
}

function loadPreferences() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_preferences.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('preferences').value = xhr.responseText;
        }
    };
    xhr.send();

    document.getElementById('preferences-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const preferences = document.getElementById('preferences').value;
        savePreferences(preferences);
    });
}

function savePreferences(preferences) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_preferences.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Preferences saved successfully!');
        }
    };
    xhr.send(`preferences=${encodeURIComponent(preferences)}`);
}
