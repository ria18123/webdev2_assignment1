<?php
// deleteauction.php
require('../dataconnection/configuration.php');

if (isset($_GET['name'])) {
    $auctionName = $_GET['name'];

    // Delete bids associated with the auction
    $deleteBidsStmt = $pdo->prepare('DELETE FROM bids WHERE auction_name = :auctionName');
    $deleteBidsStmt->execute(['auctionName' => $auctionName]);

    // Delete reviews associated with the auction
    $deleteReviewsStmt = $pdo->prepare('DELETE FROM reviews WHERE auction_name = :auctionName');
    $deleteReviewsStmt->execute(['auctionName' => $auctionName]);

    // Delete comments associated with the auction (replace `comment` with the actual table name)
    $deleteCommentsStmt = $pdo->prepare('DELETE FROM comment WHERE auction_name = :auctionName');
    $deleteCommentsStmt->execute(['auctionName' => $auctionName]);

    // Delete auction from the auctions table
    $deleteAuctionStmt = $pdo->prepare('DELETE FROM auctions WHERE auction_name = :auctionName');
    $deleteAuctionStmt->execute(['auctionName' => $auctionName]);

    // Redirect back to the auctions list page
    header('Location: admin_panel.php'); // Change this to the appropriate page
    exit();
} else {
    echo 'Invalid request';
}
?>
