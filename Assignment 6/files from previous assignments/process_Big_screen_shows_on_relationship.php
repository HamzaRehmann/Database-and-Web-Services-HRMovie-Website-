<?php
$movieOnBigScreenId = $_POST['movieOnBigScreen'];
$cinemaId = $_POST['cinema'];
$showTime = $_POST['showTime'];
$price = $_POST['price'];


$conn = new mysqli('localhost', 'root', '', 'Movie_app');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO Big_screen_shows_on (movieOnBigScreenId, cinemaId, showTime, price) VALUES (?, ?, ?, ?)");


$stmt->bind_param("iiss", $movieOnBigScreenId, $cinemaId, $showTime, $price);


$execVal = $stmt->execute();

if ($execVal) {
    echo "Movie On Big Screen Shows On Cinemas relationship added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();


echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';
?>
