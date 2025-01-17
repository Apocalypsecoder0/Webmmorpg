document.getElementById('add-friend').addEventListener('click', function() {
    // Get the input value
    const friendName = document.getElementById('friend-name').value;

    // Check if the input is not empty
    if (friendName.trim() !== '') {
        // Create a new list item
        const li = document.createElement('li');
        li.textContent = friendName;

        // Append the new friend to the friends list
        document.getElementById('friends-list').appendChild(li);

        // Clear the input field
        document.getElementById('friend-name').value = '';
    } else {
        alert('Please enter a friend\'s name.');
    }
});
