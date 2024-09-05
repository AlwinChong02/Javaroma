<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO conference (name, email, area, details) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $area, $details);

if ($stmt->execute()) {
    echo "New record has been added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conf_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO conference (name, email, area, details) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $area, $details);

if ($stmt->execute()) {
    echo "New record has been added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
