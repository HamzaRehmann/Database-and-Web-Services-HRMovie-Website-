<?php
$movieId = $_POST['movie'];
$directorId = $_POST['director'];


$conn = new mysqli('localhost', 'root', '', 'Movie_app');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Movie_has_Director (movieId, directorId) VALUES (?, ?)");


$stmt->bind_param("ii", $movieId, $directorId);


$execVal = $stmt->execute();

if ($execVal) {
    echo "Movie Director relationship added successfully";
} else {
    echo "Error: " . $stmt->error;
}


$stmt->close();
$conn->close();

echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';
?>
