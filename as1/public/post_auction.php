<?php
// Start a session at the beginning of the file
session_start(); // Start the session

require('dataconnection/configuration.php'); // Connecting to the database

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page if user is not logged in
    header('Location: login.php'); // Change this to your login page
    exit();
}
?>
<!-- post_auction.php -->
<!DOCTYPE html>
<html>
	<head>
        <!-- The title of the page and link of the css -->
		<title>post auction-ibuy Auctions</title>
		<link rel="stylesheet" href="ibuy.css" />
	</head>
    <style>
    /* Basic styles for dropdown menu */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Styling for the dropdown content */
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

    /* Styling for submit button in the header form */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }

    /* Styling for text input in the header form */
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

    /* Styling for the auction submission form */
    .auction-form {
        width: 60%;
        margin: auto;
        padding: 20px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    /* Styling for labels in the auction submission form */
    .auction-form label {
        display: block;
        font-size: 1.2em;
        margin-top: 10px;
    }

    /* Styling for various input elements in the auction submission form */
    .auction-form input[type="text"],
    .auction-form input[type="date"],
    .auction-form select,
    .auction-form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Styling for the submit button in the auction submission form */
    .auction-form button[type="submit"] {
        background-color: #3665f3;
        color: white;
        font-size: 1.2em;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
    }

    /* Styling for datetime-local input in the auction submission form */
    .auction-form input[type="datetime-local"] {
        height: 35px;
    }
</style>

	<body>
        <!-- Header section with logo --> 
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
    <!-- link to the banner image -->
    <img src="banners/1.jpg" alt="Banner" />
    <main>
        <h2>Post Auction</h2>
        <form method="POST" action="process_post_auction.php" class="auction-form">
        <label for="auction_name">Auction Name:</label>
        <input type="text" name="auction_name" required>

        <label for="auctioneer">Auctioneer:</label>
        <!-- Display the logged-in user's name (auctioneer) -->
        <input type="text" name="auctioneer" value="<?php echo $_SESSION['user']['FirstName'] . ' ' . $_SESSION['user']['LastName']; ?>" required readonly>

        <label for="auctionDate">Auction Date:</label>
        <input type="date" name="auctionDate" required>

        <label for="auction_end_time">Auction End Time:</label>
        <input type="datetime-local" name="auction_end_time" required>

        <label for="categoryName">Category:</label>
        <select name="categoryName" required>
            <?php
            // Fetch categories from the database and populate the dropdown
            $sql = "SELECT * FROM categories";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll();

            foreach ($categories as $category) {
                echo "<option value='{$category['categoryName']}'>{$category['categoryName']}</option>";
            }
            ?>
        </select>

        <!-- description of the auction -->
        <label for="Description">Description:</label>
        <textarea name="Description" rows="4" cols="50" required></textarea>
<!-- submit button -->
        <button type="submit">Post Auction</button>
    </form>
    <!-- footer section -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
    </main>
</body>
</html>