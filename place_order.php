<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {

    if (isset($_SESSION['user_cart']) && count($_SESSION['user_cart']) > 0) {

        include("./ConnectDB/database.php");

        $user_id = $_SESSION['user_id'];

        
        $sql_order = "INSERT INTO orders (UserID, tongsotien) VALUES (:user_id, 0)";
        $stmt_order = $conn->prepare($sql_order);
        $stmt_order->bindParam(':user_id', $user_id);
        $stmt_order->execute();

       
        $order_id = $conn->lastInsertId();

    
        foreach ($_SESSION['user_cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];

            
            $sql_product = "SELECT * FROM products WHERE id = :product_id";
            $stmt_product = $conn->prepare($sql_product);
            $stmt_product->bindParam(':product_id', $product_id);
            $stmt_product->execute();

            $row_product = $stmt_product->fetch(PDO::FETCH_ASSOC);

            if ($row_product) {
                $total_price = $row_product['gia'] * $quantity;

           
                $sql_order_update = "UPDATE orders SET tongsotien = tongsotien + :total_price WHERE id = :order_id";
                $stmt_order_update = $conn->prepare($sql_order_update);
                $stmt_order_update->bindParam(':total_price', $total_price);
                $stmt_order_update->bindParam(':order_id', $order_id);
                $stmt_order_update->execute();

              
                $sql_order_detail = "INSERT INTO orderdetails (OrderID, ProductID, soluong, gia) VALUES (:order_id, :product_id, :quantity, :total_price)";
                $stmt_order_detail = $conn->prepare($sql_order_detail);
                $stmt_order_detail->bindParam(':order_id', $order_id);
                $stmt_order_detail->bindParam(':product_id', $product_id);
                $stmt_order_detail->bindParam(':quantity', $quantity);
                $stmt_order_detail->bindParam(':total_price', $total_price);
                $stmt_order_detail->execute();

                $sql_update_soluong = "UPDATE products SET soluong = soluong - :quantity WHERE id = :product_id";
                $stmt_soluong = $conn->prepare($sql_update_soluong);
                $stmt_soluong->bindParam(':quantity', $quantity);
                $stmt_soluong->bindParam(':product_id', $product_id);
                $stmt_soluong->execute();
            }
        }

       
        unset($_SESSION['user_cart']);

        echo "<h1 class='text-danger'>Đặt hàng thành công!</h1>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 1500);
          </script>";

      
        $conn = null;
    } else {
        echo "<h1 class='text-danger'>Không có sản phẩm trong giỏ hàng !, đang chuyển về trang Home....</h1>";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 1500);
          </script>";
    }
} else {
    echo "Vui lòng đăng nhập để đặt hàng.";
}
?>