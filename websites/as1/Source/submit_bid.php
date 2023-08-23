<?php
require('dataconnection/configuration.php'); // Connecting to the database

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bid"])) {
    $auctionName = $_POST["auction_name"];
    $bidAmount = $_POST["bid"];
    $bidderEmail = "user@example.com"; // You can get this from the logged-in user if applicable

    // Insert bid into the database
    $insertBidQuery = "INSERT INTO bids (auction_name, bidAmount, bidder_email) VALUES (?, ?, ?)";
    $insertBidStmt = $pdo->prepare($insertBidQuery);
    $insertBidStmt->execute([$auctionName, $bidAmount, $bidderEmail]);

    // Redirect back to auction_details.php with success message
    header("Location: auction_details.php?auction_name=$auctionName&bid_success=true");
    exit(); // Important to stop further script execution
}
?>
