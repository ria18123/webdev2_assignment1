<?php
// Start the session
session_start();

// Include the database connection code from configuration.php
require('dataconnection/configuration.php');

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store form inputs
    $auction_name = $_POST['auction_name'];
    $auctioneer = $_POST['auctioneer'];
    $auctionDate = $_POST['auctionDate'];
    $auction_end_time = $_POST['auction_end_time']; // Added
    $categoryName = $_POST['categoryName'];
    $Description = $_POST['Description'];

    // Get the currently logged-in user's ID (assuming user data is stored in $_SESSION['user'])
    $user_email = $_SESSION['user']['Email'];

    // Check if an auction with the same name already exists
    $check_sql = "SELECT auction_name FROM auctions WHERE auction_name = ?";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->execute([$auction_name]);
    $existing_auction = $check_stmt->fetch();

    if ($existing_auction) {
        // Auction with the same name already exists
        // Handle the error (e.g., display an error message)
        echo "An auction with the same name already exists. Please choose a different name.";
    } else {
        // Insert auction data into the database
        $insert_sql = "INSERT INTO auctions (auction_name, auctioneer, auctionDate, auction_end_time, categoryName, Description) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $pdo->prepare($insert_sql);
        $insert_stmt->execute([$auction_name, $user_email, $auctionDate, $auction_end_time, $categoryName, $Description]);

        // Redirect to a success page or user's dashboard
        header('Location: user_auctions.php'); // Change this to your desired location
        exit();
    }
}
?>
