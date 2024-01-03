<?php
$platformName = $_POST['platformName'];
$releasedYear = $_POST['releasedYear'];
$genre = $_POST['genre'];
$title = $_POST['title'];
$rating = $_POST['rating'];
$top10InCountry = $_POST['top10InCountry'];


$conn = new mysqli('localhost', 'root', '', 'Movie_app');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Movie_on_OTT_platforms (platformName, releasedYear, genre, title, rating, top10InCountry) VALUES (?, ?, ?, ?, ?, ?)");


$stmt->bind_param("sissss", $platformName, $releasedYear, $genre, $title, $rating, $top10InCountry);


$execVal = $stmt->execute();

if ($execVal) {
    echo "Movie on OTT Platform information added successfully";
} else {
    echo "Error: " . $stmt->error;
}


$stmt->close();
$conn->close();


echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';
?>
