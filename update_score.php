<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the new score from the AJAX request
    $newScore = $_POST['score'];

    // Load the XML file
    $xml = simplexml_load_file('users.xml');

    // Find the user node (you need to modify this based on your XML structure)
    $user = $xml->user; // Assuming there's only one user in your XML file

    // Update the score
    $user->score = $newScore;

    // Save the updated XML file
    $xml->asXML('users.xml');

    // Send success response
    echo json_encode(['success' => true]);
} else {
    // Send error response if request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
