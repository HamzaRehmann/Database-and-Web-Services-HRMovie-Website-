 <?php
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];

$conn = new mysqli('localhost', 'root', '', 'Movie_app');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO user (firstName, lastName, email, dob, gender, phone) VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssi", $firstName, $lastName, $email, $dob, $gender, $phone);

$execVal = $stmt->execute();

if ($execVal) {
    echo "Registration successful";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

echo '<p><a href="maintenance.html">Back to Maintenance Page</a></p>';
?>
