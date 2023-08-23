<?php
// viewauction.php
require('../dataconnection/configuration.php'); // Include the database configuration file to establish a connection

if (isset($_GET['name'])) {
    // Get the auction name from the query parameter
    $auctionName = $_GET['name'];

    // Fetch auction details from the database
    $auctionStmt = $pdo->prepare('SELECT * FROM auctions WHERE auction_name = :auctionName');
    $auctionStmt->execute(['auctionName' => $auctionName]);
    $auction = $auctionStmt->fetch(PDO::FETCH_ASSOC);

    if ($auction) {
        // Start of HTML content
        echo '<!DOCTYPE html>
        <head>
            <title>View Auction</title>
            <link rel="stylesheet" href="/ibuy.css" />
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
            background-color: #005d96;
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
                background-color: #5aa0c2;
            }
            /* Button style */
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
            main {min-height: 50vh; background-color: #fff; width: 70vw; display: block; margin: auto; box-shadow: 0px 0px 10px #888; color:#444;}

            main h2 {font-size:2em;}
            
            footer {background-color: #fff; padding: 10px; color: #000;}
            
            .left ul {list-style-type: none }
            section a {color: #444;}
            
            p, li, h2 {
              margin-bottom: 1em;
              margin-left: 14px;
            }
            
            .stock, .sidebar {display: table;}
            .stock > ul, .sidebar .left { width: 10vw; list-style-type: none; display: table-cell; padding: 10px; background-color: #555; margin: 0;}
            .stock .products, .sidebar .right {display: table-cell; padding: 20px;}
            .stock > ul a, .sidebar .left a {color: white; text-decoration: none;}
            a:hover {color: lightgray !important;}
            .right {padding: 20px;}
            main h1 {color: #666;}
            </style>
        </head>
        <!-- Header with search form -->
        <body>
        <!-- ... (Header content with search form) ... -->
            <header>
                <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
                <form action="#">
                    <input type="text" name="search" placeholder="Search for anything" />
                    <input type="submit" name="submit" value="Search" />
                </form>
            </header>
            <!-- ... (Navigation menu with links) ... -->
            <nav>
                <ul>
                    <li><a href="admin_panel.php">Admin Dashboard</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="Auctions.php">Auctions</a></li>>
                </ul>
            </nav>
            <!-- Banner image -->
            <img src="/banners/2.jpg" alt="Banner" />
            <!-- Main content with sidebar -->
            <main class="sidebar">
                <section class="left">
                <!-- Sidebar navigation links -->
                    <ul>
                    <li><a href="Auctions.php">Auctions</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <!-- Delete button as a vertical button -->
                    <div class="action-buttons">
                        <a href="editauction.php?name=' . $auction['auction_name'] . '">Edit Auction</a>
                    </div>

                    </ul>
                </section>
                <section class="right">
                    <h2>' . $auction['auction_name'] . '</h2>
                    <p>Category: ' . $auction['categoryName'] . '</p>
                    <p>Auctioneer: ' . $auction['auctioneer'] . '</p>
                    <p>Auction Date: ' . $auction['auctionDate'] . '</p>
                    <p>Auction Date: ' . $auction['auction_end_time'] . '</p>
                    <p>Description: ' . $auction['Description'] . '</p>

                    <!-- Delete button as a vertical button -->
                    <div class="action-buttons">
                        <a class="button" href="deleteauction.php?name=' . $auction['auction_name'] . '">Delete Auction</a>
                    </div>

                    <!-- Space for separation -->
                    <div style="margin-top: 10px;"></div>

                    <div class="action-buttons">
                        <a class="button" href="javascript:history.go(-1)">Go Back</a>
                    </div>
                </section>
            </main>
        </body>
        </html>';
    } else {
        echo 'Auction not found';
    }
} else {
    echo 'Invalid request';
}
?>
<footer>
&copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
</footer>





