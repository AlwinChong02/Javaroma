<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javaroma_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO feedback (name, email, messages) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $messages);

if ($stmt->execute()) {
    echo "New record has been added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!-- <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javaroma_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO feedback (name, email, area, details) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $area, $details);

if ($stmt->execute()) {
    echo "New record has been added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?> -->
