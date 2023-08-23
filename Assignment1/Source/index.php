<?php
// Start a session at the beginning of the file
session_start();

// Include the database connection code from configuration.php
require('dataconnection/configuration.php');

// Initialize variables to store user input
$email = $password = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Retrieve user data from the database based on the email
    $sql = "SELECT * FROM users WHERE Email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify the password
    if ($user && password_verify($password, $user['Password'])) {
        // Store user data in the session
        $_SESSION['user'] = $user;
        
        // Redirect to a dashboard or home page
        header('Location: user_dashboard.php'); // Change this to your desired location
        exit();
    } else {
        $loginError = "Invalid email or password.";
    }
}

// Check if the user has chosen to continue as a guest
if (isset($_GET['continue_as_guest'])) {
    // Redirect to the index.php page
    header('Location: user_dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- title of the page -->
    <title>User Login</title>
    <style>
        /* Reset default margin and padding */
        body, h1, h2, p, form {
            margin: 0;
            padding: 0;
        }

        /* Set a background color */
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        /* Header styling */
        header {
            background-color: #222;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        header h1{
           font-weight: 600;
           font-size: 40px;
        }

        /* Banner styling */
        img {
            width: 100%;
            height: auto;
        }

        /* Form container */
        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Form label and input styling */
        label, input {
            display: block;
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Button styling */
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #005d96;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #5aa0c2;
        }

        /* Link styling */
        a {
            color: #222;
            text-decoration: none;
        }

        /* Centering the form and links */
        .text-center {
            text-align: center;
        }

        /* Error message styling */
        .error {
            color: red;
            margin-top: 10px;
        }

        .highlighted-link {
            color: red; /* Change the color to your preferred highlight color */
            font-weight: bold;
        }

        /* Center the h2 heading */
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Footer styling */
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px 0;
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>
<header>
    <!-- Website logo -->
    <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
</header>

<!-- Banner image -->
<img src="banners/1.jpg" alt="Banner" />

<?php if (isset($loginError)) { ?>
    <!-- Display an error message if the $loginError variable is set -->
    <p class="error"><?php echo $loginError; ?></p>
<?php } ?>

<!-- User login form -->
<form method="POST">
    <h2>User Login</h2>
    <!-- Email input -->
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <!-- Password input -->
    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <!-- Submit button to initiate the login process -->
    <button type="submit">LOG IN</button>
</form>

<!-- Link to the registration page for users who don't have an account -->
<p class="text-center">Don't have an account? <a href="register.php" class="highlighted-link">Register</a></p>

<!-- Link to continue as a guest -->
<p class="text-center">Or, <a href="?continue_as_guest">Continue as Guest</a></p>

<!-- Footer section -->
<footer>
    &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
</footer>
</body>
</html>