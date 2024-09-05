<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <h1> Login Now to get amazing benefits!</h1>
    <form action="login.php" method="post" onsubmit="validateForm()">
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <br>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <br>
        <input type="submit" value="Login">
    </form>
    <script src='userValidation.js'></script>
    <?php
        $servername = "localhost";
        $serverUsername = "root";
        $serverPassword = "";
        $dbname = "javaroma";
        
        // Check connection
        $conn = new mysqli($servername, $serverUsername, $serverPassword, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);       
        } else {
            echo "Connected successfully<br>";
        }

        // Get data from form 
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Prepare SQL statement
        $sql = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $sql->bind_param("s", $email);
        $sql->execute();

        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            // Verify password
            if (password_hash($password, PASSWORD_BCRYPT) == $hashedPassword) {
                echo "Login successful";
            } else {
                echo "Login failed: Invalid password";
            }
        } else {
            echo "Login failed: User not found";
        }

        $conn->close();
    ?> 
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>

</html>
