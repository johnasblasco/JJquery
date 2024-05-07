<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate data if needed

    // Load the existing XML file or create a new one if it doesn't exist
    if (file_exists('users.xml')) {
        $xml = simplexml_load_file('users.xml');
    } else {
        $xml = new SimpleXMLElement('<users></users>');
    }

    // Create a new user element
    $user = $xml->addChild('user');
    $user->addChild('email', $email);
    $user->addChild('username', $username);
    $user->addChild('password', $password);

    // Add games played and score containers
    $user->addChild('gamesPlayed', 0);
    $user->addChild('score', 0);

    // Save the XML file
    $xml->asXML('users.xml');

    // Redirect to a success page or do any other necessary actions
    header("Location: home.php");
    exit;
}
?>


<!-- Your HTML code for register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Sign up</header>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Sign Up">
                </div>
                <div class="links">
                    Already have an account? <a href="login.php">Login</a>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>
