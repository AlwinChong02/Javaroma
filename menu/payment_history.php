<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javaroma_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Fetch all payment history
$sql = "SELECT product_name, quantity, price, total_price, checkout_date FROM payment_history ORDER BY checkout_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <style>
        .history-table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }

        .history-table th, .history-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .history-table th {
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
    <h2>Payment History</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="history-table">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td><?php echo $row['checkout_date']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="cart-buttons">
            <button onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>
    <?php else: ?>
        <p>No payment history found.</p>
        <button onclick="window.location.href='index.php'">Continue Shopping</button>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close(); // Close the connection
?>
