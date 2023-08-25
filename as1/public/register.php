<?php
// Include the database connection code from configuration.php
require('dataconnection/configuration.php'); //for creating the connection to the database 

// Initialize variables to store user input
$firstName = $lastName = $dob = $email = $password = '';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store form inputs
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert user data into the database
    $sql = "INSERT INTO users (FirstName, LastName, DOB, Email, Password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $dob, $email, $password]);

    // Redirect to the login page
    header('Location: index.php'); // Correct the path if needed
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <style>
        /* Reset some default styles */
        body, h1, h2, h3, p, ul, li, form {
            margin: 0;
            padding: 0;
        }

        /* Apply some basic styles to the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Center content horizontally and vertically */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
             min-height: 79vh; 
        }

        /* Form styles */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center; /* Center the form content horizontally */
            margin: 0 auto; /* Center the form within the container */
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"],
        form input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #005d96;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #5aa0c2;
        }

        /* Center the form within the container */
        .form-container {
            text-align: center;
            padding: 20px;
        }

        /* Footer style */
        footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px 0;
            background-color: #333;
            color: #fff;
        }

        /* Header style */
        header {
            text-align: center;
            padding: 20px;
            background-color: #222;
            color: #fff;
        }

        /* Image style */
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Error message style */
        .error {
            color: #ff0000;
            margin-bottom: 10px;
        }

        /* Center the h2 heading */
        h2 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        header h1{
           font-weight: 600;
           font-size: 40px;
        }
    </style>
</head>
<body>
<!-- Header section with logo --> 
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
    </header>

    <!-- Main content container for registration form -->
    <div class="container">
        <form method="POST">
            <h2>User Registration</h2>
            <!-- Input fields for user information -->
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" required><br>

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" required><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <!-- Button to submit the registration form -->
            <button type="submit">Register</button>
        </form>
    </div>

    <!-- Footer section displaying the current year -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>