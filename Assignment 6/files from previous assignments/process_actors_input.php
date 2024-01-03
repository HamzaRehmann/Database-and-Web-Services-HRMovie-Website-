<?php
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$dob = $_POST['dob'];
$upcomingMovies = $_POST['upcomingMovies'];
$recentMovie = $_POST['recentMovie'];

$conn = new mysqli('localhost', 'root', '', 'Movie_app');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Actor (firstName, lastName, dob, upcomingMovies, recentMovie) VALUES (?, ?, ?, ?, ?)");

$stmt->bind_param("sssss", $firstName, $lastName, $dob, $upcomingMovies, $recentMovie);

$execVal = $stmt->execute();

if ($execVal) {
    echo "Actor information added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';
?>
