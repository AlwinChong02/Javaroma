<?php
session_start();
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

        .cart-table th, .cart-table td {
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
            <button onclick="window.location.href='payment.php'">Proceed to Checkout</button>
            <button onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>
    <?php else: ?>
        <p>Your cart is empty.</p>
        <button onclick="window.location.href='index.php'">Continue Shopping</button>
    <?php endif; ?>
</body>
</html>
