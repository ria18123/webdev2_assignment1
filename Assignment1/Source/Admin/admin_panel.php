<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
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
            text-align: center;
        }
        footer{
            margin-top: 2vw;
        }
                /* Button style */

        
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
            <li><a href="admin_pannel.php">Admin Dashboard</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="/Logout.php">Logout</a></li>
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
            <h2>Admin Panel</h2>
            <p>Welcome to the admin panel</p>
            <!-- You can add more content here if needed -->
        </section>
    </main>
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>

