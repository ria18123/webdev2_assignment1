<?php
require('dataconnection/configuration.php'); //for creating the connection to the database 
//select from article
$articlestmt= $pdo -> prepare ('SELECT * FROM article ORDER BY published_date DESC');
//execution is done for displaying 
$articlestmt -> execute(); 
// articles are listed in row 
foreach($articlestmt as $articlerow){
//for  artice title category content and publisher
	echo '<h2 id="heading">' . $articlerow['title'] .'</h2>
	<p  id="">' . $articlerow['category'].' </p>
	<p  id="">' . $articlerow['content']. '</p>
	<p id="">' . $articlerow['publisher'].'</p>
	<h4 id="Comments">Comments</h3>';

}

