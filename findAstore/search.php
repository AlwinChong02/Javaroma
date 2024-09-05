<?php
include('header.php');
include('../includes/navigationList.php')
    ?>

<!DOCTYPE html>
<html>

<head>
    <title>Search a store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../WebStyle/mystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="article-container">
        <?php
        if (isset($_POST['submit-search'])) {
            $search = mysqli_real_escape_string($conn, $_POST['search']);

            // Check if search input is empty
            if (empty($search)) {
                // Redirect back to the main page or perform any action you like
                header("Location: index.php");
                exit();
            } else {
                // Execute the search query
                $sql = "SELECT * FROM store WHERE area LIKE '%$search%' OR details LIKE '%$search%'";
                $result = mysqli_query($conn, $sql);
                $queryResults = mysqli_num_rows($result);

                // Check if any results are found
                if ($queryResults > 0) {
                    echo "<div class='map'>
                    <img src='../images/map.png' alt='mapJavaRoma'>
                  </div>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='article-box'>
                        <h3>" . $row['name'] . "</h3>
                        <p>" . $row['area'] . "</p>
                        <p>" . $row['details'] . "</p>
                        <img src='" . ($row['images']) . "' alt='Store Image'>
                      </div>";
                    }
                } else {
                    // No results found, display a message
                    header("Location: index.php");
                    exit();
                }
            }
        }
        ?>
    </div>

    <?php
    include('../includes/footerPolicy.php');
    ?>
</body>

</html>