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

// Query 1: Top movies by genre
$sql = "SELECT mGenre, mTitle, MAX(mRating) AS highest_rating FROM Movie GROUP BY mGenre;"; // Query used for SQL

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='column'>";
        echo "<img src='img/{$row['image']}' alt='{$row['title']}'>";
        echo "<p>{$row['title']}</p>";
        echo "</div>";
    }
} else {
    echo "No results found";
}

// Close the database connection
$conn->close();
?>
