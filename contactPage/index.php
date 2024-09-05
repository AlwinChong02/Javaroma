<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javaroma_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = mysqli_real_escape_string($conn, $_POST['userID']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $ratings = mysqli_real_escape_string($conn, $_POST['ratings']);
    $date = date('Y-m-d'); // Automatically sets today's date

    // Insert query
    $sql = "INSERT INTO feedback (userID, description, ratings, date) VALUES ('$123', '$description', '$ratings', '$date')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Feedback submitted successfully!'); window.location.href = '../index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../WebStyle/mystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../images/contactBackgrounds.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(67, 71, 77, 0.85);
            z-index: -1;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin-top: 130px;
        }

        .col-1 {
            width: 50%;
            padding: 20px;
        }

        .col-2 {
            width: 50%;
            padding: 5px;
        }

        .col-2 {
            background-color: #f9f9f9;
            border-radius: 10px;
            justify-content: center;
            align-items: center;
            display: flex;  
        }

        h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            color: #01bdd4;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 16px;
            color: #666;
        }

        .contact-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .iconContainer {
            background-color: #01bdd4;
            color: white;
            padding: 10px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .icon {
            width: 40px;
        }

        #form-container {
            color: #333;
            width: 100%;
        }

        .form-row {
            margin-bottom: 20px;
        }

        .form-row label {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .form-field, .ratings-select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            font-size: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #01bdd4;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #018fb2;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 30px;
            }

            .col-1, .col-2 {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <div id="overlay"></div>
    <?php include('../includes/navigationList.php'); ?>
    <div class="container">
        <div class="col-1">
            <h1>Contact Details</h1>
            <div class="contact-info">
                <div class="iconContainer">
                    <img alt="location" src="../images/location_icon.webp" class="icon">
                </div>
                <div>
                    <h2>Address</h2>
                    <h3>No 20, Ground Floor, Jalan SL 1/4,<br> Bandar Sungai Long, 43000 Kajang, Selangor</h3>
                </div>
            </div>
            <div class="contact-info">
                <div class="iconContainer">
                    <img alt="phone" src="../images/phone_icon.png" class="icon">
                </div>
                <div>
                    <h2>Phone</h2>
                    <h3>03-76098836</h3>
                </div>
            </div>
            <div class="contact-info">
                <div class="iconContainer">
                    <img alt="email" src="../images/mail_icon.png" class="icon">
                </div>
                <div>
                    <h2>Email</h2>
                    <h3>javaroma@gmail.com</h3>
                </div>
            </div>
        </div>

        <div class="col-2">
            <form method="POST" action="">
                <div id="form-container">
                    <h2>Submit Your Feedback</h2>
                    <div class="form-row">
                        <label for="description">Feedback Description</label>
                        <textarea id="description" name="description" class="form-field" placeholder="Write your feedback here..." required></textarea>
                    </div>
                    <div class="form-row">
                        <label for="ratings">Ratings (1-5)</label>
                        <select id="ratings" name="ratings" class="ratings-select" required>
                            <option value="" disabled selected>Select your rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Fair</option>
                            <option value="3">3 - Good</option>
                            <option value="4">4 - Very Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                    <input type="submit" class="submit-btn" value="Submit">
                </div>
            </form>
        </div>
    </div>
</body>

</html>
