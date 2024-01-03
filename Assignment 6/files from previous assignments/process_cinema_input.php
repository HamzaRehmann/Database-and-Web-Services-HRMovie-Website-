<?php
$movie = $_POST['movie'];
$cinemaName = $_POST['cinemaName'];
$showTime = $_POST['showTime'];
$seatNumber = $_POST['seatNumber'];
$location = $_POST['location'];
$dimension = $_POST['dimension'];


$conn = new mysqli('localhost', 'root', '', 'Movie_app');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Cinema (movie, cinemaName, showTime, seatNumber, location, dimension) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $movie, $cinemaName, $showTime, $seatNumber, $location, $dimension);
$executed = $stmt->execute();


if ($executed) {
    echo "Cinema input successful!";
} else {
    echo "Error: " . $stmt->error;
}


$stmt->close();
$conn->close();

echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';

?>
