<?php
require('../dataconnection/configuration.php');

$categoryName = isset($_GET['category']) ? $_GET['category'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCategoryName = $_POST['newCategoryName'];

    // Update the category name in the categories table
    $sql = "UPDATE categories SET categoryName = ? WHERE categoryName = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$newCategoryName, $categoryName]);

    // Redirect back to edit category page
    header('Location: categories.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
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
    background-color: #5aa0c2;
}
/* * Additional styles for alignment */ */
        .form-group {
            margin-bottom: 20px;
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
        main form input {
            flex-grow: 1;
            width: 20vw;
            margin-bottom: 1em;
            margin-right: 2vw;
            margin-left: 2vw;
            height: 30px;
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
            <h2>Edit Category: <?php echo $categoryName; ?></h2>
            <form method="POST">
                <label for="newCategoryName">New Category Name:</label>
                <input type="text" name="newCategoryName" value="<?php echo $categoryName; ?>" required><br>
                <input type="submit" value=" Update Category" class="button" />
            </form>
        </section>
        <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>