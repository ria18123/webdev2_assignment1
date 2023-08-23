<?php
session_start(); // Start the session
require('../dataconnection/configuration.php');// Include the database configuration file to establish a connection.
?>
<!-- The body content goes here -->
<!DOCTYPE html>
<html>
<!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Admin Dashboard</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
   
    <!-- Add your additional CSS styles here if needed -->
    <style>
    /* Additional CSS styles for the header form submit button */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }
    
    /* Additional CSS styles for the header form text input */
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
    
    /* Styles for the left section of the sidebar */
    .sidebar .left {
        width: 20%;
        background-color: #555;
        padding: 10px;
        list-style-type: none;
    }
    
    /* Styles for the right section of the sidebar */
    .sidebar .right {
        flex: 1;
        padding: 20px;
        text-align: center;
    }
    
    /* Styles for the footer */
    footer {
        margin-top: 2vw;
    }
    
    /* Button style */
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

    /* Table style */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    /* Styles for table header cells and table data cells */
    table th,
    table td {
        padding: 8px;
        border: 1px solid #ccc;
    }
    
    /* Styles for truncating long text in a table cell */
    .description-cell {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Styles for actions cell in a table */
    .actions-cell {
        width: 150px; /* Decrease the width of the actions column */
        white-space: nowrap;
    }
    
    /* Button style for buttons in this section */
    .button {
        display: inline-block;
        padding: 8px 15px; /* Adjust padding for the buttons */
        background-color: #005d96;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        border: none;
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
            <!-- List of navigation links -->
            <li><a href="admin_panel.php">Admin Dashboard</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
            <li><a href="/Logout.php">Logout</a></li>
        </ul>
    </nav>
    <!-- Banner image -->
    <img src="/banners/2.jpg" alt="Banner" />
    <!-- Main content section with sidebar -->
    <main class="sidebar">
        <!-- Left sidebar section with navigation links -->
        <section class="left">
            <ul>
                <!-- Additional navigation links for this section -->
            <li><a href="categories.php">Categories</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
            </ul>
        </section>
         <!-- Right sidebar section for main content -->
        <section class="right">
            <h2>Admin Panel</h2>
            <p>Welcome to the admin panel</p>
            <!-- You can add more content here if needed -->
        </section>
    </main>
    <!-- Footer section with copyright information -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>

