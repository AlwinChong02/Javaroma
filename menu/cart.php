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
        $sqlOrder = "INSERT INTO orders (userID, orderDate) VALUES (123, NOW())";
        $stmtOrder = $conn->prepare($sqlOrder);
        $stmtOrder->bind_param("i", $userID);
        $stmtOrder->execute();

        // Get the last inserted orderID
        $orderID = $conn->insert_id;

        // Step 2: Insert into 'orderItems' table for each product in the cart
        foreach ($_SESSION['cart'] as $item) {
            $productID = $item['id']; // Assuming you have a product ID in your cart session
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
        header("Location: checkout_success.php");
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
        .cart-table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .cart-table th {
            background-color: #f4f4f4;
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
    </style>
</head>

<body>
    <h2>Your Cart</h2>

    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table class="cart-table">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php
            $totalPrice = 0;
            foreach ($_SESSION['cart'] as $key => $item):
                $itemTotal = $item['quantity'] * $item['price'];
                $totalPrice += $itemTotal;
            ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $itemTotal; ?></td>
                    <td>
                        <form action="update_cart.php" method="POST">
                            <input type="hidden" name="product_name" value="<?php echo $item['name']; ?>">
                            <input type="number" name="new_quantity" value="<?php echo $item['quantity']; ?>" min="1">
                            <button type="submit">Update</button>
                        </form>
                        <form action="remove_from_cart.php" method="POST">
                            <input type="hidden" name="product_name" value="<?php echo $item['name']; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3">Total Price</td>
                <td colspan="2"><?php echo $totalPrice; ?></td>
            </tr>
        </table>

        <div class="cart-buttons">
            <form action="payment.php" method="POST">
                <button type="submit">Proceed to Checkout</button>
            </form>
            <button onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <button onclick="window.location.href='index.php'">Continue Shopping</button>
    <?php endif; ?>
</body>

</html>