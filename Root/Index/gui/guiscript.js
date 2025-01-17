document.querySelectorAll('.sidebar ul li a').forEach(link => {
    link.addEventListener('click', function() {
        // Remove active class from all links
        document.querySelectorAll('.sidebar ul li a').forEach(item => {
            item.classList.remove('active');
        });
        // Add active class to the clicked link
        this.classList.add('active');
    });
});
