<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("HTTP/1.1 401 Unauthorized");
    exit("User not logged in");
}

// Load the XML file
$xml = simplexml_load_file('users.xml');

// Find the user with the logged-in username
$user = $xml->xpath("//user[username='{$_SESSION['username']}']");

// Check if the user exists
if (!$user) {
    // User not found, handle the error
    header("HTTP/1.1 404 Not Found");
    exit("User not found");
}

// Handle updating user's score if POST data is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['score'])) {
    // Retrieve the new score from the POST data
    $newScore = intval($_POST['score']);

    // Update the user's score in the XML file
    $user[0]->score = $newScore;
    $xml->asXML('users.xml');

    // Return success response
    header("HTTP/1.1 200 OK");
    exit("Score updated successfully");
}

// If no POST data provided, return the user's current score
header("HTTP/1.1 200 OK");
exit((string)$user[0]->score);
?>
