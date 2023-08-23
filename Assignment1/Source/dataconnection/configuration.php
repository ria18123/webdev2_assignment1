<?php
// Database server details
$server = 'localhost';      // Replace with your database server hostname
$username = 'root';         // Replace with your database username
$password = 'example';      // Replace with your database password

// Database DNS (Data Source Name)
$dns = 'mysql:dbname=assignment1; host=db';  // Replace with your database name and host

// Creating a new PDO instance for database connection
$pdo = new PDO($dns, $username, $password);
?>
