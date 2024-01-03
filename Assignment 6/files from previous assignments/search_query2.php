<?php
// Establish a connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviedatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query 2: Directors with more than one movie
$sql = "SELECT d.dName AS director_name, COUNT(m.dID) AS movie_count
        FROM Director d
        JOIN Movie m ON d.dID = m.dID
        GROUP BY director_name
        HAVING movie_count > 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='column'>";
        echo "<p>Director Name: {$row['director_name']}</p>";
        echo "<p>Movie Count: {$row['movie_count']}</p>";
        echo "</div>";
    }
} else {
    echo "No results found";
}

// Close the database connection
$conn->close();
?>
