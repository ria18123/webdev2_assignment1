<?php
require('../dataconnection/configuration.php'); // Including the database configuration file to establish a connection.

$message = ''; // Initialize a variable to store status messages.

// Check if the request method is POST (form submission).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName']; // Get the submitted category name from the form.

    // SQL query to check if the category name already exists in the database.
    $sqlCheck = "SELECT COUNT(*) FROM categories WHERE categoryName = ?";
    $stmtCheck = $pdo->prepare($sqlCheck); // Prepare the query.
    $stmtCheck->execute([$categoryName]); // Execute the query with the category name as parameter.
    $categoryCount = $stmtCheck->fetchColumn(); // Fetch the count result.

    // Check if the category name already exists.
    if ($categoryCount > 0) {
        $message = 'Category already exists'; // Set a message indicating that the category already exists.
    } else {
        // SQL query to insert the new category name into the database.
        $sqlInsert = "INSERT INTO categories (categoryName) VALUES (?)";
        $stmtInsert = $pdo->prepare($sqlInsert); // Prepare the query.
        $stmtInsert->execute([$categoryName]); // Execute the query with the category name as parameter.

        $message = 'Category added successfully'; // Set a message indicating successful category addition.
    }
}
?>

<!-- The body content goes here -->
<!DOCTYPE html>
<html>
     <!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Add Category</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
  <!-- Adding the additional CSS for this page only -->
  <style>
    /* CSS styles for the header form */
    /* Button styling */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }
    /* Text input styling */
    header form input[type="text"] {
        border: 2px solid black;
        font-size: 2em;
        padding: 0.45em;
        width: 70%;
    }

    /* Style for the sidebar */
    .sidebar {
        align-items: center;
        padding: 0;
        margin-top: 2vw;
    }
    /* Left sidebar styling */
    .sidebar .left {
        width: 20%;
        background-color: #555;
        padding: 10px;
        list-style-type: none;
    }
    /* Right content section styling */
    .sidebar .right {
        flex: 1;
        padding: 20px;
    }
    /* Styling for footer */
    footer {
        margin-top: 2vw;
    }

    /* Adjusted styles for buttons */
    .button {
        display: inline-block;
        padding: 8px 25px; /* Adjust padding for the buttons */
        margin-right: 10px; /* Add margin between buttons */
        background-color: #005d96;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        border: none;
        min-width: 120px; /* Set the minimum width for the buttons */
        text-align: center;
        line-height: 20px; /* Center text vertically */
    }
    /* Additional button style */
    main form input[type="submit"] {
        color: white;
        flex-grow: 0;
        margin-left: auto;
        font-size: 1.2em;
        padding: 0.2em;
        cursor: pointer;
        border: 0;
        height: 47px;
        margin-top: 23px;
        margin-right: 455px;
        background-color: #005d96;
    }

    /* Hover effect for buttons */
    .button:hover {
        background-color: #5aa0c2;
    }
    /* Additional styles for alignment */
    .form-group {
        margin-bottom: 20px;
    }
    main form input {
        flex-grow: 1;
        width: 20vw;
        margin-bottom: 1em;
        margin-right: 2vw;
        margin-left: 2vw;
        height: 30px;
    }
    main {
        min-height: 50vh;
        background-color: #fff;
        width: 70vw;
        display: block;
        margin: auto;
        box-shadow: 0px 0px 10px #888;
        color: #444;
    }
    main h2 {
        font-size: 2em;
    }
    footer {
        background-color: #fff;
        padding: 10px;
        color: #000;
    }
    .left ul {
        list-style-type: none;
    }
    section a {
        color: #444;
    }
    p,
    li,
    h2 {
        margin-bottom: 1em;
        margin-left: 14px;
    }
    .stock,
    .sidebar {
        display: table;
    }
    .stock > ul,
    .sidebar .left {
        width: 10vw;
        list-style-type: none;
        display: table-cell;
        padding: 10px;
        background-color: #555;
        margin: 0;
    }
    .stock .products,
    .sidebar .right {
        display: table-cell;
        padding: 20px;
    }
    .stock > ul a,
    .sidebar .left a {
        color: white;
        text-decoration: none;
    }
    a:hover {
        color: lightgray !important;
    }
    .right {
        padding: 20px;
    }
    main h1 {
        color: #666;
    }
</style>


</head>
<body>
    <!-- Header section with the website logo and search form -->
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    <!-- Navigation section with links to different pages -->
    <nav>
        <ul>
            <li><a href="admin_panel.php">Admin Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
        </ul>
    </nav>
    <!-- Banner image -->
    <img src="/banners/2.jpg" alt="Banner" />

    <!-- Main content section with sidebar -->
    <main class="sidebar">
        <!-- Left sidebar section with navigation links -->
        <section class="left">
            <!-- Sidebar navigation links -->
            <ul>
            <li><a href="categories.php">Categories</a></li>
            </ul>
        </section>
        <!-- Right sidebar section for adding categories -->
        <section class="right">
            <h2>Add Category</h2>
            <?php if (!empty($message)) : ?>
                <div class="message"><?= $message ?></div>
            <?php endif; ?>
            <!-- Form for adding a new category -->
            <form action="add_category.php" method="POST">
                <div class="form-group">
                    <label for="categoryName">Category Name:</label>
                    <input type="text" name="categoryName" required><br>
                </div>
                <!-- Submit button for adding the category -->
                <input type="submit" value="Add Category" class="button" />
            </form>
        </section>
    </main>

    <!-- Footer section with copyright information -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
