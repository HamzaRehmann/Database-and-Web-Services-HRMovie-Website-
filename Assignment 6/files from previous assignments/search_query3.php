<?php
// Establish a connection to the MySQL database
$servername = "localhost";
$username = "root";
$password = ""; // Leave this empty if there is no password
$dbname = "moviedatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query 3: Actors/Actresses who have won awards
$sql = "SELECT Actor.aID AS Actor_ID,
               Actor.aName AS Actor_Name,
               Actor_with_awards.aAward AS Award,
               COUNT(Actor_with_awards.aAward) AS Award_Count,
               GROUP_CONCAT(Movie.mTitle ORDER BY Movie.mYear) AS Award_Winning_Movies
        FROM Actor
        JOIN Actor_with_awards ON Actor.aID = Actor_with_awards.aID
        JOIN Movie ON Actor.aID = Movie.aID
        GROUP BY Actor.aID, Actor.aName, Actor_with_awards.aAward
        LIMIT 20";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='column'>";
        echo "<p>Actor ID: {$row['Actor_ID']}</p>";
        echo "<p>Actor Name: {$row['Actor_Name']}</p>";
        echo "<p>Award: {$row['Award']}</p>";
        echo "<p>Award Count: {$row['Award_Count']}</p>";
        echo "<p>Award Winning Movies: {$row['Award_Winning_Movies']}</p>";
        echo "</div>";
    }
} else {
    echo "No results found";
}

// Close the database connection
$conn->close();
?>
