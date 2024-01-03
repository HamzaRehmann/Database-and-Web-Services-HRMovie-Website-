<?php
$genre = $_POST['genre'];
$title = $_POST['title'];
$rating = $_POST['rating'];
$year = $_POST['year'];


$conn = new mysqli('localhost', 'root', '', 'Movie_app');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Movie (genre, title, rating, year) VALUES (?, ?, ?, ?)");


$stmt->bind_param("sssi", $genre, $title, $rating, $year);

$execVal = $stmt->execute();

if ($execVal) {
    echo "Movie information added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';
?>
