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
            <a href="game.php">New Game</a>
        </div>

        <!-- Display user's basic statistics -->
        <div class="user-stats">
            <h2>Your Statistics</h2>
            <h3>Wins: <span id="wins">-</span></h3>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch XML data
            $.ajax({
                type: "GET",
                url: "users.xml",
                dataType: "xml",
                success: function(xml) {
                    let wins = 0;
                    console.log(wins)
                    // Loop through each user entry in the XML
                    $(xml).find('user').each(function() {
                        // Extract relevant statistics
                        const winCount = $(this).find('score').text();
                        console.log(wincount)
                        // Update total statistics
                        wins += parseInt(winCount);
                    });
                    console.log(wins)
                    // Update HTML with the fetched statistics
                    $('#wins').text(wins);

                },

                
                error: function() {
                    console.error('Error fetching user statistics.');
                }
            });
        });
    </script>
</body>
</html>
