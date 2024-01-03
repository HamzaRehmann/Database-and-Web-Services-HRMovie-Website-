<?php
$movieId = $_POST['movie'];
$actorId = $_POST['actor'];


$conn = new mysqli('localhost', 'root', '', 'Movie_app');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Movie_has_Actor (movieId, actorId) VALUES (?, ?)");


$stmt->bind_param("ii", $movieId, $actorId);


$execVal = $stmt->execute();

if ($execVal) {
    echo "Movie Actor relationship added successfully";
} else {
    echo "Error: " . $stmt->error;
}


$stmt->close();
$conn->close();


echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';
?>
