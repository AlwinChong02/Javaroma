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

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION["userID"];
} else {
    die("Error: User not logged in. Please log in to add products.");
}

// Handle Proceed to Checkout action
if (isset($_POST['checkout'])) {
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

        // Calculate total price of the order
        $totalPrice = 0;
        foreach ($_SESSION['cart'] as &$item) {
            $itemTotal = $item['quantity'] * $item['price'];
            $totalPrice += $itemTotal;
        }
        $orderDate = date('Y-m-d H:i:s');

        // Modify the INSERT statement to include totalAmount
        $sqlOrder = "INSERT INTO orders (userID, orderDate, totalAmount) VALUES (?, ?, ?)";
        $stmtOrder = $conn->prepare($sqlOrder);

        if (!$stmtOrder) {
            die("Order preparation failed: " . $conn->error);
        }

        // Adjust the parameter types and values
        $stmtOrder->bind_param("isd", $userID, $orderDate, $totalPrice);
        $stmtOrder->execute();

        if ($stmtOrder->affected_rows <= 0) {
            die("Failed to insert order: " . $stmtOrder->error);
        }

        // Get the last inserted orderID
        $orderID = $conn->insert_id;

       
        // Step 2: Insert into 'orderItems' table for each product in the cart
        foreach ($_SESSION['cart'] as &$item) {
            // Set the selected temperature in the session for each item
            $item['temperature'] = $_POST['temperature'][$item['id']] ?? '';  // Retrieve the temperature from the form

            // Now save to the database
            $productID = $item['id'];
            $category = $item['category'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $temperature = $item['temperature'];  // Get the selected temperature

            $sqlOrderItems = "INSERT INTO orderItems (orderID, productID, quantity, price, temperature) 
                              VALUES (?, ?, ?, ?, ?)";
            $stmtOrderItems = $conn->prepare($sqlOrderItems);

            if (!$stmtOrderItems) {
                die("OrderItems preparation failed: " . $conn->error);
            }

            $stmtOrderItems->bind_param("iiids", $orderID, $productID, $quantity, $price, $temperature);
            $stmtOrderItems->execute();

            if ($stmtOrderItems->affected_rows <= 0) {
                die("Failed to insert order item: " . $stmtOrderItems->error);
            }
        }

        // Clear the cart session
        $_SESSION['cart'] = array();

        // Redirect to payment page
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../WebStyle/mystyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Cart</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #353432;
            margin-bottom: 20px;
            font-size: 28px;
            letter-spacing: 1px;
        }

        .cart-table {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .cart-table th,
        .cart-table td {
            padding: 15px;
            text-align: center;
        }

        .cart-table th {
            background-color: #353432;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        .cart-table td {
            color: #333;
            font-size: 14px;
            border-bottom: 1px solid #eee;
        }

        .cart-table tr:last-child td {
            border-bottom: none;
        }

        .cart-table td img {
            max-width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        /* Table row hover effect */
        .cart-table tr:hover {
            background-color: #f9f9f9;
        }

        .cart-buttons {
            margin-top: 30px;
            text-align: center;
        }

        .cart-buttons button {
            padding: 8px 15px;
            background-color: #353432;
            color: #eee;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .cart-buttons button:hover {
            background-color: #555;
        }

        .cart-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        form {
            margin: 0;
            padding: 0;
        }


        .quantity-input {
            width: 50px;
            padding: 5px;
            text-align: center;
        }

        /* Total Price row */
        .cart-table tr:last-child {
            font-weight: bold;
            background-color: #f2f2f2;
            color: #353432;
        }

        /* Select box styling */
        select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
            width: 80px;
        }

        #fff{
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Your Cart</h2>

    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table class="cart-table">
            <tr>
                <th>Product Name</th>
                <th>Temperature</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php
            $totalPrice = 0;
            foreach ($_SESSION['cart'] as $key => $item):
                $itemTotal = $item['quantity'] * $item['price'];
                $totalPrice += $itemTotal;

                $isFrappe = (isset($item['category']) && $item['category'] == 'Frappé');
                ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>
                        <select name="temperature[<?php echo $item['id']; ?>]" required form="checkout-form">
                            <option value="" disabled selected hidden>Hot/Cold</option>
                            <option value="Hot" <?php if ($item['temperature'] == 'Hot') echo 'selected'; ?> <?php if ($isFrappe) echo 'disabled'; ?>>Hot</option>
                            <option value="Cold" <?php if ($item['temperature'] == 'Cold' || $isFrappe)
                                echo 'selected'; ?>>Cold</option>
                        </select>
                        <?php if ($isFrappe): ?>
                            <p style="color:red;">Frappe drinks are only available cold.</p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Quantity input -->
                        <form action="update_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="number" class="quantity-input" name="new_quantity" value="<?php echo $item['quantity']; ?>" min="1">

                            <div class="cart-actions">
                                <!-- Update cart form -->
                                <button type="submit">Update</button>
                        </form>

                        <!-- Remove from cart form -->
                        <form action="remove_from_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <button type="submit">Remove</button>
                        </form>
                        </div>
                        </div>
                    </td>
                    <td>RM <?php echo $item['price']; ?></td>
                    <td>RM <?php echo number_format($itemTotal, 2); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3">Total Price</td>
                <td colspan="2">RM <?php echo number_format($totalPrice, 2); ?></td>
            </tr>
        </table>

        <div class="cart-buttons">

            <form action="cart.php" method="POST" id="checkout-form">
                <button id="fff" type="submit" name="checkout">Proceed to Checkout</button>
            </form>

            <button i="fff" type="button" onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>
    <?php else: ?>
        <h2>Your cart is empty.</h2>
        <div class="cart-buttons">
        <button onclick="window.location.href='index.php'">Continue Shopping</button></div>
    <?php endif; ?>
</body>

</html>