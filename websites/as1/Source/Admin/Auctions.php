<?php
// Include the database configuration file to establish a connection
require('../dataconnection/configuration.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'id' field is set in the submitted form
    if (isset($_POST['id'])) {
        // Retrieve the auction name from the submitted form data
        $auctionName = $_POST['id'];

        // Archive the auction by updating its status to "archived" in the database
        $archiveStmt = $pdo->prepare('UPDATE auctions SET status = "archived" WHERE auction_name = :auctionName');
        $archiveStmt->execute(['auctionName' => $auctionName]);

        // Display a success message
        echo '<div class="message">Auction archived successfully</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title of the page -->
    <title>Admin Panel</title>
    <!-- /* Import the main CSS file for the page */ -->
    <link rel="stylesheet" href="/ibuy.css" />
    <style>
       /* Additional inline styles for specific elements */
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
        
         /* Sidebar styling */
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
        /* Styling for the footer */
        footer {
            margin-top: 2vw;
        }
         /* Styling for table elements */
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
         /* Description cell styling */
        .description-cell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
         /* Actions cell styling */
        .actions-cell {
            width: 150px;
            white-space: nowrap;/* Decrease the width of the actions column */
        }
        /* Generic button styles */
        .actions-cell .button {
        width: auto;
        padding: 0.5em 1em;
        margin-bottom: 10px; /* Add margin between buttons */
        }
 
 /* Adjust the styles for the buttons */

.button {
  display: inline-block;
  padding: 8px 25px;
  margin-right: 10px;
  background-color: #005d96;
  color: #fff;
  text-decoration: none;
  border-radius: 4px;
  border: none;
  min-width: 120px;
  text-align: center;
  line-height: 20px;
}
        
/* Hover effect for buttons */
.button:hover {
  background-color: #5aa0c2;
}


main form input {
        flex-grow: 1;
        width: 20vw;
        margin-bottom: 1em;
        margin-right: 2vw;
        margin-left: 2vw;
        height: 30px;
    }
    main {
        min-height: 50vh;
        background-color: #fff;
        width: 70vw;
        display: block;
        margin: auto;
        box-shadow: 0px 0px 10px #888;
        color: #444;
    }
    main h2 {
        font-size: 2em;
    }
    footer {
        background-color: #fff;
        padding: 10px;
        color: #000;
    }
    .left ul {
        list-style-type: none;
    }
    section a {
        color: #444;
    }
    p,
    li,
    h2 {
        margin-bottom: 1em;
        margin-left: 14px;
    }
    .stock,
    .sidebar {
        display: table;
    }
    .stock > ul,
    .sidebar .left {
        width: 10vw;
        list-style-type: none;
        display: table-cell;
        padding: 10px;
        background-color: #555;
        margin: 0;
    }
    .stock .products,
    .sidebar .right {
        display: table-cell;
        padding: 20px;
    }
    .stock > ul a,
    .sidebar .left a {
        color: white;
        text-decoration: none;
    }
    a:hover {
        color: lightgray !important;
    }
    .right {
        padding: 20px;
    }
    main h1 {
        color: #666;
    }

    </style>
</head>
<body>
    <header>
        <!-- Header with a stylized title -->
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <!-- Search form -->
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    <nav>
        <!-- Navigation menu -->
        <ul>
            <li><a href="admin_panel.php">Admin Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
        </ul>
    </nav>
    <!-- Banner image -->
    <img src="/banners/2.jpg" alt="Banner" />
    <main class="sidebar">
        <section class="left">
            <!-- Sidebar navigation links -->
            <ul>
                <li><a href="Auctions.php">Auctions</a></li>
                <li><a href="categories.php">Categories</a></li>
            </ul>
        </section>
        <section class="right">
            <h2>Auctions</h2>
            <!-- Button to add a new auction -->
            <a class="button new" href="addauction.php">Add new auction</a>
            
            <?php
            // PHP code to display auction data from the database
            echo '<table class="auctions">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '<th>Category</th>';
            echo '<th>Description</th>';
            echo '<th>Auction Date</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            
            // Query the database for auction data
            $stmt = $pdo->query('SELECT * FROM auctions');
            
            // Loop through each auction and display its information
            foreach ($stmt as $auction) {
                echo '<tr>';
                echo '<td>' . $auction['auction_name'] . '</td>';
                echo '<td>' . $auction['categoryName'] . '</td>'; // Display category
                echo '<td class="description-cell">' . $auction['Description'] . '</td>';
                echo '<td>' . $auction['auctionDate'] . '</td>'; // Display the auction date
                
                // Display action buttons for the auction
                echo '<td class="actions-cell">';
                echo '<a class="button" href="viewbidders.php?name=' . urlencode($auction['auction_name']) . '">View Bidders (' . $bidderCount['count'] . ')</a>';
                echo '<a class="button" href="editauction.php?name=' . urlencode($auction['auction_name']) . '">Edit Auction</a>';
                echo '<a class="button" href="viewauction.php?name=' . urlencode($auction['auction_name']) . '">View Full Details</a>';
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</table>';
            ?>
        </section>
    </main>
    <footer>
        <!-- Display the current year dynamically in the footer -->
        &copy; ibuy <?php echo date("Y"); ?>
    </footer>
</body>
</html>
