<?php
require('dataconnection/configuration.php'); // Connecting to the database
?>
<!-- post_auction.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Post Auction</title>
</head>
<body>
    <h2>Post Auction</h2>
    <form method="POST" action="process_post_auction.php">
        <label for="auction_name">Auction Name:</label>
        <input type="text" name="auction_name" required><br>

        <label for="auctioneer">Auctioneer:</label>
        <input type="text" name="auctioneer" required><br>

        <label for="auctionDate">Auction Date:</label>
        <input type="date" name="auctionDate" required><br>

        <label for="categoryID">Category:</label>
        <select name="categoryID" required>
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
        </select><br>

        <label for="Description">Description:</label><br>
        <textarea name="Description" rows="4" cols="50" required></textarea><br>

        <button type="submit">Post Auction</button>
    </form>
</body>
</html>
