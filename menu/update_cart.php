<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productID = $_POST['product_id'];
    $newQuantity = $_POST['new_quantity'];

    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['id'] == $productID) { 
            $cartItem['quantity'] = $newQuantity;
            break;
        }
    }

    // Redirect back to the cart page
    header('Location: cart.php');
    exit();
}
