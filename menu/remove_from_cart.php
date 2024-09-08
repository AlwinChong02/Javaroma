<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productID = $_POST['product_id'];

    foreach ($_SESSION['cart'] as $key => $cartItem) {
        if ($cartItem['id'] == $productID) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    $_SESSION['cart'] = array_values($_SESSION['cart']);

    // Redirect back to cart page
    header('Location: cart.php');
    exit();
}
