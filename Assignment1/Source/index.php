<?php
session_start();
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
            <li><a class="categoryLink" href="/Admin/adminlogin.php">Admin</a></li>
            <li><a class="categoryLink" href="category.php">Category listings</a></li>
            <li><a class="categoryLink" href="Auction.php">Auction</a></li>
            <li><a class="categoryLink" href="login.php">Login</a></li>
        </ul>
    </nav>

    <img src="banners/1.jpg" alt="Banner" />

    <main>
        <h1>Latest Listings / Search Results / Category listing</h1>

        <ul class="productList">

        <ul class="productList">
        <?php
        // Fetch the most recent 10 auctions
        $sql = "SELECT * FROM auctions ORDER BY auctionDate DESC LIMIT 10";
        $stmt = $pdo->query($sql);

        while ($auction = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<li>';
            echo '<img src="product.png" alt="' . $auction['auction_name'] . '">';
            echo '<article>';
            echo '<h2>' . $auction['auction_name'] . '</h2>';
            echo '<h3>' . getCategoryName($auction['categoryID'], $pdo) . '</h3>';
            echo '<p>' . $auction['Description'] . '</p>';

            // Use the getCurrentBidAmount function to display the current bid
            $currentBid = getCurrentBidAmount($auction['auction_name'], $pdo);
            echo '<p class="price">Current bid: £' . $currentBid . '</p>';

            echo '<a href="auction_details.php?auction_name=' . $auction['auction_name'] . '" class="more auctionLink">More &gt;&gt;</a>';
            echo '</article>';
            echo '</li>';
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
        </ul>
        <hr />
		
        <hr />
					<h1>Sample Form</h1>

					<form action="#">
						<label>Text box</label> <input type="text" />
						<label>Another Text box</label> <input type="text" />
						<input type="checkbox" /> <label>Checkbox</label>
						<input type="radio" /> <label>Radio</label>
						<input type="submit" value="Submit" />

					</form>

        <footer>
            &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
        </footer>
		</main>
	</body>
</html>
