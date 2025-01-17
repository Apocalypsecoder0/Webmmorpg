
document.querySelectorAll('.sidebar ul li a').forEach(link => {
    link.addEventListener('click', function() {
        // Remove active class from all links
        document.querySelectorAll('.sidebar ul li a').forEach(item => {
            item.classList.remove('active');
        });
        // Add active class to the clicked link
        this.classList.add('active');
        
        // Load content dynamically (optional)
        loadContent(this.getAttribute('href').substring(1));
    });
});

// Function to load content dynamically (optional)
function loadContent(section) {
    const contentDiv = document.querySelector('.content');
    contentDiv.innerHTML = `<h1>${section.charAt(0).toUpperCase() + section.slice(1)}</h1><p>Content for ${section} goes here.</p>`;
}
