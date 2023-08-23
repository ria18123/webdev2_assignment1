<?php
// Start the session
session_start();

// Include the database connection code from configuration.php
require('dataconnection/configuration.php');

// Include the necessary functions
// ... Include getCategoryName and getCurrentBidAmount functions here ...

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php'); // Change this to your login page
    exit();
}

// Check if the auction name parameter is passed through the URL
if (!isset($_GET['auction_name'])) {
    // Redirect back to user_auctions.php if auction name is not provided
    header('Location: user_auctions.php');
    exit();
}

// Get the auction name from the URL parameter
$auction_name = $_GET['auction_name'];

// Fetch auction details from the database using the auction name
$auction_query = "SELECT * FROM auctions WHERE auction_name = ?";
$auction_stmt = $pdo->prepare($auction_query);
$auction_stmt->execute([$auction_name]);
$auction = $auction_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch categories from the database for the dropdown
$categories_query = "SELECT categoryName FROM categories";
$categories_result = $pdo->query($categories_query);
$categories = $categories_result->fetchAll(PDO::FETCH_COLUMN);
?>


<!-- The body content goes here -->
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

    /* Additional styling for form elements */
    .form-box {
        text-align: center;
        width: 60%;
        margin: 0 auto;
    }

    .form-box label {
        display: block;
        margin-top: 1em;
    }

    /* Styles for input fields and textareas in the form */
    .form-box input[type="text"],
    .form-box select,
    .form-box textarea {
        width: 100%;
        padding: 0.5em;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* Styles for heading within form box */
    .form-box h1 {
        margin-top: 0;
        margin-bottom: 5vw;
    }

    /* Styles for input elements in main form */
    main form label,
    main form input {
        flex-grow: 1;
        width: 25vw;
        margin-bottom: 1em;
        margin-right: 2vw;
        margin-left: 2vw;
        height: 30px;
    }

    /* Styles for submit button within form box */
    .form-box input[type="submit"] {
        background-color: #005d96;
        color: white;
        font-size: 1em;
        padding: 0.5em 1em;
        border: none;
        cursor: pointer;
        margin-top: 50px;
        align-items: center;
        justify-items: center;
        justify-content: center;
        margin-right: 175px;
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
    <div class="form-box">
        <!-- Heading for the edit auction form -->
        <h1>Edit Auction</h1>

        <!-- Form for updating auction details -->
        <form action="update_auction.php" method="post">
            <!-- Hidden input for the auction name (used for identification) -->
            <input type="hidden" name="auction_name" value="<?php echo htmlspecialchars($auction['auction_name']); ?>" />

            <!-- Input field for editing the auction name -->
            <label for="new_auction_name">Auction Name:</label>
            <input type="text" name="new_auction_name" value="<?php echo htmlspecialchars($auction['auction_name']); ?>" />

            <!-- Dropdown for selecting a new category -->
            <label for="new_category">Category:</label>
            <select name="new_category">
                <?php foreach ($categories as $category) {
                    $selected = ($category === $auction['categoryName']) ? 'selected' : '';
                    echo '<option value="' . $category . '" ' . $selected . '>' . $category . '</option>';
                } ?>
            </select>

            <!-- Input field for editing the auction date and time -->
            <label for="new_auctionDate">Auction Date:</label>
            <input type="datetime-local" name="new_auctionDate" value="<?php echo date('Y-m-d\TH:i', strtotime($auction['auctionDate'])); ?>" />

            <!-- Input field for editing the auction end time -->
            <label for="new_auction_end_time">Auction End Time:</label>
            <input type="datetime-local" name="new_auction_end_time" value="<?php echo date('Y-m-d\TH:i', strtotime($auction['auction_end_time'])); ?>" />

            <!-- Textarea for editing the auction description -->
            <label for="new_description">Description:</label>
            <textarea name="new_description"><?php echo htmlspecialchars($auction['Description']); ?></textarea>

            <!-- Submit button to save changes -->
            <input type="submit" value="Save Changes" />
        </form>
    </div>

    <!-- Footer section -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</main>
</body>
</html>
