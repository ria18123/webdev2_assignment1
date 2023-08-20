<?php
require('../dataconnection/configuration.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['auction_name'])) {
        $auctionName = $_POST['auction_name'];
        $newName = $_POST['new_name'];
        $newCategory = $_POST['new_category'];
        $newDescription = $_POST['new_description'];

        // Delete associated bids
        $deleteBidsStmt = $pdo->prepare('DELETE FROM bids WHERE auction_name = :auctionName');
        $deleteBidsStmt->execute(['auctionName' => $auctionName]);

        // Update the auction's name, category, and description
        $updateStmt = $pdo->prepare('UPDATE auctions SET auction_name = :newName, categoryID = :newCategory, Description = :newDescription WHERE auction_name = :auctionName');
        $updateStmt->execute(['newName' => $newName, 'newCategory' => $newCategory, 'newDescription' => $newDescription, 'auctionName' => $auctionName]);

        // Display a success message
        echo '<div class="message">Auction details updated successfully</div>';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Auction</title>
    <link rel="stylesheet" href="/ibuy.css" />
    <link rel="stylesheet" href="/styles.css" />
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
        }
        .form-textarea {
            width: 100%;
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
  margin-left: 31px;
  font-size: 1.2em;
  padding: 0.2em;
  cursor: pointer;
  border: 0;
  height: 47px;
  margin-top: 35px;
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
    <img src="/banners/1.jpg" alt="Banner" />

    <main class="sidebar">
    <section class="left">
        <ul>
        <li><a href="Auctions.php">Auctions</a></li>
        <li><a href="categories.php">Categories</a></li>
        </ul>
    </section>
    <section class="right">
    <h2>Edit Auction</h2>
    <?php
    if (isset($_GET['name'])) {
        $auctionName = $_GET['name'];

        // Retrieve the auction details
        $auctionStmt = $pdo->prepare('SELECT * FROM auctions WHERE auction_name = :auctionName');
        $auctionStmt->execute(['auctionName' => $auctionName]);
        $auction = $auctionStmt->fetch(PDO::FETCH_ASSOC);

        if ($auction) {
            echo '<form action="editauction.php" method="POST">';
            echo '<input type="hidden" name="auction_name" value="' . $auctionName . '" />';
            
            echo '<div class="form-group">';
            echo '<label for="new_name">New Name:</label><br>';
            echo '<input type="text" name="new_name" value="' . $auction['auction_name'] . '" class="form-input" /><br>';
            echo '</div>';
            
            echo '<div class="form-group">';
            echo '<label for="new_category">New Category:</label><br>';
            echo '<select name="new_category" class="form-input">';
            $categoriesStmt = $pdo->query('SELECT categoryName FROM categories');
            foreach ($categoriesStmt as $category) {
                $selected = ($auction['categoryID'] === $category['categoryName']) ? 'selected' : '';
                echo '<option value="' . $category['categoryName'] . '" ' . $selected . '>' . $category['categoryName'] . '</option>';
            }
            echo '</select><br>';
            echo '</div>';
            
            echo '<label for="new_description">New Description:</label><br>';
            echo '<textarea name="new_description" rows="4" cols="50" class="form-textarea">' . $auction['Description'] . '</textarea><br>';
            echo '<input type="submit" value="Update Details" class="button" />';
            echo '</form>';
        } else {
            echo '<p>Auction not found.</p>';
        }
    } else {
        echo '<p>No auction selected.</p>';
    }
    ?>
</section>
    </main>
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>