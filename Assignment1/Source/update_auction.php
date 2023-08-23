<?php
// Include the database connection code from configuration.php
require('dataconnection/configuration.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auction_name = $_POST['auction_name'];
    $new_auction_name = $_POST['new_auction_name'];
    $new_category = $_POST['new_category'];
    $new_auctionDate = $_POST['new_auctionDate'];
    $new_auction_end_time = $_POST['new_auction_end_time'];
    $new_description = $_POST['new_description'];

    // Update the auction details in the database
    $update_query = "UPDATE auctions SET auction_name = ?, categoryName = ?, auctionDate = ?, auction_end_time = ?, Description = ? WHERE auction_name = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$new_auction_name, $new_category, $new_auctionDate, $new_auction_end_time, $new_description, $auction_name]);

    // Redirect back to user_auctions.php after the update
    header('Location: user_auctions.php');
    exit();
}
?>
