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
            $item['temperature'] = $_POST['temperature'][$item['id']] ?? '';  // Retrieve the temperature from the form

            $productID = $item['id'];
            $category = $item['category'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $temperature = $item['temperature']; 

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

        // // Redirect to payment page
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
            background-color: antiquewhite;
            margin: 0;
            padding: 5px;
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

        #crudForm {
            margin: 0;
            padding: 0;
            background-color: white;
            box-shadow: 0px 0px 0px rgba(0, 0, 0, 0);
            width: 100%;
            max-width: 400px;
            text-align: center;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }

        #crudForm1 {
            padding: 0;
            margin: 0;
            width: auto;

            box-shadow: 0px 0px 0px rgba(0, 0, 0, 0);
            display: inline-block;
            background-color: antiquewhite;
        }

        #checkout-btn {
            padding: 10px 20px;
            width: auto;
        }


        .quantity-input {
            width: 50px;
            padding: 5px;
            text-align: center;
        }

        .cart-table tr:last-child {
            font-weight: bold;
            background-color: #f2f2f2;
            color: #353432;
        }

        select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
            width: 150px;
        }

        #btn-cart {
            padding: 15px 30px;
            background-color: #353432;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
            text-align: center;
        }

        #btn-cart:hover {
            background-color: #555;
        }

        .payment-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .payment-modal-content {
            background-color: white;
            padding: 40px;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .payment-modal-content h4 {
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .category {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 15px;
        }

        .category label {
            height: 145px;
            padding: 20px;
            box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            border-radius: 5px;
            position: relative;
        }

        .category label .imgName {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            flex-direction: column;
            gap: 10px;
        }

        .category img {
            width: 80px;
            height: auto;
        }

        #visa:checked~.category .visaMethod,
        #mastercard:checked~.category .mastercardMethod,
        #paypal:checked~.category .paypalMethod,
        #AMEX:checked~.category .amexMethod {
            box-shadow: 0px 0px 0px 1px #6064b6;
        }

        #visa:checked~.category .visaMethod .check,
        #mastercard:checked~.category .mastercardMethod .check,
        #paypal:checked~.category .paypalMethod .check,
        #AMEX:checked~.category .amexMethod .check {
            display: block;
        }

        .check {
            display: none;
            position: absolute;
            top: -4px;
            right: -4px;
        }

        .check i {
            font-size: 18px;
        }

        .payment-modal button {
            margin-top: 20px;
            width: 100%;
            background-color: #353432;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .payment-modal button:hover {
            background-color: #555;
        }
        input[type="radio"] {
    width: 16px;
    height: 16px;
    border: 2px solid #ddd;
    border-radius: 50%;
    outline: none;
    cursor: pointer;
    transition: border-color 0.3s ease-in-out;
}
    </style>
</head>

<body>
        <?php include('../includes/navigationList.php'); ?>
    <div class="bottomup" Style="margin-top:150px">
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
                        <form id="crudForm" action="update_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="number" class="quantity-input" name="new_quantity" value="<?php echo $item['quantity']; ?>" min="1">

                            <div class="cart-actions">
                                <button type="submit">Update</button>
                        </form>

                        <!-- Remove from cart form -->
                        <form id="crudForm" action="remove_from_cart.php" method="POST">
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
                <td colspan="3"></td>
                <td colspan="1">Total Price: </td>
                <td colspan="1">RM <?php echo number_format($totalPrice, 2); ?></td>
            </tr>
        </table>

        <div class="cart-buttons">

            <button id="continue-btn" class="btn-cart" type="button" onclick="window.location.href='index.php'">Continue Shopping</button>


            <button id="checkout-btn" class="btn-cart" type="submit" name="checkout">Proceed to Checkout</button>

        </div>
    <?php else: ?>
        <h2>Your cart is empty.</h2>
        <div class="cart-buttons">
            <button onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>
    <?php endif; ?>

    <div id="paymentModal" class="payment-modal">
        <div class="payment-modal-content">
            <h4>Select a <span style="color: #6064b6">Payment</span> method</h4>
            <form id="payment-form" action="cart.php" method="POST">
                <input type="radio" name="payment" id="visa" value="VISA">
                <input type="radio" name="payment" id="mastercard" value="Mastercard">
                <input type="radio" name="payment" id="paypal" value="Paypal">
                <input type="radio" name="payment" id="AMEX" value="AMEX">

                <div class="category">
                    <label for="visa" class="visaMethod">
                        <div class="imgName">
                            <div class="imgContainer visa">
                                <img src="https://i.ibb.co/vjQCN4y/Visa-Card.png" alt="">
                            </div>
                            <span class="name">VISA</span>
                        </div>
                        <span class="check"><i class="fa-solid fa-circle-check" style="color: #6064b6;"></i></span>
                    </label>

                    <label for="mastercard" class="mastercardMethod">
                        <div class="imgName">
                            <div class="imgContainer mastercard">
                                <img src="https://i.ibb.co/vdbBkgT/mastercard.jpg" alt="">
                            </div>
                            <span class="name">Mastercard</span>
                        </div>
                        <span class="check"><i class="fa-solid fa-circle-check" style="color: #6064b6;"></i></span>
                    </label>

                    <label for="paypal" class="paypalMethod">
                        <div class="imgName">
                            <div class="imgContainer paypal">
                                <img src="https://i.ibb.co/KVF3mr1/paypal.png" alt="">
                            </div>
                            <span class="name">Paypal</span>
                        </div>
                        <span class="check"><i class="fa-solid fa-circle-check" style="color: #6064b6;"></i></span>
                    </label>

                    <label for="AMEX" class="amexMethod">
                        <div class="imgName">
                            <div class="imgContainer AMEX">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/f/fb/Touch_%27n_Go_eWallet_logo.svg" alt="">
                            </div>
                            <span class="name">TNG Ewallet</span>
                        </div>
                        <span class="check"><i class="fa-solid fa-circle-check" style="color: #6064b6;"></i></span>
                    </label>
                </div>
                
                    <button class="btn-cart" type="submit" name="checkout">Confirm Payment</button>
                </form>
            </form>
        </div>
    </div>
</div>
    <script>
        // Show Payment Modal
        document.getElementById("checkout-btn").addEventListener("click", function() {
            document.getElementById("paymentModal").style.display = "flex";
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById("paymentModal")) {
                document.getElementById("paymentModal").style.display = "none";
            }
        }
    </script>
<div class="spacing" style="margin-top: 400px">
    <?php include('../includes/footerPolicy.php'); ?>
    </div>
    
</body>

</html>