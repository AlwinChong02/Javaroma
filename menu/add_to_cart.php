<?php
session_start();

// Fetch the data sent from the JavaScript function
$data = json_decode(file_get_contents('php://input'), true);
$productID = $data['productID'];
$productName = $data['productName'];
$quantity = $data['quantity'];
$price = $data['price'];

// Create an item array
$item = array(
    'ID' => &$productID,
    'name' => $productName,
    'quantity' => $quantity,
    'price' => $price
);

// Check if the cart session exists, if not create it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if the product is already in the cart, update quantity if so
$found = false;
foreach ($_SESSION['cart'] as &$cartItem) {
    if ($cartItem['ID'] == $productID) {
        $cartItem['quantity'] += $quantity;
        $found = true;
        break;
    }
}

if (!$found) {
    // If product is not in the cart, add new item
    $_SESSION['cart'][] = $item;
}

// Send response back to client
echo json_encode(array('message' => 'Product added to cart successfully!'));
