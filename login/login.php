<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
                <h2>Sign in</h2>
                <p>Don't have an account? <a href="register.php">Register here!</a></p>
                <form id="login-form" action="login.php" method="post" onsubmit="validateForm()">
                    <div class=" input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address">
                    </div>
                    <div class="input-box">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your Password">
                    </div>
                    <div class="remember-me">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="login-btn">Login</button>
                </form>

                <script src="userValidation.js"></script>

                <?php
                $servername = "localhost";
                $serverUsername = "root";
                $serverPassword = "";
                $dbname = "javaroma_db";

                // Check connection
                $conn = new mysqli($servername, $serverUsername, $serverPassword, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } else {
                    echo "Connected successfully<br>";
                }

                // Get data from form 
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $email = $_POST['email'] ?? '';
                    $password = $_POST['password'] ?? '';


                    // Prepare SQL statement
                    $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
                    $sql->bind_param("s", $email);
                    $sql->execute();

                    $result = $sql->get_result();
                    echo "Number of rows: " . $result->num_rows . "<br>";
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $hashedPassword = $row['password'];
                        // echo "Hashed password: " . $hashedPassword . "<br>";

                        // Verify password
                        if ($hashedPassword === md5($password)) {

                            echo "Login successful";
                            session_start();

                            $_SESSION["userID"] = $row['userID']; 
                            $_SESSION["username"] = $row['username'];
                            $_SESSION["email"] = $email;
                            $_SESSION["password"] = $password;

                            // Set cookies
                            setcookie("userID", $row['userID'], time() + 86400, "/", "localhost", true);
                            setcookie("username", $row['username'], time() + 86400, "/", "localhost", true);
                            setcookie("email", $email, time() + 86400, "/", "localhost", true);
                            setcookie("password", $hashedPassword, time() + 86400, "/", "localhost", true);
                            header("Location: ../index.php");
                            exit();
                        } else {
                            echo "Login failed: Invalid password";
                            
                        }
                    } else {
                        echo "Login failed: User not found";
                    }
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
