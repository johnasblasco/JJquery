<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // You should validate the username and password against your records (e.g., from users.xml)
    // For simplicity, let's assume you have a users.xml file with the same structure as in the registration part

    // Load the XML file
    $xml = simplexml_load_file('users.xml');
    
    // Search for the user with the provided username and password
    $user = $xml->xpath("//user[username='$username' and password='$password']");
    
    if ($user) {
        // User found, set session variables and redirect to home page or dashboard
        $_SESSION['username'] = (string)$user[0]->username;
        $_SESSION['email'] = (string)$user[0]->email;
        
        // Redirect to home page or dashboard
        header("Location: home.php");
        exit;
    } else {
        // User not found or incorrect password, handle the error (e.g., display an error message)
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>

</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up</a>
                </div>

                <?php if(isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
            </form>
        </div>
    </div>
</body>
</html>
