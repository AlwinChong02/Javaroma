<?php
session_start();

// Fetch the data sent from the JavaScript function
$data = json_decode(file_get_contents('php://input'), true);
$productID = $data['productID'];  // Get productID
$productName = $data['productName'];
$quantity = $data['quantity'];
$price = $data['price'];

// Create an item array
$item = array(
    'id' => $productID,  // Add productID to the item
    'name' => $productName,
    'quantity' => $quantity,
    'price' => $price
);

// Check if the cart session exists, if not create it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if the product is already in the cart based on the productID, update quantity if so
$found = false;
foreach ($_SESSION['cart'] as &$cartItem) {
    if ($cartItem['id'] == $productID) {
        $cartItem['quantity'] += $quantity;
        $found = true;
        break;
    }
}

if (!$found) {
    // If the product is not in the cart, add new item
    $_SESSION['cart'][] = $item;
}

// Send response back to the client
echo json_encode(array('message' => 'Product added to cart successfully!'));
