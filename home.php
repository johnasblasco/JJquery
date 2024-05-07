<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit;
}

// Retrieve the logged-in user's username
$loggedInUsername = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Home</title>

    <style>
        body {
            background-image: url('home/home.png'); /* Replace 'background.jpg' with the name of your image file */
            background-size: cover;
            background-position: center bottom; /* Adjusted background position */
            background-repeat: no-repeat;
            font-family: 'Roboto', sans-serif;
            color: black;
            margin: 0; /* Ensure no default margin */
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="home-screen">
        <!-- Navigation options -->
        <div class="navigation">
            <a href="about.php">About</a>
            <a href="how.php">How to Play</a>
            <a href="profile.php">View Profile</a>
        </div>

        <div class="play-container">
            <a href="game.php" id="new-game">New Game</a>
            <a href="index.php" style="background-color: red;">Log out</a>
        </div>

        <!-- Display user's basic statistics -->
        <div class="user-stats">
            <h2>Your Statistics</h2>
            <h3>Wins: <span id="wins">-</span></h3>
            <h3>Gameplayed: <span id="gameplayed" >-</span></h3>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#new-game').click(function(e) {
            e.preventDefault(); // Prevent default link behavior

            // Send AJAX request to PHP script
            $.ajax({
                type: "POST",
                url: "update_games_played.php",
                data: {}, // You can pass additional data if needed
                success: function(response) {
                    console.log("Game played count updated successfully.");
                    window.location.href = "game.php"; // Redirect to game.php after successful update
                },
                error: function() {
                    console.error('Error updating game played count.');
                }
            });
        });

            // Fetch XML data
        // Fetch XML data
        $.ajax({
                type: "GET",
                url: "users.xml",
                dataType: "xml",
                cache: false,
                success: function(xml) {
                    let wins = 0;
                    let gamesPlayed = 0; // Initialize gamesPlayed variable

                    // Loop through each user entry in the XML
                    $(xml).find('user').each(function() {
                        // Extract relevant statistics
                        const username = $(this).find('username').text();
                        const winCount = parseInt($(this).find('score').text());
                        const playedCount = parseInt($(this).find('gamesPlayed').text());

                        // Check if the username matches the logged-in user
                        if (username === '<?php echo $loggedInUsername; ?>') {
                            // Update total statistics
                            wins = winCount;
                            gamesPlayed = playedCount;
                            return false; // Exit the loop once user is found
                        }
                    });

                    // Update HTML with the fetched statistics
                    $('#wins').text(wins);
                    $('#gameplayed').text(gamesPlayed); // Update gamesPlayed count
                },
                error: function() {
                    console.error('Error fetching user statistics.');
                }
            });

    });
    </script>
</body>
</html>
