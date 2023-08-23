<?php
// Start a session at the beginning of the file
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
    // Redirect users to the login page
    header('Location: login.php');
    exit();
}

require('dataconnection/configuration.php'); // Connecting to the database

// Retrieve the category name from the URL parameter
$categoryName = $_GET['category'];

// Fetch auctions of the selected category
$sql = "SELECT * FROM auctions WHERE categoryName = :categoryName ORDER BY auctionDate DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
$stmt->execute();
$auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		<link rel="stylesheet" href="ibuy.css" />
	</head>
    <style>
    /* Basic styles for dropdown menu */
    /* Styles for the dropdown container */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Styles for the dropdown content */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        max-width: 250px; /* Adjust the width as needed */
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Display dropdown content on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Styles for submit button in header form */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }

    /* Styles for text input in header form */
    header form input[type="text"] {
        border: 2px solid black;
        font-size: 2em;
        padding: 0.45em;
        width: 70%;
    }

    /* Additional styling for dropdown menu items */
    .dropdown-content li {
        padding: 8px;
    }
</style>

	<body>
		<header>
			<h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>

            <form action="browse_products.php" method="get"> <!-- Change the action URL to your browse_products.php script -->
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
<!-- Banner image -->
    <img src="banners/1.jpg" alt="Banner" />
   
<!-- Main content section -->
<main>
    <!-- Heading with the dynamically set category name -->
    <h1><?php echo $categoryName; ?> Auctions</h1>

    <!-- List of product/auction items -->
    <ul class="productList">
        <?php
        // Loop through each auction and display its details
        foreach ($auctions as $auction) {
            echo '<li>';
            // Display product image
            echo '<img src="product.png" alt="' . $auction['auction_name'] . '">';
            echo '<article>';
            // Display auction name and associated category
            echo '<h2>' . $auction['auction_name'] . '</h2>';
            echo '<h3>' . getCategoryName($auction['categoryName'], $pdo) . '</h3>';

            // Shorten the description if it's too long
            $description = $auction['Description'];
            $maxDescriptionLength = 60; // Set desired maximum description length
            if (strlen($description) > $maxDescriptionLength) {
                $shortenedDescription = substr($description, 0, $maxDescriptionLength) . '...';
                echo '<p>' . $shortenedDescription . '</p>';
            } else {
                echo '<p>' . $description . '</p>';
            }

            // Use the getCurrentBidAmount function to display the current bid
            $currentBid = getCurrentBidAmount($auction['auction_name'], $pdo);
            echo '<p class="price">Current bid: £' . $currentBid . '</p>';

            // Link to view more details about the auction
            echo '<a href="auction_details.php?auction_name=' . $auction['auction_name'] . '" class="more auctionLink">More &gt;&gt;</a>';
            echo '</article>';
            echo '</li>';
        }

        // Function to fetch category name based on categoryID
        function getCategoryName($categoryID, $pdo) {
            // SQL query to retrieve category name
            // Prepare and execute the statement
            // Return the category name
        }

        // Function to fetch the current bid amount for an auction
        function getCurrentBidAmount($auctionName, $pdo) {
            // SQL query to retrieve current bid amount
            // Prepare and execute the statement
            // Return the current bid amount or "No bids yet"
        }
        ?>
    </ul>

    <!-- Footer section -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</main>
</body>
</html>
