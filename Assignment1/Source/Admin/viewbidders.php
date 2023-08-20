<?php
// viewauction.php
require('../dataconnection/configuration.php');

if (isset($_GET['name'])) {
    $auctionName = $_GET['name'];

    // Fetch auction details from the database
    $auctionStmt = $pdo->prepare('SELECT * FROM auctions WHERE auction_name = :auctionName');
    $auctionStmt->execute(['auctionName' => $auctionName]);
    $auction = $auctionStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch bidder information from the bids table
    $bidStmt = $pdo->prepare('SELECT * FROM bids WHERE auction_name = :auctionName');
    $bidStmt->execute(['auctionName' => $auctionName]);
    $bidders = $bidStmt->fetchAll(PDO::FETCH_ASSOC);

    if ($auction) {
        echo '
        <!DOCTYPE html>
        <head>
            <title>View Auction</title>
            <link rel="stylesheet" href="/ibuy.css" />
            <link rel="stylesheet" href="/styles.css" />
            <style>
            <style>
            /* Add your additional CSS styles here if needed */
            header form input[type=submit] {
                background-color: #005d96;
                color: white;
                width: 20%;
                font-size: 2em;
                padding: 0.5em;
                cursor: pointer;
                border: 0;
            }
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
            .sidebar .left {
                width: 20%;
                background-color: #555;
                padding: 10px;
                list-style-type: none;
            }
            .sidebar .right {
                flex: 1;
                padding: 20px;
                
            }
            footer {
                margin-top: 2vw;
            }
            body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }
    
            main {
                flex: 1;
            }
      /* Table style */
      table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            
            table th,
            table td {
                padding: 8px;
                border: 1px solid #ccc;
            }
            
            .description-cell {
                max-width: 300px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .actions-cell {
                white-space: nowrap;
            }
            
            /* Style for the vertical button stacking */
            .action-buttons {
                display: flex;
                flex-direction: column;
                align-items: flex-start; /* Align buttons to the left */
                gap: 10px; /* Gap between buttons */
            }
            
            /* Button style */
            .button {
                display: inline-block;
                padding: 8px 25px;
                background-color: #4CAF50;
                color: #fff;
                
                text-decoration: none;
                border-radius: 4px;
                border: none;
            }
            
        /* Adjust the styles for the buttons */
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
            /* Button style */
.button {
    display: inline-block;
    padding: 8px 15px; /* Adjust padding for the buttons */
    background-color: #4CAF50;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    border: none;
}

/* Hover effect for buttons */
.button:hover {
    background-color: #45a049;
}
a, a:visited {
  color: white;
}

            </style>
        </head>
        <body>
        <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    <nav>
        <ul>
            <li><a href="admin_panel.php">Home</a></li>
            <li><a href="/">Auctions</a></li>
            <li><a href="categories.php">Categories</a></li>
        </ul>
    </nav>

    <main class="sidebar">
    <section class="left">
        <ul>
        <li><a href="Auctions.php">Auctions</a></li>
        <li><a href="categories.php">Categories</a></li>
        </ul>
    </section>
    <section class="right">
        <h1>View Bidders - ' . $auctionName . '</h1>
        <p>Auctioneer: ' . $auction['auctioneer'] . '</p>
        <table>
            <tr>
                <th style="text-align: center;">Bid Amount</th>
                <th style="text-align: center;">Bidder Email</th>
            </tr>';
foreach ($bidders as $bidder) {
echo '<tr>
            <td style="text-align: center;">' . $bidder['bidAmount'] . '</td>
            <td style="text-align: center;">' . $bidder['bidder_email'] . '</td>
        </tr>';
}
echo '</table>
        <!-- Add space between table and button -->
        <div style="margin-top: 20px;" class="action-buttons">
            <a class="button" href="javascript:history.go(-1)">Go Back</a>
        </div>
    </section>
</main>
<footer>
&copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
</footer>
</body>
</html>';
} else {
echo 'Auction not found';
}
} else {
echo 'Invalid request';
}
?>