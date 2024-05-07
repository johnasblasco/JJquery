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
if (!$user) {
    // User not found, handle the error (e.g., display an error message)
    $errorMessage = "User not found";
} else {
    // Extract user information
    $email = "";
    $password = "";
    if ($user) {
        $email = (string)$user[0]->email;
        $password = (string)$user[0]->password;
    }
}

// Handle form submission for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve new information from the form
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    // Update the user's information in the XML file
    if ($user) {
        $user[0]->username = $newUsername;
        $user[0]->email = $newEmail;
        $user[0]->password = $newPassword;
        $xml->asXML('users.xml');
    }

    // Redirect back to the profile page after updating
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_profile.css">
    <title>Edit User Profile</title>
</head>
<body>
    <header>
        <h1>Edit User Profile</h1>
    </header>
    <div class="edit-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $loggedInUsername; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Save Changes" class="btn" onclick="alert('SUCCESS')">
            </div>
        </form>
    </div>

    <div class="bck-container">
        <a href="profile.php" class="back-button">Back</a>
    </div>

</body>
</html>
