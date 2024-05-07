<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo 'User not logged in';
    exit;
}

// Load the XML file
$xml = simplexml_load_file('users.xml');
if ($xml === false) {
    echo 'Error loading XML file';
    exit;
}

// Find the user's data
$loggedInUser = $_SESSION['username']; // Get the logged-in user's username from the session
$user = $xml->xpath("//user[username='$loggedInUser']");
if (!$user) {
    echo 'User not found';
    exit;
}

// Increment the games played count
$gamesPlayed = intval($user[0]->gamesPlayed); // Convert to integer
$gamesPlayed++; // Increment
$user[0]->gamesPlayed = $gamesPlayed; // Assign back

// Save the updated XML file
if ($xml->asXML('users.xml')) {
    echo 'Success';
} else {
    echo 'Error saving XML file';
}
?>
