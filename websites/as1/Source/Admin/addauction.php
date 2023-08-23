<?php
// Include the database configuration file to establish a connection.
require('../dataconnection/configuration.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are set in the POST data
    if (isset($_POST['auction_name'], $_POST['auctioneer'], $_POST['auctionDate'], $_POST['categoryID'], $_POST['Description'])) {
        // Get data from the POST variables
        $auctionName = $_POST['auction_name'];
        $auctioneer = $_POST['auctioneer'];
        $auctionDate = $_POST['auctionDate'];
        $categoryID = $_POST['categoryID'];
        $description = $_POST['Description'];

        // Insert the new auction into the database
        $insertStmt = $pdo->prepare('INSERT INTO auctions (auction_name, auctioneer, auctionDate, categoryID, Description) VALUES (:auctionName, :auctioneer, :auctionDate, :categoryID, :description)');
        $insertStmt->execute([
            'auctionName' => $auctionName,
            'auctioneer' => $auctioneer,
            'auctionDate' => $auctionDate,
            'categoryID' => $categoryID,
            'description' => $description
        ]);

        // Display a success message
        echo '<div class="message">Auction added successfully</div>';
    }
}
?>

<!-- The body content goes here -->
<!DOCTYPE html>
<html>
 <!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Add Auction</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
    <!-- Add your additional CSS styles here if needed -->
    <style>
        /* Additional CSS styles for the header form */
        header form input[type=submit] {
            /* Button styling */
            background-color: #005d96;
            color: white;
            width: 20%;
            font-size: 2em;
            padding: 0.5em;
            cursor: pointer;
            border: 0;
        }
        header form input[type="text"] {
            /* Text input styling */
            border: 2px solid black;
            font-size: 2em;
            padding: 0.45em;
            width: 70%;
        }
        
        /* Styles for the sidebar */
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
            width: 150px; /* Decrease the width of the actions column */
            white-space: nowrap;
        }
        
        /* Button style */
    
        
        /* Hover effect for buttons */
        .button:hover {
            background-color: #45a049;
        }
        
        /* Additional styles for alignment */
        .form-label {
            display: block;
            margin-top: 10px;
        }
        .form-input {
            padding: 5px;
            margin-top: 5px;
            border: 2px solid black;
            margin-left: 2px;
        }
        .form-textarea {
            width: 180%;
            padding: 5px;
            margin-top: 5px;
            border: 2px solid black;
        }
        .form-group {
            margin-bottom: 20px; /* Add desired spacing between the input boxes */
        }
        main form input[type="submit"] {
            /* Button styling within the main content */
            background-color:#005d96;
            color: white;
            flex-grow: 0;
            margin-left: auto;
            font-size: 1.2em;
            padding: 0.2em;
            cursor: pointer;
            border: 0;
            height: 47px;
            margin-top: 23px;
            margin-right: 455px;
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
        
        /* Additional styles for alignment */
        .form-group {
            margin-bottom: 20px;
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
    <!-- Header section with website logo and search form -->
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <!-- Search form -->
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    <!-- Navigation menu -->
    <nav>
        <ul>
            <li><a href="admin_panel.php">Admin Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
        </ul>
    </nav>
    <!-- Banner image -->
    <img src="/banners/2.jpg" alt="Banner" />

    <!-- Main content section with sidebar -->
    <main class="sidebar">
        <!-- Left sidebar section with navigation links -->
        <section class="left">
            <ul>
            <li><a href="Auctions.php">Auctions</a></li>
                <li><a href="addauction.php">Add Auction</a></li>
            </ul>
        </section>
        <!-- Right sidebar section for adding an auction -->
        <section class="right">
            <h2>Add Auction</h2>
            <!-- Form for adding an auction -->
            <form action="addauction.php" method="POST">
                <div class="form-group">
                    <label for="auction_name">Auction Name:</label><br>
                    <input type="text" name="auction_name" class="form-input" required /><br>
                </div>
                <div class="form-group">
                    <label for="auctioneer">Auctioneer:</label><br>
                    <input type="text" name="auctioneer" class="form-input" required /><br>
                </div>
                <div class="form-group">
                    <label for="auctionDate">Auction Date:</label><br>
                    <input type="date" name="auctionDate" class="form-input" required /><br>
                </div>
                <div class="form-group">
                    <label for="categoryID">Category:</label><br>
                    <!-- Dropdown list of categories populated from the database -->
                    <select name="categoryID" class="form-input" required>
                        <?php
                        $categoriesStmt = $pdo->query('SELECT categoryName FROM categories');
                        foreach ($categoriesStmt as $category) {
                            echo '<option value="' . $category['categoryName'] . '">' . $category['categoryName'] . '</option>';
                        }
                        ?>
                    </select><br>
                </div>
                <div class="form-group">
                    <label for="Description">Description:</label><br>
                    <textarea name="Description" rows="4" cols="50" class="form-textarea" required></textarea><br>
                </div>
                <!-- Add Auction button -->
                <input type="submit" value="Add Auction" class="button" />
            </form>
        </section>
    </main>

    <!-- Footer section with copyright information -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>

