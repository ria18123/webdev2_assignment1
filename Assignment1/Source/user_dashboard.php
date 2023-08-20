<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome to Your Dashboard</h2>
    <?php if (isset($_SESSION['user'])) { ?>
        <p>Hello, <?php echo $_SESSION['user']['FirstName']; ?>!</p>

        <!-- Link to post auction -->
        <a href="post_auction.php">Post Auction</a>
    <?php } else { ?>
        <p>Please log in to access your dashboard.</p>
    <?php } ?>
</body>
</html>
