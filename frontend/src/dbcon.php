<?php
	$servername = "products_db";
	$username = "admin";
	$password = "admin";
	$db= "products_db";

	$mysqli = new mysqli($servername, $username, $password, $db);
	if ($mysqli->connect_error) 
	{
		echo 'Connection Error [', $mysqli->connect_error, ']: ', $mysqli->connect_error;
	} 
?>
