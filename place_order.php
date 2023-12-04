<?php
// Kiểm tra xem có session hay không, nếu không có thì khởi tạo session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem user đã đăng nhập hay chưa
if (isset($_SESSION['user_id'])) {
    // Kiểm tra xem giỏ hàng của user có tồn tại hay không
    if (isset($_SESSION['user_cart']) && count($_SESSION['user_cart']) > 0) {
        // Kết nối đến cơ sở dữ liệu MySQL
     include("./ConnectDB/database.php");

        // Lấy thông tin user
        $user_id = $_SESSION['user_id'];

        // Tạo đơn hàng
        $sql_order = "INSERT INTO orders (UserID, tongsotien) VALUES ($user_id, 0)";
        $conn->query($sql_order);

        // Lấy ID của đơn hàng vừa tạo
        $order_id = $conn->insert_id;

        // Lưu thông tin chi tiết đơn hàng vào cơ sở dữ liệu
        foreach ($_SESSION['user_cart'] as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];

            // Truy vấn thông tin sản phẩm
            $sql_product = "SELECT * FROM products WHERE id = $product_id";
            $result_product = $conn->query($sql_product);

            if ($result_product->num_rows > 0) {
                $row_product = $result_product->fetch_assoc();

                // Cập nhật tổng giá trên đơn hàng
                $total_price = $row_product['gia'] * $quantity;
                $sql_order_update = "UPDATE orders SET tongsotien = tongsotien + $total_price WHERE id = $order_id";
                $conn->query($sql_order_update);

                // Thêm chi tiết đơn hàng
                $sql_order_detail = "INSERT INTO orderdetails (OrderID, ProductID, soluong, gia) VALUES ($order_id, $product_id, $quantity, $total_price)";
                $conn->query($sql_order_detail);
            }
        }

        // Sau khi đặt hàng, xóa giỏ hàng của user
        unset($_SESSION['user_cart']);

        echo "<h1 class='text-danger'>Đặt hàng thành công!</h1>";
        echo "<script>
     
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 1500); // 3000 milliseconds = 3 seconds
          </script>";

        // Đóng kết nối cơ sở dữ liệu
        $conn->close();
    } else {
        echo "<h1 class='text-danger'>Không có sản phẩm trong giỏ hàng !, đang chuyển về trang Home....</h1>";
        echo "<script>
     
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 1500); // 3000 milliseconds = 3 seconds
          </script>";
    }
} else {
    echo "Vui lòng đăng nhập để đặt hàng.";
}
?>