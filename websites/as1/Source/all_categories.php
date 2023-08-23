<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
    // Redirect users to the login page
    header('Location: login.php');
    exit();
}

require('dataconnection/configuration.php'); // Including the database connection code
?>

<!DOCTYPE html>
<html>
<head>
    <!-- tile of the page -->
    <title>ibuy Auctions</title>
    <!-- stylesheet -->
    <link rel="stylesheet" href="ibuy.css" />
    <style>
        /* Basic styles for dropdown menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            max-width: 250px; /* Adjust the width as needed */
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        /* Rest of your existing CSS styles */

        .dropdown:hover .dropdown-content {
            display: block;
        }

        header form input[type=submit] {
            background-color: #005d96;
            color: white;
            width: 20%;
            font-size: 2em;
            padding: 0.5em;
            cursor: pointer;
            border: 0;
        }

        header form input[type="text"] {
            border: 2px solid black;
            font-size: 2em;
            padding: 0.45em;
            width: 70%;
        }

        /* Additional styling for dropdown menu */
        .dropdown-content li {
            padding: 8px;
        }

        /* Organize main section styles */
        main {
            padding: 20px;
        }

        .categoryList {
            list-style: none;
            padding: 0;
            text-align: center; /* Center the categories */
        }

        h1 {
            list-style: none;
            padding: 0;
            text-align: center; /* Center the categories */
        }

        .categoryList li {
            margin-bottom: 10px;
        }

        .categoryList li a {
            text-decoration: none;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <header>
        <!-- Header content -->
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        
        <!-- Search form -->
        <form action="browse_products.php" method="get">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    <nav>
        <ul>
            <!-- Dropdown for categories -->
            <li><a class="categoryLink" href="user_dashboard.php">Home</a></li>
            <li class="dropdown">
                <a href="#" class="categoryLink">Categories</a>
                <ul class="dropdown-content">
                    <?php
                    // Fetch categories from the database
                    $categoriesQuery = "SELECT categoryName FROM categories";
                    $categoriesResult = $pdo->query($categoriesQuery);
                    $categoriesCount = 0; // Initialize a counter

                    // Loop through the categories and generate dropdown items
                    while ($category = $categoriesResult->fetch(PDO::FETCH_ASSOC)) {
                        // Show only a certain number of categories
                        if ($categoriesCount < 5) {
                            echo '<li><a href="category_auctions.php?category=' . $category['categoryName'] . '">' . $category['categoryName'] . '</a></li>';
                            $categoriesCount++;
                        } else {
                            break; // Stop looping after a certain number of categories
                        }
                    }

                    // Add a "More" option that redirects to a separate page with all categories
                    echo '<li><a href="all_categories.php">More</a></li>';
                    ?>
                </ul>
            </li>

            <!-- Other navigation links -->
            <li><a class="categoryLink" href="user_auctions.php">Your Auctions</a></li>
            <li><a class="categoryLink" href="post_auction.php">Post Auction</a></li>
            <li><a class="categoryLink" href="\Admin\adminlogin.php">Admin</a></li>
            <li><a class="categoryLink" href="logout.php">Logout</a></li>
        </ul>
    </nav>
<!-- link to the banner image -->
    <img src="banners/1.jpg" alt="Banner" />

    <main>
        <!-- title  -->
        <h1>All Categories</h1>
        <ul class="categoryList">
            <?php
            // Fetch all categories from the database
            $categoriesQuery = "SELECT categoryName FROM categories";
            $categoriesResult = $pdo->query($categoriesQuery);

            // Loop through the categories and generate list items with links
            while ($category = $categoriesResult->fetch(PDO::FETCH_ASSOC)) {
                echo '<li><a href="category_auctions.php?category=' . $category['categoryName'] . '">' . $category['categoryName'] . '</a></li>';
            }
            ?>
        </ul>
        <!-- footer -->
        <footer>
            &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
        </footer>
    </main>
</body>
</html>
