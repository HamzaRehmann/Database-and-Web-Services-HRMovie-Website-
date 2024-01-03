<?php
	// Establish a connection to the MySQL database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "moviedatabase";
	
	$db = new mysqli($servername, $username, $password, $dbname);

	// Check the connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	// Get search term
	$searchTerm = $_GET["term"];
	
	// Fetch data from the database
	$query = $db->query("SELECT mTitle  FROM Movie WHERE mTitle LIKE '%".$searchTerm."%' ORDER BY mRate DESC");
	
	// Generate array with names
	$names = array();
	if($query->num_rows){
		while($row = $query->fetch_assoc()){
			$data['value'] = $row ['mTitle'];
			array_push($names, $data);
		}
	}
	
	// Return result
	echo json_encode($names);
	

?>