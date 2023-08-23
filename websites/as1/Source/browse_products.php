<?php
// Start a session at the beginning of the file
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
    // Redirect users to the login page
    header('Location: login.php');
    exit();
}

// Include the database connection code
require('dataconnection/configuration.php');

// Get search term and category from the query string
$searchTerm = $_GET['search'] ?? '';
$categoryName = $_GET['category'] ?? '';

// SQL query to fetch products based on search term and category
$sql = "SELECT a.* FROM auctions AS a
        INNER JOIN categories AS c ON a.categoryName = c.categoryName
        WHERE (a.auction_name LIKE :searchTerm OR a.Description LIKE :searchTerm)
        AND (BINARY c.categoryName = :categoryName OR :categoryName = '')";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Browse Products</title>
        <!-- stylesheets and scripts -->
    <link rel="stylesheet" href="ibuy.css" />
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
</head>
<body>
<!-- Header section -->
<header>
    <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
    <!-- Search form in header -->
    <form action="browse_products.php" method="get">
        <input type="text" name="search" placeholder="Search for anything" />
        <input type="submit" name="submit" value="Search" />
    </form>
</header>

<!-- Navigation section -->
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
    <!-- Heading for search results -->
    <h1>Search Results</h1>

    <!-- List of products matching the search -->
    <ul class="productList">
        <?php foreach ($products as $product) { ?>
            <li>
                <!-- Display product details -->
                <img src="product.png" alt="<?php echo htmlspecialchars($product['auction_name']); ?>" />
                <article>
                    <h2><?php echo htmlspecialchars($product['auction_name']); ?></h2>
                    <h3><?php echo getCategoryName($product['categoryName'], $pdo); ?></h3>

                    <?php
                    // Shorten and display description
                    $description = $product['Description'];
                    $maxDescriptionLength = 60;
                    if (strlen($description) > $maxDescriptionLength) {
                        $shortenedDescription = substr($description, 0, $maxDescriptionLength) . '...';
                        echo '<p>' . htmlspecialchars($shortenedDescription) . '</p>';
                    } else {
                        echo '<p>' . htmlspecialchars($description) . '</p>';
                    }

                    // Display current bid amount
                    $currentBid = getCurrentBidAmount($product['auction_name'], $pdo);
                    echo '<p class="price">Current bid: £' . htmlspecialchars($currentBid) . '</p>';
                    ?>

                    <!-- Link to view more details about the auction -->
                    <a href="auction_details.php?auction_name=<?php echo urlencode($product['auction_name']); ?>" class="more auctionLink">More &gt;&gt;</a>
                </article>
            </li>
        <?php } ?>
    </ul>

<?php
// Function to fetch category name based on categoryName
function getCategoryName($categoryName, $pdo) {
     // SQL query to fetch category name
    $query = "SELECT categoryName FROM categories WHERE categoryName = :categoryName";
        // Prepare and execute the statement
    $stmt = $pdo->prepare($query);
    // Return the category name
    $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['categoryName'];
}

// Function to fetch the current bid amount for an auction
function getCurrentBidAmount($auctionName, $pdo) {
    // SQL query to fetch current bid amount
    $query = "SELECT MAX(bidAmount) AS currentBid FROM bids WHERE auction_name = :auctionName";
     // Prepare and execute the statement
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':auctionName', $auctionName, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['currentBid']) {
        return $result['currentBid'];
    } else {
        return 'No bids yet';
    }
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
