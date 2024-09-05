<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <h1> Register Now to get amazing benefits!</h1>
    <div class="left">
        <div class="illustration">
            <img src="illustration.png" alt="Illustration">
        </div>
    </div>
    <form id="register-form" action="register.php" method="post" onsubmit="validateForm()">
        <div class="input-box">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
        </div>
        <div class="input-box">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email">
        </div>
        <div class="input-box">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit" onsubmit="validateForm()" class="login-btn">Register</button>

        <script src='userValidation.js'></script>
    </form>
    <div>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script src='userValidation.js'></script>
    <?php
    $servername = "localhost";
    $serverUsername = "root";
    $serverPassword = "";
    $dbname = "javaroma_db";

    //check conncection
    $conn = new mysqli($servername, $serverUsername, $serverPassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        echo "Connected successfully<br>";
    }

    //get data from form 
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    //hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // prepare and bind 
    $sql = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $name, $email, $hashedPassword);
    $sql->execute();

    if ($sql->affected_rows > 0) {
        //display pop up dialog
        echo "<script>alert('Registration successful')</script>";


        //back to login page
        echo "<a href='login.php'>Login</a>";
    } else {
        echo "Registration failed";
    }

    $conn->close();

    ?>
</body>

</html>