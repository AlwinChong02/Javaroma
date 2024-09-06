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
$orderQuery = "SELECT o.orderID, o.userID, o.totalAmount, o.orderDate, oi.quantity, oi.temperature, p.productID, p.productName, p.imagePath, p.price
FROM orders o
JOIN orderItems oi ON o.orderID = oi.orderID
JOIN product p ON oi.productID = p.productID
WHERE o.userID = ?";

$stmtOrder = $conn->prepare($orderQuery);
$stmtOrder->bind_param("i", $userID);
$stmtOrder->execute();
$orderResult = $stmtOrder->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../WebStyle/mystyle.css'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: antiquewhite;
            color: #333;
            line-height: 1.6;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #444;
            margin-bottom: 20px;
            margin-top: 130px;
        }

        .order-history-table {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .order-history-table th,
        .order-history-table td {
            padding: 16px;
            text-align: center;
            font-size: 16px;
        }

        .order-history-table th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .order-history-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .order-history-table tr:hover {
            background-color: #f1f1f1;
        }

        .order-items {
            background-color: #fafafa;
            padding-left: 20px;
            display: none;
        }

        .product-image {
            max-width: 100px;
            max-height: 120px;
            border-radius: 5px;
        }

        .view-items-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .view-items-btn:hover {
            background-color: #45a049;
        }

        /* Container for order item list */
        .order-items ul {
            list-style: none;
            padding-left: 0;
        }

        .order-items ul li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
        }

        .order-items ul li:last-child {
            border-bottom: none;
        }

        .order-items .product-name {
            font-weight: bold;
            margin-left: 15px;
        }

        .order-items .product-details {
            flex-grow: 1;
            text-align: left;
        }

        .order-items .product-price {
            text-align: right;
            margin-left: 15px;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <?php include('../includes/navigationList.php'); ?>
    <h2>Payment History</h2>

    <table class="order-history-table">
        <tr>
            <th>Order ID</th>
            <th>Total Amount (RM)</th>
            <th>Order Date</th>
            <th>Details</th>
        </tr>
        <?php
        if ($orderResult->num_rows > 0) {
            $currentOrderID = 0;

            // Loop through each result and group items by order
            while ($orders = $orderResult->fetch_assoc()) {

                // Check if we're still on the same order or if it's a new one
                if ($currentOrderID != $orders['orderID']) {
                    if ($currentOrderID != 0) {
                        // Close previous order's product listing
                        echo "</ul></td></tr>";
                    }

                    // Start a new order
                    $currentOrderID = $orders['orderID'];
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($orders['orderID']) . "</td>";
                    echo "<td>RM " . number_format($orders['totalAmount'], 2) . "</td>";
                    echo "<td>" . htmlspecialchars($orders['orderDate']) . "</td>";
                    echo '<td><button class="view-items-btn" onclick="toggleDetails(' . $orders['orderID'] . ')">View Items</button></td>';
                    echo "</tr>";

                    // Start product listing for this order
                    echo '<tr class="order-items" id="order-items-' . $orders['orderID'] . '">';
                    echo '<td colspan="4"><ul>';
                }

                // Display product details for each order item
                echo "<li>";
                echo '<img class="product-image" src="' . htmlspecialchars($orders['imagePath']) . '" alt="Product Image">';
                echo '<div class="product-details">';
                echo "<span class='product-name'>" . htmlspecialchars($orders['productName']) . "</span>";
                echo "<span> | Quantity: " . $orders['quantity'] . "</span>";
                echo "<span> | Temperature: " . htmlspecialchars($orders['temperature']) . "</span>";
                echo "</div>";
                echo "<div class='product-price'>RM " . number_format($orders['price'], 2) . "</div>";
                echo "</li>";
            }

            // Close the final order's product listing
            echo "</ul></td></tr>";

        } else {
            echo "<tr><td colspan='4'>No orders found</td></tr>";
        }
        ?>

    </table>

    <script>
        function toggleDetails(orderID) {
            var row = document.getElementById('order-items-' + orderID);
            if (row.style.display === 'none' || row.style.display === '') {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    </script>
    <?php include('../includes/footerPolicy.php'); ?>
</body>
</html>
