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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

        // Step 1: Insert into the 'orders' table
        $userID = 1; // Replace with actual user ID if available
        $orderDate = date('Y-m-d H:i:s');

        $sqlOrder = "INSERT INTO orders (userID, orderDate) VALUES (?, ?)";
        $stmtOrder = $conn->prepare($sqlOrder);
        $stmtOrder->bind_param("is", $userID, $orderDate);
        $stmtOrder->execute();

        // Get the last inserted orderID
        $orderID = $conn->insert_id;

        // Step 2: Insert into 'orderItems' table for each product in the cart
        foreach ($_SESSION['cart'] as $item) {
            $productID = $item['id']; // Using the productID in the session cart
            $quantity = $item['quantity'];
            $price = $item['price'];
            $temperature = isset($item['temperature']) ? $item['temperature'] : '';

            $sqlOrderItems = "INSERT INTO orderItems (orderID, productID, quantity, price, temperature) 
                              VALUES (?, ?, ?, ?, ?)";
            $stmtOrderItems = $conn->prepare($sqlOrderItems);
            $stmtOrderItems->bind_param("iiids", $orderID, $productID, $quantity, $price, $temperature);
            $stmtOrderItems->execute();
        }

        // Clear the cart session
        $_SESSION['cart'] = array();

        // Redirect to success page
        header("Location: payment.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        .cart-container {
            width: 80%;
            margin: auto;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .cart-table th {
            background-color: #f4f4f4;
        }

        .cart-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .cart-actions {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
        }

        .cart-actions input[type="number"] {
            width: 60px;
            padding: 5px;
        }

        .cart-actions button {
            padding: 8px 12px;
            background-color: #004080;
            color: white;
            border: none;
            cursor: pointer;
        }

        .cart-actions button:hover {
            background-color: #002d66;
        }

        .cart-buttons {
            margin-top: 20px;
            text-align: center;
        }

        .cart-buttons button {
            padding: 10px 20px;
            background-color: #004080;
            color: white;
            border: none;
            cursor: pointer;
            margin: 5px;
        }

        .cart-buttons button:hover {
            background-color: #002d66;
        }

        .align-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    <h2>Your Cart</h2>

<div class="cart-container">
    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table class="cart-table">
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th> <!-- Added new Actions column -->
            </tr>
            <?php
            $totalPrice = 0;
            foreach ($_SESSION['cart'] as $key => $item):
                $itemTotal = $item['quantity'] * $item['price'];
                $totalPrice += $itemTotal;
            ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td><?php echo $itemTotal; ?></td>
                <td>
                    <!-- Quantity input for update -->
                    <form action="update_cart.php" method="POST" class="inline-form">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <input type="number" name="new_quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;">
                </td>
                
                <td>
                    <!-- Actions for update and remove -->
                    <div class="cart-actions">
                        <button type="submit">Update</button>
                    </form> <!-- Form closing tag moved here -->

                    <!-- Remove From Cart Form -->
                    <form action="remove_from_cart.php" method="POST" class="inline-form">
                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                        <button type="submit">Remove</button>
                    </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- Cart Buttons -->
        <div class="cart-buttons">
            <form action="checkout.php" method="POST">
                <button type="submit">Proceed to Checkout</button>
            </form>
            <button onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>

    <?php else: ?>
        <p>Your cart is empty.</p>
        <button onclick="window.location.href='index.php'">Continue Shopping</button>
    <?php endif; ?>
</div>

</body>

</html>

