<?php
// Start the session
session_start();

// Include the database connection code from configuration.php
require('dataconnection/configuration.php');

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page if user is not logged in
    header('Location: login.php'); // Change this to your login page
    exit();
}

// Get the auction name from the query parameter
$auction_name = $_GET['id'];

// Delete the auction from the database
$delete_auction_sql = "DELETE FROM auctions WHERE auction_name = ?";
$delete_auction_stmt = $pdo->prepare($delete_auction_sql);
$delete_auction_stmt->execute([$auction_name]);

// Redirect back to user's auctions page
header('Location: user_auctions.php');
exit();
?>
