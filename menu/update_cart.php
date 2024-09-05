<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_name'];
    $newQuantity = $_POST['new_quantity'];

    // Loop through the cart to find the product and update its quantity
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['name'] == $productName) {
            $cartItem['quantity'] = $newQuantity;
            break;
        }
    }

    // Redirect back to cart page
    header('Location: cart.php');
    exit();
}
?>