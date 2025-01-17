async function fetchResources(userId) {
    const response = await fetch(`get_resources.php?user_id=${userId}`);
    const resources = await response.json();
    console.log('Resources:', resources);
}
