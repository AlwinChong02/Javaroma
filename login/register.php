<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <div class="container">
        <div class="left">
            <div class="illustration">
                <img src="illustration.png" alt="Illustration">
            </div>
        </div>
        <div class="right">
            <div class="login-box">
                <h1>Register</h1>
                <p>Have existing account? <a href="login.php">Login now!</a></p>

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
                </form>
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
    if($_SERVER["REQUEST_METHOD"] === "POST") {
        // session_destroy();

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            echo "Please fill in all fields";
            exit();
        }

        //md5 password
        $password = md5($password);

        //prepare and bind 
        $sql = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $name, $email, $password);
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
    }

    ?>

            </div>
        </div>
    </div>

    <script src='userValidation.js'></script>
</body>

</html>