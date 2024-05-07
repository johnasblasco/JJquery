// profile.js

document.addEventListener('DOMContentLoaded', () => {
    // Fetch user data from XML file
    fetchUserData();
});

function fetchUserData() {
    // Replace 'users.xml' with the path to your XML file
    fetch('users.xml')
        .then(response => response.text())
        .then(data => {
            // Parse XML data
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(data, 'text/xml');

            // Get user information
            const username = xmlDoc.querySelector('username').textContent;
            const gamesPlayed = xmlDoc.querySelector('gamesPlayed').textContent;
            const wins = xmlDoc.querySelector('wins').textContent;
            const losses = xmlDoc.querySelector('losses').textContent;
            const gameProgress = xmlDoc.querySelector('gameProgress').textContent;

            // Display user information on the profile page
            displayUserInfo(username);
            displayUserStats(gamesPlayed, wins, losses);
            displayGameProgress(gameProgress);
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
}

function displayUserInfo(username) {
    const userInfoContainer = document.getElementById('user-info');
    userInfoContainer.textContent = `Username: ${username}`;
}

function displayUserStats(gamesPlayed, wins, losses) {
    const userStatsContainer = document.getElementById('user-stats');
    userStatsContainer.innerHTML = `
        <p>Games Played: ${gamesPlayed}</p>
        <p>Wins: ${wins}</p>
        <p>Losses: ${losses}</p>
    `;
}

function displayGameProgress(progress) {
    const gameProgressContainer = document.getElementById('game-progress');
    gameProgressContainer.textContent = `Game Progress: ${progress}`;
}
