<?php
include("./checklogin.php");
// Thông tin kết nối đến cơ sở dữ liệu
include("../ConnectDB/database.php");

// Xử lý khi người dùng nhấn nút Cập nhật
if (isset($_POST['update_products'])) {
    $products_id = $_POST['products_id'];
    $new_tensanpham = $_POST['new_tensanpham'];
    $new_mota = $_POST['new_mota'];
    $new_gia = $_POST['new_gia'];
    $new_soluong = $_POST['new_soluong'];



    // Thực hiện truy vấn để cập nhật thông tin người dùng
    $update_query = "UPDATE products SET tensanpham='$new_tensanpham', mota='$new_mota', gia='$new_gia', soluong='$new_soluong'   WHERE id = '$products_id'";

    if ($conn->query($update_query) === TRUE) {
        $message = "Sản phẩm đã được cập nhật thành công.";
        echo "<script>
     
            setTimeout(function() {
                window.location.href = 'ProductsLietKe.php';
            }, 1500); // 3000 milliseconds = 3 seconds
          </script>";
    } else {
        echo "Lỗi cập nhật thông tin sản phẩm: " . $conn->error;
    }
}

// Lấy ID người dùng từ tham số URL
$products_id = $_GET['id'];

// Truy vấn để lấy thông tin người dùng cần sửa
$select_query = "SELECT * FROM products WHERE id='$products_id'";
$result = $conn->query($select_query);

// Lấy dữ liệu người dùng hiện tại
$products_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Buttons</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    .hinhanh {
        width: 100px;
        height: 100px;
    }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php
        require('./include/sidebar.php');
        ?>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">


            <!-- Main Content -->
            <div id="content">
                <?php
                require("./include/topbar.php");
                ?>


                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <div class="container mt-5">
                        <h2 class="mb-4">Sửa thông tin sản phẩm</h2>
                        <?php if (isset($message)) {
                            echo '<p style="color:red;">' . $message . '</p>';
                        } ?>
                        <div class="form-group">
                            <div for="new_soluong">Hình ảnh:</div><br>
                            <?php
                            $images = explode(';', $products_data['image']);
                           
                            foreach ($images as $image) {
                                echo "<img src='" . $image . "' alt='Ảnh sản phẩm' class='hinhanh'>";
                            }
                            echo "<br><br><a href='edit_products1.php?id=" . $products_data['id']
                                . "'><button type='submit' class='btn btn-secondary'>Upload Ảnh</button></a>";

                            ?>

                        </div>

                        <!-- Biểu mẫu sửa thông tin -->
                        <form method="post" action="" class="needs-validation" novalidate>
                            <input type="hidden" name="products_id" value="<?php echo $products_data['id']; ?>">

                            <div class="form-group">
                                <label for="new_tensanpham">Tên sản phẩm:</label>
                                <input type="text" name="new_tensanpham" class="form-control"
                                    value="<?php echo $products_data['tensanpham']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="new_mota">Mô tả:</label>
                                <textarea name="new_mota" class="form-control" style="height: 200px;">
                                <?php echo $products_data['mota']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label for="new_gia">Giá:</label>
                                <input type="text" name="new_gia" class="form-control"
                                    value="<?php echo $products_data['gia'];?>" required>
                            </div>

                            <div class="form-group">
                                <label for="new_soluong">Số lượng:</label>
                                <input type="text" name="new_soluong" class="form-control"
                                    value="<?php echo $products_data['soluong']; ?>" required>
                            </div>





                            <button type=" submit" name="update_products" class="btn btn-primary">Cập nhật</button>
                        </form>
                        <br><br><br>
                        <br>
                    </div>
                </div>


                <!-- Page Heading -->






            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->



    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php
    require("./include/modal.php");
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php
// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>