<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "javaroma_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION["userID"];
} else {
    die("Error: User not logged in. Please log in view your payment history.");
}

// Retrieve orders for the logged-in user
$orderQuery = "SELECT o.orderID, o.userID, o.totalAmount, o.orderDate, oi.orderItemsID, oi.quantity, oi.temperature, p.productID, p.productName, p.imagePath
FROM orders o
JOIN orderItems oi ON o.orderID = oi.orderID
JOIN product p ON oi.productID = p.productID
WHERE o.userID = $userID";

$orderResult = $conn->query($orderQuery);
$orders = $orderResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <style>
        .order-history-table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }

        .order-history-table th, .order-history-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .order-history-table th {
            background-color: #f4f4f4;
        }

        .order-items {
            background-color: #fafafa;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <h2>Payment History</h2>

    <table class="order-history-table">
        <tr>
            <th>Order ID</th>
            <th>Total Amount (RM)</th>
            <th>Order Date</th>
            <th>Details</th>
        </tr>
            <tr>
                <td><?php echo htmlspecialchars ($orders['orderID']); ?></td>
                <td><?php echo number_format($order['totalAmount'], 2); ?></td>
                <td><?php echo $orders['orderDate']; ?></td>
                <td>
                    <button onclick="toggleDetails(<?php echo $orders['orderID']; ?>)">View Items</button>
                </td>
            </tr>
            <tr class="order-items" id="order-items-<?php echo $orders['orderID']; ?>" style="display: none;">
                <td colspan="4">
                    <ul>
                        <?php
                        // Retrieve order items for this order
                        $sqlOrderItems = "SELECT * FROM orderItems WHERE orderID = ?";
                        $stmtOrderItems = $conn->prepare($sqlOrderItems);
                        $stmtOrderItems->bind_param("i", $order['orderID']);
                        $stmtOrderItems->execute();
                        $resultOrderItems = $stmtOrderItems->get_result();

                        while ($item = $resultOrderItems->fetch_assoc()) {
                            echo "<li>Product ID: " . $item['productID'] . " | Quantity: " . $item['quantity'] . " | Price: RM " . number_format($item['price'], 2) . " | Temperature: " . $item['temperature'] . "</li>";
                        }
                        ?>
                    </ul>
                </td>
            </tr>

    </table>

    <script>
        function toggleDetails(orderID) {
            var row = document.getElementById('order-items-' + orderID);
            if (row.style.display === 'none') {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    </script>
</body>
</html>
