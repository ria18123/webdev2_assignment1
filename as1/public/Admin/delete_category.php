<?php
// Include the database configuration file to establish a connection
require('../dataconnection/configuration.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName'];

    // Delete the category from the categories table
    $sql = "DELETE FROM categories WHERE categoryName = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categoryName]);

    // Redirect back to admin panel
    header('Location: categories.php');
    exit();
}
?>


<!-- The body content goes here -->
<!DOCTYPE html>
<html>
<!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Delete category</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
    <!-- Add your additional CSS styles here if needed -->
    <style>
    /* Base styles for the header search form submit button */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }

    /* Base styles for the header search form text input */
    header form input[type="text"] {
        border: 2px solid black;
        font-size: 2em;
        padding: 0.45em;
        width: 70%;
    }
    
    /* Styles for the sidebar layout */
    .sidebar {
        align-items: center;
        padding: 0;
        margin-top: 2vw;
    }
    .sidebar .left {
        width: 20%;
        background-color: #555;
        padding: 10px;
        list-style-type: none;
    }
    .sidebar .right {
        flex: 1;
        padding: 20px;
    }
    
    /* Styles for the footer */
    footer {
        margin-top: 2vw;
    }

    /* Styles for general buttons */
    .button {
        display: inline-block;
        padding: 8px 25px;
        margin-right: 10px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        border: none;
        min-width: 120px;
        text-align: center;
        line-height: 20px;
    }
    
    /* Hover effect for buttons */
    .button:hover {
        background-color: #45a049;
    }

    /* Additional styles for specific buttons */
    .button {
        padding: 8px 15px;
        background-color: #005d96;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        border: none;
    }

    /* Hover effect for buttons */
    .button:hover {
        background-color: #5aa0c2;
    }

    /* Additional styles for alignment */
    .form-group {
        margin-bottom: 20px;
    }
    main form input[type="submit"] {
        background-color: #005d96;
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
    <!-- Header section -->
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <!-- Search form -->
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    
    <!-- Navigation section -->
    <nav>
        <ul>
            <li><a href="admin_panel.php">Admin Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
        </ul>
    </nav>
    
    <!-- Banner image -->
    <img src="/banners/2.jpg" alt="Banner" />
    
    <!-- Main content section with sidebar layout -->
    <main class="sidebar">
        <!-- Left sidebar section with links -->
        <section class="left">
            <ul>
                <li><a href="addauction.php">Add Auction</a></li>
                <li><a href="editauction.php">Edit Auction</a></li>
                <li><a href="deleteauction.php">Delete Auction</a></li>
            </ul>
        </section>
        
        <!-- Right content section -->
        <section class="right">
            <h2>Add Category</h2>
            <!-- Form to delete a category -->
            <form method="POST">
                <label for="categoryName">Select Category to Delete:</label>
                <select name="categoryName">
                    <?php
                    // Fetch categories from the database and create options
                    $sql = "SELECT * FROM categories";
                    $stmt = $pdo->query($sql);
                    $categories = $stmt->fetchAll();
                    foreach ($categories as $category) {
                        echo '<option value="' . $category['categoryName'] . '">' . $category['categoryName'] . '</option>';
                    }
                    ?>
                </select><br>
                <!-- submit button -->
                <input type="submit" value="Delete Category" class="button" />
            </form>
        </section>
    </main>
    
    <!-- Footer section -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>
