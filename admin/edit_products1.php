<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    form {
        max-width: 500px;
        margin: auto;
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input,
    button {
        margin-bottom: 10px;
    }
    </style>
</head>

<body>

    <?php
    // Kết nối đến cơ sở dữ liệu
    include("../ConnectDB/database.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Xử lý thông tin được gửi từ biểu mẫu sửa sản phẩm
        $productID = $_POST['productID'];
       

        // Xử lý tệp ảnh được tải lên
        $targetDir = "../img/";
        $targetFiles = array();

        // Lặp qua mảng tệp được tải lên
        foreach ($_FILES['anhSanPham']['tmp_name'] as $key => $tmp_name) {
            $fileName = basename($_FILES["anhSanPham"]["name"][$key]);
            $targetFile = $targetDir . $fileName;

            // Kiểm tra xem tệp ảnh có hợp lệ không
            $check = getimagesize($_FILES["anhSanPham"]["tmp_name"][$key]);
            if ($check !== false) {
              
                move_uploaded_file($_FILES["anhSanPham"]["tmp_name"][$key], $targetFile);
                $targetFiles[] =  $targetFile;
            } else {
                echo "File không phải là ảnh.<br>";
            }
        }

        // Chuỗi đường dẫn của ảnh thành một chuỗi dạng 'path1;path2;path3'
        $targetFilesString = implode(";", $targetFiles);

        // Cập nhật thông tin sản phẩm vào cơ sở dữ liệu
        $sql = "UPDATE products SET image='$targetFilesString' WHERE id=$productID";

        if ($conn->query($sql) === TRUE) {
            echo "Cập nhật sản phẩm thành công.";
            echo "<script>
     
            setTimeout(function() {
                window.location.href = 'edit_products.php?id=$productID';
            }, 1500); // 3000 milliseconds = 3 seconds
          </script>";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }

    // Lấy ID sản phẩm từ tham số URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $productID = $_GET['id'];

        // Truy vấn SQL để lấy thông tin sản phẩm từ bảng Products dựa trên ProductID
        $sql = "SELECT * FROM products WHERE id = $productID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Hiển thị biểu mẫu sửa sản phẩm
            ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="productID" value="<?php echo $row['id']; ?>">


        <label for="anhSanPham">Ảnh sản phẩm:</label>
        <input type="file" name="anhSanPham[]" accept="image/*" multiple>

        <button type="submit">Lưu thay đổi</button>
    </form>
    <?php
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
    } else {
        echo "ID sản phẩm không hợp lệ.";
    }

    $conn->close();
    ?>

</body>

</html>