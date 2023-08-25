<?php
require('../dataconnection/configuration.php'); // Include the database configuration file to establish a connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['auction_name'])) {
        $auctionName = $_POST['auction_name'];
        $newName = $_POST['new_name'];
        $newCategory = $_POST['new_category'];
        $newDescription = $_POST['new_description'];
        $newAuctionDate = $_POST['new_auctionDate']; // New auctionDate value
        $newAuctionEndTime = $_POST['new_auction_end_time']; // New auction_end_time value

        // Delete associated bids
        $deleteBidsStmt = $pdo->prepare('DELETE FROM bids WHERE auction_name = :auctionName');
        $deleteBidsStmt->execute(['auctionName' => $auctionName]);

        // Update the auction's name, category, description, auctionDate, and auction_end_time
        $updateStmt = $pdo->prepare('UPDATE auctions SET auction_name = :newName, categoryName = :newCategory, Description = :newDescription, auctionDate = :newAuctionDate, auction_end_time = :newAuctionEndTime WHERE auction_name = :auctionName');
        $updateStmt->execute([
            'newName' => $newName,
            'newCategory' => $newCategory,
            'newDescription' => $newDescription,
            'newAuctionDate' => $newAuctionDate,
            'newAuctionEndTime' => $newAuctionEndTime,
            'auctionName' => $auctionName
        ]);

        // Display a success message
        echo '<div class="message">Auction details updated successfully</div>';
    }
}
?>


<!-- The body content goes here -->
<!DOCTYPE html>
<html>
<!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Edit Auctions</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
    <!-- Add your additional CSS styles here if needed -->
    <style>
    /* Add your additional CSS styles here if needed */

    /* Styling for search form submit button */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }

    /* Styling for search form text input */
    header form input[type="text"] {
        border: 2px solid black;
        font-size: 2em;
        padding: 0.45em;
        width: 70%;
    }

    /* Style for the sidebar */
    .sidebar {
        align-items: center;
        padding: 0;
        margin-top: 2vw;
    }

    /* Left sidebar styling */
    .sidebar .left {
        width: 20%;
        background-color: #555;
        padding: 10px;
        list-style-type: none;
    }

    /* Right content section styling */
    .sidebar .right {
        flex: 1;
        padding: 20px;
    }

    /* Styling for footer */
    footer {
        margin-top: 2vw;
    }

    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    /* Styling for table headers and cells */
    table th,
    table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    /* Styling for cells with descriptions */
    .description-cell {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Styling for cells with actions */
    .actions-cell {
        white-space: nowrap;
    }

    /* Button styles */
    .button {
        display: inline-block;
        padding: 8px 25px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        border: none;
    }

    /* Adjusted button styles */
    .button {
        display: inline-block;
        padding: 8px 25px; /* Adjust padding for the buttons */
        margin-right: 10px; /* Add margin between buttons */
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        border: none;
        min-width: 120px; /* Set the minimum width for the buttons */
        text-align: center;
        line-height: 20px; /* Center text vertically */
    }

    /* Hover effect for buttons */
    .button:hover {
        background-color: #45a049;
    }

    /* Additional styles for alignment */
    .form-label {
        display: block;
        margin-top: 10px;
    }

    .form-input {
        padding: 5px;
        margin-top: 5px;
        border: 2px solid black;
    }

    .form-textarea {
        width: 100%;
        padding: 5px;
        margin-top: 5px;
        border: 2px solid black;
    }

    .form-group {
        margin-bottom: 20px; /* Add desired spacing between the input boxes */
    }

    /* Styling for form submit button in main content */
    main form input[type="submit"] {
        background-color: #005d96;
        color: white;
        flex-grow: 0;
        margin-left: 31px;
        font-size: 1.2em;
        padding: 0.2em;
        cursor: pointer;
        border: 0;
        height: 47px;
        margin-top: 35px;
    }

    /* Button styles */
    .button {
        display: inline-block;
        padding: 8px 15px; /* Adjust padding for the buttons */
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

    <!-- Main content section with sidebar -->
    <main class="sidebar">
        <!-- Left sidebar section -->
        <section class="left">
            <ul>
                <li><a href="Auctions.php">Auctions</a></li>
                <li><a href="categories.php">Categories</a></li>
            </ul>
        </section>
        
        <!-- Right content section -->
        <section class="right">
            <h2>Edit Auction</h2>
            <?php
    if (isset($_GET['name'])) {
        $auctionName = $_GET['name'];

        // Retrieve the auction details
        $auctionStmt = $pdo->prepare('SELECT * FROM auctions WHERE auction_name = :auctionName');
        $auctionStmt->execute(['auctionName' => $auctionName]);
        $auction = $auctionStmt->fetch(PDO::FETCH_ASSOC);

        if ($auction) {
            // Display the edit auction form
            echo '<form action="editauction.php" method="POST">';
            echo '<input type="hidden" name="auction_name" value="' . $auctionName . '" />';
            
            echo '<div class="form-group">';
            echo '<label for="new_name">New Name:</label><br>';
            echo '<input type="text" name="new_name" value="' . $auction['auction_name'] . '" class="form-input" /><br>';
            echo '</div>';
            
            echo '<div class="form-group">';
            echo '<label for="new_category">New Category:</label><br>';
            echo '<select name="new_category" class="form-input">';
            $categoriesStmt = $pdo->query('SELECT categoryName FROM categories');
            foreach ($categoriesStmt as $category) {
                $selected = ($auction['categoryID'] === $category['categoryName']) ? 'selected' : '';
                echo '<option value="' . $category['categoryName'] . '" ' . $selected . '>' . $category['categoryName'] . '</option>';
            }
            echo '</select><br>';
            echo '</div>';
            
            // Input fields for auctionDate and auction_end_time
            echo '<div class="form-group">';
            echo '<label for="new_auctionDate">New Auction Date:</label><br>';
            echo '<input type="datetime-local" name="new_auctionDate" value="' . $auction['auctionDate'] . '" class="form-input" /><br>';
            echo '</div>';
            
            echo '<div class="form-group">';
            echo '<label for="new_auction_end_time">New Auction End Time:</label><br>';
            echo '<input type="datetime-local" name="new_auction_end_time" value="' . $auction['auction_end_time'] . '" class="form-input" /><br>';
            echo '</div>';
            
            echo '<label for="new_description">New Description:</label><br>';
            echo '<textarea name="new_description" rows="4" cols="50" class="form-textarea">' . $auction['Description'] . '</textarea><br>';
            echo '<input type="submit" value="Update Details" class="button" />';
            echo '</form>';
                } else {
                    echo '<p>Auction not found.</p>';
                }
            } else {
                echo '<p>No auction selected.</p>';
            }
            ?>
        </section>
    </main>
    
    <!-- Footer section -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>
