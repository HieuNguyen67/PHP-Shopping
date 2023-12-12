<?php
session_start();

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    if (isset($_SESSION['user_cart']) && count($_SESSION['user_cart']) > 0) {
        $item_key = array_search($product_id, array_column($_SESSION['user_cart'], 'product_id'));

        if ($item_key !== false) {
           
            unset($_SESSION['user_cart'][$item_key]);
        }
    }
}

header("Location: checkout.php");
exit();
?>