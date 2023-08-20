<?php
require('../dataconnection/configuration.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['auction_name'], $_POST['auctioneer'], $_POST['auctionDate'], $_POST['categoryID'], $_POST['Description'])) {
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

<!DOCTYPE html>
<html>
<head>
    <title>Add Auction</title>
    <link rel="stylesheet" href="/ibuy.css" />
    <link rel="stylesheet" href="/styles.css" />
    <!-- Add your additional CSS styles here if needed -->
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
        .actions-cell .button {
        width: auto;
        padding: 0.5em 1em;
        margin-bottom: 10px; /* Add margin between buttons */
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
    background-color: #5aa0c2;
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
  background-color: #4CAF50;
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

        /* Additional styles for alignment */
        .form-group {
            margin-bottom: 20px;
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
    <img src="/banners/1.jpg" alt="Banner" />


    <main class="sidebar">
    <section class="left">
            <ul>
                <li><a href="addauction.php">Add Auction</a></li>
                <li><a href="editauction.php">Edit Auction</a></li>
                <li><a href="deleteauction.php">Delete Auction</a></li>
            </ul>
        </section>
        <section class="right">
            <h2>Add Auction</h2>
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
    </main>

    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>
