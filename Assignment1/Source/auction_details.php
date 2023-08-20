<?php
require('dataconnection/configuration.php'); // Connecting to the database

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $reviewText = $_POST["reviewtext"];
    $firstName = "User"; // You can get this from the logged-in user if applicable
    $lastName = "Name"; // You can get this from the logged-in user if applicable
    $auctionName = $_GET['auction_name'];
    $email = "user@example.com"; // You can get this from the logged-in user if applicable

    // Insert review into the database
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
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
<body>
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>

        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>

    <nav>
        <ul>
            <!-- Dropdown for categories -->
            <li class="dropdown">
                <a href="#" class="categoryLink">Categories</a>
                <ul class="dropdown-content">
                    <?php
                    // Fetch categories from the database
                    $categoriesQuery = "SELECT categoryName FROM categories";
                    $categoriesResult = $pdo->query($categoriesQuery);

                    // Loop through the categories and generate dropdown items
                    while ($category = $categoriesResult->fetch(PDO::FETCH_ASSOC)) {
                        echo '<li><a href="#">' . $category['categoryName'] . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <!-- Other navigation links -->
            <li><a class="categoryLink" href="index.php">Home</a></li>
            <li><a class="categoryLink" href="#">Latest listings</a></li>
            <li><a class="categoryLink" href="#">Search Results</a></li>
            <li><a class="categoryLink" href="register.php">Register</a></li>
            <li><a class="categoryLink" href="category.php">Category listings</a></li>
            <li><a class="categoryLink" href="Auction.php">Auction</a></li>
            <li><a class="categoryLink" href="login.php">Login</a></li>
        </ul>
    </nav>

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
                    echo '<h3>' . getCategoryName($auction['categoryID'], $pdo) . '</h3>';

                    // Use the getCurrentBidAmount function to display the current bid
                    $currentBid = getCurrentBidAmount($auction['auction_name'], $pdo);
                    echo '<p class="price">Current bid: £' . htmlspecialchars($currentBid) . '</p>';

                    echo '</section>';
                    echo '<section class="description">';
                    echo '<p>' . htmlspecialchars($auction['Description']) . '</p>';
                    echo '</section>';
                    echo '</article>';

                    // Display bid form
                    echo '<form action="submit_bid.php" class="bid">';
                    echo '<input type="text" name="bid" placeholder="Enter bid amount" />';
                    echo '<input type="submit" value="Place bid" />';
                    echo '</form>';

                    echo '<section class="reviews">';
                    echo '<h2>Reviews of ' . htmlspecialchars($auction['auction_name']) . '</h2>';
                    echo '<ul>';
    
                    // Fetch and display reviews
                    $reviewsQuery = "SELECT * FROM reviews WHERE auction_name = ? ORDER BY review_Date ASC";
                    $reviewsStmt = $pdo->prepare($reviewsQuery);
                    $reviewsStmt->execute([$auction_name]);
    
                    while ($review = $reviewsStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<li>';
                        echo '<strong>' . htmlspecialchars($review['firstName'] . ' ' . $review['LastName']) . ' said:</strong><br>';
                        echo htmlspecialchars($review['review_Content']) . '<br>';
                        echo '<em>' . htmlspecialchars($review['review_Date']) . '</em>';
                        echo '</li>';
                    }
    
                    echo '</ul>';
    
                    // Review form here...
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
        // Function to fetch category name based on categoryID
        function getCategoryName($categoryID, $pdo) {
            $query = "SELECT categoryName FROM categories WHERE categoryName = :categoryID";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':categoryID', $categoryID, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['categoryName'];
        }

        // Function to fetch the current bid amount for an auction
        function getCurrentBidAmount($auctionName, $pdo) {
            $query = "SELECT MAX(bidAmount) AS currentBid FROM bids WHERE auction_name = :auctionName";
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
    </main>

    <footer>
        <!-- Your footer content here -->
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>
