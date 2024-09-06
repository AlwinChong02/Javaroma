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

// Get the search query from the URL
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Fetch products that match the search query
$sqlProducts = "SELECT productID, productName, productDescription, imagePath, productCategory, ingredients, price 
                FROM product 
                WHERE productName LIKE '%$searchQuery%'";
$resultProducts = $conn->query($sqlProducts);

// Generate the HTML for the filtered products
if ($resultProducts->num_rows > 0) {
    while ($product = $resultProducts->fetch_assoc()) {
        echo '<div class="product-item" onclick="openModal(\'' . basename($product['imagePath']) . '\', \'' . addslashes($product['productName']) . '\', \'' . addslashes($product['productDescription']) . '\', \'' . addslashes($product['ingredients']) . '\', \'' . addslashes($product['price']) . '\', \'' . addslashes($product['productID']) . '\')">';
        echo '<img src="../images/drinks/' . basename($product['imagePath']) . '" alt="' . $product['productName'] . '">';
        echo '<div class="product-name">' . $product['productName'] . '</div>';
        echo '<div class="temperature-icons">';

        // Display icons based on product category
        if ($product['productCategory'] == 'Frappé') {
            echo '<img src="../images/cold.png" alt="Cold Icon">';
        } else {
            echo '<img src="../images/hot.png" alt="Hot Icon">';
            echo '<img src="../images/cold.png" alt="Cold Icon">';
        }

        echo '</div>'; // Close temperature-icons
        echo '</div>'; // Close product-item
    }
} else {
    echo "No products found.";
}

$conn->close();
?>