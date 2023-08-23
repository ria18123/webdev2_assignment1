<?php
require('../dataconnection/configuration.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_category = $_POST['original_category'];
    $new_category = $_POST['new_category'];

    // 1. Update references in auctions table
    $update_auction_query = "UPDATE auctions SET categoryName = ? WHERE categoryName = ?";
    $update_auction_stmt = $pdo->prepare($update_auction_query);
    $update_auction_stmt->execute([$new_category, $original_category]);

    // 2. Update references in reviews table
    $update_review_query = "UPDATE reviews SET auction_name = ? WHERE auction_name = ?";
    $update_review_stmt = $pdo->prepare($update_review_query);
    $update_review_stmt->execute([$new_category, $original_category]);

    // 3. Redirect to categories.php after the update
    header('Location: categories.php');
    exit();
}
?>

