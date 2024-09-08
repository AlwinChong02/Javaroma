<?php
session_start();
$servername = "localhost";
$serverUsername = "root";
$serverPassword = "";
$dbname = "javaroma_db";

//check conncection
$conn = new mysqli($servername, $serverUsername, $serverPassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION["userID"];
} else {
    die("Error: User not logged in. Please log in to view your profile.");
}

//get data from form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $newPassword = $_POST['password'] ?? '';

    $newPassword = md5($newPassword);


    //get userID from cookie
    $userID = $_COOKIE['userID'];

    //update query
    $sql = $conn->prepare("UPDATE users SET username=?, email=?, password=? WHERE userID=?");
    $sql->bind_param("sssi", $name, $email, $newPassword, $userID);
    $sql->execute();

    if ($sql->affected_rows <= 0) {
        echo "Failed to update user: " . $conn->error;
    } else {
        // show a dialog box to inform user that the data has been updated
        //reset cookies
        setcookie('username', $name, time() + (86400 * 30), "/");
        setcookie('email', $email, time() + (86400 * 30), "/");
        setcookie('password', $newPassword, time() + (86400 * 30), "/");

        echo "<script>alert('Your user information has been updated');</script>";
    }

}
?>

<!DOCTYPE html>
<html>
<>
    <meta charset='utf-8'>
    <title>User Profile</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../WebStyle/mystyle.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='profile.css'>
    <link rel="icon" type="image/png" href="../images/Javaromalogo.png">
    <style>
        h1 {
            margin-top: 120px;
        }
    </style>
    </head>

    <body>
        <?php include('../includes/navigationList.php'); ?>
        <h1>Update User Profile</h1>
        <!-- mystlye.css with profile.css -->
        <form id='form-profile' action='profile.php' method='post' onsubmit='return validateForm()'>

            <div>
                <label for='name'>Name:</label>
                <input type='text' name='name' id='name'>
            </div>
            <div>
                <label for='email'>Email:</label>
                <input type='text' name='email' id='email'>
            </div>
            <div>
                <label for='password'>Password:</label>
                <input type='password' name='password' id='password'>
            </div>
            <button type='submit' class='save-btn'>Save Changes</button>
        </form>
        <script src='userValidation.js'></script>

        <?php include('../includes/footerPolicy.php'); ?>
    </body>

</html>