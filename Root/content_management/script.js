document.querySelectorAll('.sidebar ul li a').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior

        // Remove active class from all links
        document.querySelectorAll('.sidebar ul li a').forEach(item => {
            item.classList.remove('active');
        });
        // Add active class to the clicked link
        this.classList.add('active');

        // Load content dynamically
        const section = this.getAttribute('href').substring(1); // Get section name
        loadContent(section);
    });
});

// Function to load content dynamically
function loadContent(section) {
    const contentDiv = document.querySelector('.content');
    const xhr = new XMLHttpRequest(); // Create a new XMLHttpRequest object

    xhr.open('GET', `content.php?section=${section}`, true); // Prepare the request
    xhr.onload = function() {
        if (xhr.status === 200) {
            contentDiv.innerHTML = `<h1>${section.charAt(0).toUpperCase() + section.slice(1)}</h1><p>${xhr.responseText}</p>`;
        } else {
            contentDiv.innerHTML = `<h1>Error</h1><p>Could not load content.</p>`;
        }
    };
    xhr.send(); // Send the request
}

// Load default content on page load
document.addEventListener('DOMContentLoaded', () => {
    loadContent('overview');
});
