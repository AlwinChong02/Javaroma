<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="../../styles/login.css">
</head>

<body>
    <h1> Register Now to get amazing benefits!</h1>
    <form action="register.php" method="post" onsubmit="validateForm()">
    <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
        </div>
        <br>
        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email">
        </div>
        <br>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <br>
        <input type="submit" value="Register">
    </form>
     <div><p>Already have an account? <a href="login.php">Login here</a></p></div>

    <script src='userValidation.js'></script>
    <?php
        $servername = "localhost";
        $serverUsername = "root";
        $serverPassword = "";
        $dbname = "javaroma";
        
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
        $sql->bind_param("sss",$name, $email, $hashedPassword);
        $sql->execute();

        if ($sql->affected_rows > 0) {
            echo "Registration successful";
            echo "<br>";
            //back to login page
            echo "<a href='login.php'>Login</a>";
              } else {
            echo "Registration failed";
        }

        $conn->close();

        ?>
</body>
</html>