<?php
session_start();

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

// Get selected category from URL or show all if none is selected
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'All';

// Fetch all product categories
$sqlCategories = "SELECT DISTINCT productCategory FROM product";
$resultCategories = $conn->query($sqlCategories);

// Fetch products based on the selected category
if ($selectedCategory == 'All') {
    $sqlProducts = "SELECT productID, productName, productDescription, imagePath, productCategory, ingredients, price FROM product";
} else {
    $sqlProducts = "SELECT productID, productName, productDescription, imagePath, productCategory, ingredients, price FROM product WHERE productCategory = '$selectedCategory'";
}

$resultProducts = $conn->query($sqlProducts);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../WebStyle/mystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            display: flex;
            margin-top: 140px;
            padding-left: 50px;
        }

        .sidebar {
            width: 200px;
            padding: 20px;
            height: 100vh;
            margin-right: 30px;
            margin-top: 60px;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #004080;
        }

        .sidebar .navigation-item {
            margin-bottom: 15px;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            font-weight: bold;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            margin-right: 50px;
            animation: fade-up 1.0s ease forwards;
        }

        #drinks-title {
            font-size: 36px;
            color: #004080;
            margin-bottom: 8px;
            text-align: left;
            margin-top: 0;
        }

        .product-gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .product-item {
            background-color: #FFF;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            height: 100%;
            cursor: pointer;
        }

        .product-item img {
            max-width: 180px;
            max-height: 230px;
            margin: 0 auto;
            display: block;
            border-radius: 10px;
        }

        .product-name {
            margin-top: 25px;
            font-size: 16px;
            font-weight: bold;
            position: relative;
        }

        .product-name::after {
            content: '';
            display: block;
            width: 100%;
            height: 1px;
            background-color: #ccc;
            margin-top: 50px;
            position: absolute;
            bottom: -60px;
            left: 0;
        }

        .temperature-icons {
            margin-top: 75px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .temperature-icons img {
            width: 20px;
            height: auto;
        }

        h3 {
            font-size: 25px;
            color: #004080;
            margin: 10px;
        }

        h1 {
            font-size: 60px;
            color: #004080;
            margin: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 150px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            position: relative;
            text-align: center;
            animation: fade-up 0.5s ease forwards;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header img {
            max-width: 150px;
            margin: 0 auto;
            display: block;
        }

        .modal-title {
            font-size: 28px;
            margin-top: 20px;
            font-weight: bold;
        }

        .modal-description {
            margin-top: 15px;
            padding: 15px;
            background-color: #f4f8fc;
            border-radius: 8px;
            text-align: center;
            font-size: 12px;
        }

        .modal-ingredients {
            margin-left: 40px;
            margin-top: 20px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .modal-ingredients div {
            width: 45%;
        }

        .modal-ingredients h4 {
            text-decoration: underline;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .modal-ingredients ul {
            list-style-type: none;
            padding: 0;
        }

        .modal-ingredients ul li {
            margin-bottom: 5px;
        }

        .modal-quantity {
            margin-top: 20px;
        }

        .modal-quantity label {
            font-size: 14px;
            margin-right: 10px;
        }

        .modal-quantity input {
            font-size: 18px;
        }

        .modal-cart {
            margin-top: 20px;
        }

        .modal-cart button {
            background-color: #004080;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        .modal-cart button:hover {
            background-color: #002d66;
        }

        .search-container {
            margin-bottom: 30px;
        }

        #searchInput {
            width: 100%;
            max-width: 500px;
            padding: 15px 20px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);/ transition: box-shadow 0.3s ease;
        }

        #searchInput:focus {
            outline: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border-color: #004080;
        }
    </style>
</head>

<body>
    <div class="navigation">
        <?php include('../includes/navigationList.php'); ?>
    </div>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>DRINKS</h2>
            <div class="navigation-item">
                <a href="?category=All">All</a>
            </div>
            <?php
            if ($resultCategories->num_rows > 0) {
                while ($category = $resultCategories->fetch_assoc()) {
                    echo '<div class="navigation-item">';
                    echo '<a href="?category=' . urlencode($category['productCategory']) . '">' . $category['productCategory'] . '</a>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Drinks Heading -->
            <h2 id="drinks-title">Drinks</h2>

            <!-- Search Bar -->
            <div class="search-container">
                <form id="searchForm" onsubmit="return false;">
                    <input type="text" id="searchInput" placeholder="Search drinks..." onkeyup="searchProducts()">
                </form>
            </div>

            <!-- Product Gallery -->
            <div id="productGallery" class="product-gallery">
                <?php
                if ($resultProducts->num_rows > 0) {
                    while ($product = $resultProducts->fetch_assoc()) {
                        echo '<div class="product-item" onclick="openModal(\'' . basename($product['imagePath']) . '\', \'' . addslashes($product['productName']) . '\', \'' . addslashes($product['productDescription']) . '\', \'' . addslashes($product['ingredients']) . '\', \'' . addslashes($product['price']) . '\', \'' . addslashes($product['productID']) . '\', \'' . addslashes($product['productCategory']) . '\')">';
                        echo '<img src="../images/drinks/' . basename($product['imagePath']) . '" alt="' . $product['productName'] . '">';
                        echo '<div class="product-name">' . $product['productName'] . '</div>';
                        echo '<div class="temperature-icons">';

                        if ($product['productCategory'] == 'Frappé') {
                            echo '<img src="../images/cold.png" alt="Cold Icon">';
                        } else {
                            echo '<img src="../images/hot.png" alt="Hot Icon">';
                            echo '<img src="../images/cold.png" alt="Cold Icon">';
                        }

                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No products found.";
                }
                ?>
            </div>
        </div>


        <!-- The Modal -->
        <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <div class="modal-header">
                    <img id="modalImage" src="" alt="Product Image">
                </div>
                <input type="hidden" id="productID" name="productID" value="">
                <input type="hidden" id="productCategory" name="productCategory" value="">
                <div class="modal-title" id="modalTitle">Product Name</div>
                <div class="modal-description" id="modalDescription">Product Description</div>
                <div class="modal-ingredients">
                    <div>
                        <h4>Ingredients</h4>
                        <ul id="modalIngredients"></ul>
                    </div>
                    <div>
                        <h4>Price</h4>
                        <ul id="modalPrice"></ul>
                    </div>
                </div>
                <div class="modal-quantity">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1"
                        style="width: 60px; text-align: center;">
                </div>
                <div class="modal-cart">
                    <button onclick="addToCart()">Add to Cart</button>
                </div>
            </div>
        </div>

        <script>
            function addToCart() {
                const productID = document.getElementById('productID').value;
                const productCategory = document.getElementById('productCategory').value;
                const quantity = document.getElementById('quantity').value;
                const productName = document.getElementById('modalTitle').innerText;
                const price = document.getElementById('modalPrice').innerText;

                fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        productID: productID,
                        productCategory: productCategory,
                        productName: productName,
                        quantity: quantity,
                        price: price
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => console.error('Error:', error));
            }

            function openModal(image, title, description, ingredients, price, productID, productCategory) {
                document.getElementById("productID").value = productID;
                document.getElementById("productCategory").value = productCategory;
                document.getElementById("modalImage").src = "../images/drinks/" + image;
                document.getElementById("modalTitle").innerText = title;
                document.getElementById("modalDescription").innerText = description;

                let o

                // Fill ingredients list
                let ingredientsArray = ingredients.split(',');
                let ingredientsList = document.getElementById("modalIngredients");
                ingredientsList.innerHTML = '';
                ingredientsArray.forEach(function (ingredient) {
                    let li = document.createElement("li");
                    li.innerText = ingredient;
                    ingredientsList.appendChild(li);
                });

                // Fill price
                let priceList = document.getElementById("modalPrice");
                priceList.innerHTML = '';
                let li = document.createElement("li");
                li.innerText = price;
                priceList.appendChild(li);

                document.getElementById("productModal").style.display = "block";
            }

            function closeModal() {
                document.getElementById("productModal").style.display = "none";
            }

            function searchProducts() {
                let searchQuery = document.getElementById('searchInput').value;

                // Create an AJAX request
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // Update the product gallery with the filtered results
                        document.getElementById("productGallery").innerHTML = this.responseText;
                    }
                };

                // Send the request to searchProducts.php with the search query
                xhttp.open("GET", "searchProducts.php?query=" + encodeURIComponent(searchQuery), true);
                xhttp.send();
            }


        </script>
    </div>
    <?php include('../includes/footerPolicy.php'); ?>
</body>


</html>