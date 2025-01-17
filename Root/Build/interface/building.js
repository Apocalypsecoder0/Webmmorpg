document.getElementById('build-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const structureName = document.getElementById('structure_name').value;
    const level = document.getElementById('level').value;
    buildStructure(structureName, level);
});

function buildStructure(structureName, level) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'build_structure.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('build-status').innerText = xhr.responseText;
        }
    };
    xhr.send(`structure_name=${encodeURIComponent(structureName)}&level=${encodeURIComponent(level)}`);
}
