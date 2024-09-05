<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">

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
                <h2>Sign in</h2>
                <p>Don't have an account? <a href="#">Register here!</a></p>
                <form>
                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="Enter your email address">
                    </div>
                    <div class="input-box">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter your Password">
                    </div>
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" onsubmit="validateForm()" class="login-btn">Login</button>
                </form>
                <script src="userValidation.js"></script>
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
                        setcookie("email", $email, time() + 86400, "/", "localhost", true);
                        setcookie("password", $password, time() + 86400, "/", "localhost", true);

                        header("Location: ../index.php");
                    } else {
                        echo "Login failed: Invalid password";
                    }
                } else {
                    echo "Login failed: User not found";
                }

                $conn->close();
                ?>

                <p>or continue with</p>
                <div class="social-login">
                    <button class="social-btn facebook">Facebook</button>
                    <button class="social-btn apple">Apple</button>
                    <button class="social-btn google">Google</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>