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

// Load the XML file
$xml = simplexml_load_file('users.xml');

// Find the user with the logged-in username
$user = $xml->xpath("//user[username='$loggedInUsername']");

// Check if the user exists
if ($user) {
    // Extract user information
    $email = (string)$user[0]->email;
    $gamesPlayed = (int)$user[0]->gamesPlayed;
    $score = (int)$user[0]->score;
} else {
    // User not found, handle the error (e.g., display an error message)
    $errorMessage = "User not found";
    // Define default values for variables to avoid warnings
    $email = "";
    $gamesPlayed = 0;
    $score = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>User Profile</title>
</head>
<body>
    <header>
        <h1>User Profile</h1>
    </header>
    <div class="profile-info">
        <div id="user-info">
            <h2>User Information</h2>
            <p><strong>Username:</strong> <?php echo $loggedInUsername; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
        </div>
        <div id="user-stats">
            <h2>User Statistics</h2>
            <p><strong>Games Played:</strong> <?php echo $gamesPlayed; ?></p>
            <p><strong>Score:</strong> <?php echo $score; ?></p>
        </div>
        <!-- Optionally, you can add an edit form here -->
        <div class="edit-button">
        <a href="edit_profile.php" class="btn">Edit User Information</a>
    </div>
    </div>



    <!-- Back button -->
    <div class="bck-container">
        <a href="home.php" class="back-button">Back</a>
    </div>

    <script src="profile.js"></script>
</body>
</html>
