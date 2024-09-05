<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_name'];

    // Loop through the cart to find the product and remove it
    foreach ($_SESSION['cart'] as $key => $cartItem) {
        if ($cartItem['name'] == $productName) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    // Re-index the session array after removing
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    // Redirect back to cart page
    header('Location: cart.php');
    exit();
}
?>