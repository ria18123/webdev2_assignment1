<?php
// Start a session at the beginning of the file
session_start();

require('dataconnection/configuration.php'); // Including the database connection code

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Get the review text from the form
    $reviewText = $_POST["reviewtext"];

    // Retrieve user information from the session
    $firstName = $_SESSION['user']['FirstName'];
    $lastName = $_SESSION['user']['LastName'];

    // Get the auction name and email from the query string and session
    $auctionName = $_GET['auction_name'];
    $email = $_SESSION['user']['Email'];

    // Insert the review into the database
    $insertReviewQuery = "INSERT INTO reviews (firstName, LastName, review_Date, review_Content, auction_name, authorised, email) VALUES (?, ?, NOW(), ?, ?, 'Y', ?)";
    $insertReviewStmt = $pdo->prepare($insertReviewQuery);
    $insertReviewStmt->execute([$firstName, $lastName, $reviewText, $auctionName, $email]);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ibuy Auctions</title>
    <link rel="stylesheet" href="ibuy.css" />
</head>
<!-- Adding CSS styles here -->
    <style>
/* Basic styles for dropdown menu */
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
    <!-- navigation bar start  -->
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
    <?php
        try {
            // Check if auction_name parameter is set
            if (isset($_GET['auction_name'])) {
                $auction_name = $_GET['auction_name'];
                $sql = "SELECT * FROM auctions WHERE auction_name = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$auction_name]);
                $auction = $stmt->fetch();

                if ($auction) {
                    echo '<article class="product">';
                    echo '<img src="product.png" alt="' . $auction['auction_name'] . '">';
                    echo '<section class="details">';
                    echo '<h2>' . htmlspecialchars($auction['auction_name']) . '</h2>';
                    echo '<h3>' . getCategoryName($auction['categoryName'], $pdo) . '</h3>';

                    // Use the getCurrentBidAmount function to display the current bid
                    $currentBid = getCurrentBidAmount($auction['auction_name'], $pdo);
                    echo '<p class="price">Current bid: £' . htmlspecialchars($currentBid) . '</p>';

                    echo '</section>';
                    echo '<section class="description">';
                    echo '<p>' . htmlspecialchars($auction['Description']) . '</p>';
                    echo '</section>';
                    echo '</article>';

                // Display bid form
                echo '<form action="submit_bid.php" method="POST" class="bid">';
                echo '<input type="hidden" name="auction_name" value="' . $auction['auction_name'] . '">';
                echo '<input type="text" name="bid" placeholder="Enter bid amount" />';
                echo '<input type="submit" name="submit" value="Place bid" />';
                echo '</form>';

	

// Display reviews and review form
echo '<section class="reviews">';
echo '<h2>Reviews of User.Name</h2>';
echo '<ul>';
// Fetch and display reviews in ascending order
$reviewsQuery = "SELECT * FROM reviews WHERE auction_name = ? ORDER BY review_Date ASC";
$reviewsStmt = $pdo->prepare($reviewsQuery);
$reviewsStmt->execute([$auction_name]);

while ($review = $reviewsStmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<li>';
    echo '<strong>' . htmlspecialchars($review['firstName'] . ' ' . $review['LastName']) . ' said </strong>';
    echo htmlspecialchars($review['review_Content']) . ' <em>' . htmlspecialchars($review['review_Date']) . '</em>';
    echo '</li>';
}

echo '</ul>';

               // Review form here
                echo '<form method="POST">';
                echo '<label>Add your review</label> <textarea name="reviewtext"></textarea>';
                echo '<input type="submit" name="submit" value="Add Review" />';
                echo '</form>';
                echo '</section>';
                }
            }
        } catch (PDOException $e) {
            // Handle database errors gracefully
            echo "Error: " . $e->getMessage();
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
        ?>
            <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
    </main>
</body>
</html>
