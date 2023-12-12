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

    $productID = $_POST['productID'];


    $targetDir = "../img/";
    $targetFiles = array();


    foreach ($_FILES['anhSanPham']['tmp_name'] as $key => $tmp_name) {
        $fileName = basename($_FILES["anhSanPham"]["name"][$key]);
        $targetFile = $targetDir . $fileName;


        $check = getimagesize($_FILES["anhSanPham"]["tmp_name"][$key]);
        if ($check !== false) {

            move_uploaded_file($_FILES["anhSanPham"]["tmp_name"][$key], $targetFile);
            $targetFiles[] = $targetFile;
        } else {
            echo "File không phải là ảnh.<br>";
        }
    }


    $targetFilesString = implode(";", $targetFiles);


    $sql = "UPDATE products SET image=:targetFilesString WHERE id=:productID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':targetFilesString', $targetFilesString);
    $stmt->bindParam(':productID', $productID);

    if ($stmt->execute()) {
        echo "Cập nhật sản phẩm thành công.";
        echo "<script>
     
            setTimeout(function() {
                window.location.href = 'edit_products.php?id=$productID';
            }, 1500); // 3000 milliseconds = 3 seconds
          </script>";
    } else {
        echo "Lỗi: " . $stmt->errorInfo()[2];
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productID = $_GET['id'];


    $sql = "SELECT * FROM products WHERE id = :productID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productID', $productID);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


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

    $conn = null;
?>


</body>

</html>