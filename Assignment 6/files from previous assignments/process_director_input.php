<?php
$name = $_POST['name'];
$dob = $_POST['dob'];
$mostRecentMovie = $_POST['mostRecentMovie'];
$upcomingMovie = $_POST['upcomingMovie'];


$conn = new mysqli('localhost', 'root', '', 'Movie_app');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Director (name, dob, mostRecentMovie, upcomingMovie) VALUES (?, ?, ?, ?)");


$stmt->bind_param("ssss", $name, $dob, $mostRecentMovie, $upcomingMovie);


$execVal = $stmt->execute();

if ($execVal) {
    echo "Director information added successfully";
} else {
    echo "Error: " . $stmt->error;
}


$stmt->close();
$conn->close();

echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';
?>
