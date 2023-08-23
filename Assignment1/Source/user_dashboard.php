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
?>
<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		<link rel="stylesheet" href="ibuy.css" />
	</head>
    <style>
/* Basic styles for dropdown menu */
.dropdown {
    position: relative; /* Position context for dropdown */
    display: inline-block; /* Display as inline element */
}

.dropdown-content {
    display: none; /* Initially hide dropdown content */
    position: absolute; /* Position dropdown content absolutely */
    background-color: #f9f9f9; /* Background color for dropdown */
    max-width: 250px; /* Adjust the maximum width of dropdown */
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); /* Box shadow for dropdown */
    z-index: 1; /* Ensure dropdown appears above other content */
}

.dropdown:hover .dropdown-content {
    display: block; /* Display dropdown content on hover */
}

/* Styling for form inputs and submit button in header */
header form input[type=submit] {
    background-color: #005d96; /* Background color for submit button */
    color: white; /* Text color for submit button */
    width: 20%; /* Width of submit button */
    font-size: 2em; /* Font size of submit button text */
    padding: 0.5em; /* Padding around submit button text */
    cursor: pointer; /* Display cursor as pointer */
    border: 0; /* Remove border from submit button */
}
header form input[type="text"] {
    border: 2px solid black; /* Border for text input */
    font-size: 2em; /* Font size of text input */
    padding: 0.45em; /* Padding around text input */
    width: 70%; /* Width of text input */
}

/* Additional styling for dropdown menu items */
.dropdown-content li {
    padding: 8px; /* Padding for dropdown items */
}

.remaining-time {
    font-size: 0.9em; /* Font size for remaining-time element */
    color: red; /* Color for remaining time text */
}
</style>

<body>
    <!-- Header section -->
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <!-- Search form -->
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

    <img src="banners/1.jpg" alt="Banner" />

    <main>
        <h1>Latest Listings </h1>

        <ul class="productList">
        <ul class="productList">
            <?php
            // Fetch the most recent 10 auctions
            $sql = "SELECT * FROM auctions ORDER BY auctionDate DESC LIMIT 10";
            $stmt = $pdo->query($sql);

            $currentTimestamp = time(); // Get the current timestamp

            while ($auction = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<li>';
                echo '<img src="product.png" alt="' . $auction['auction_name'] . '">';
                echo '<article>';
                echo '<h2>' . $auction['auction_name'] . '</h2>';
                echo '<h3>' . getCategoryName($auction['categoryName'], $pdo) . '</h3>';

                // Shorten the description if it's too long
                $description = $auction['Description'];
                $maxDescriptionLength = 60; // Set your desired maximum description length
                if (strlen($description) > $maxDescriptionLength) {
                    $shortenedDescription = substr($description, 0, $maxDescriptionLength) . '...';
                    echo '<p>' . $shortenedDescription . '</p>';
                } else {
                    echo '<p>' . $description . '</p>';
                }

                // Use the getCurrentBidAmount function to display the current bid
                $currentBid = getCurrentBidAmount($auction['auction_name'], $pdo);
                echo '<p class="price">Current bid: £' . $currentBid . '</p>';

                // Calculate remaining time
                $auctionEndTime = strtotime($auction['auction_end_time']); // Convert end time to timestamp
                $remainingTime = $auctionEndTime - $currentTimestamp; // Calculate remaining time in seconds

                $days = floor($remainingTime / (60 * 60 * 24));
                $hours = floor(($remainingTime % (60 * 60 * 24)) / (60 * 60));
                $minutes = floor(($remainingTime % (60 * 60)) / 60);
                $seconds = $remainingTime % 60;

                echo '<p class="remaining-time">';
                echo 'Remaining Time: ' . $days . 'd ' . $hours . 'h ' . $minutes . 'm ' . $seconds . 's';
                echo '</p>';

                echo '<a href="auction_details.php?auction_name=' . $auction['auction_name'] . '" class="more auctionLink">More &gt;&gt;</a>';
                echo '</article>';
                echo '</li>';
            }
        

// Modify the getCurrentBidAmount function to handle the case when there are no bids yet
function getCurrentBidAmount($auctionName, $pdo) {
    $query = "SELECT MAX(bidAmount) AS currentBid FROM bids WHERE auction_name = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$auctionName]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['currentBid'] !== null) {
        return number_format($result['currentBid'], 2);
    } else {
        return 'No bids yet';
    }
}

// Modify the getCategoryName function to return the category name or a default value
function getCategoryName($categoryID, $pdo) {
    $query = "SELECT categoryName FROM categories WHERE categoryName = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$categoryID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        return $result['categoryName'];
    } else {
        return 'Unknown Category'; // Return a default value if category is not found
    }
}

            ?>
        </ul>
<!-- footer section -->
        <footer>
            &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
        </footer>
		</main>
        <!-- JavaScript to handle dropdown functionality -->
<!-- JavaScript to handle dropdown functionality -->
<script>
    const dropdown = document.querySelector('.dropdown');
    const dropdownContent = document.querySelector('.dropdown-content');

    // Show dropdown content on hover
    dropdown.addEventListener('mouseover', () => {
        dropdownContent.style.display = 'block';
    });

    // Hide dropdown content when mouse leaves the entire dropdown
    dropdown.addEventListener('mouseout', () => {
        dropdownContent.style.display = 'none';
    });

    // Prevent hiding when moving from link to dropdown content
    dropdownContent.addEventListener('mouseover', () => {
        dropdownContent.style.display = 'block';
    });

    // Hide dropdown content when mouse leaves the dropdown content
    dropdownContent.addEventListener('mouseout', () => {
        dropdownContent.style.display = 'none';
    });
</script>
	</body>
</html>
