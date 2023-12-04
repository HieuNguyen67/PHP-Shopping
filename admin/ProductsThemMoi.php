<?php
include("./checklogin.php");

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

                <div class="container">

                    <?php
                // Kết nối đến cơ sở dữ liệu
                include("../ConnectDB/database.php");

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Xử lý thông tin được gửi từ biểu mẫu thêm mới sản phẩm
                    $tenSanPham = $_POST['tenSanPham'];
                    $moTa = $_POST['moTa'];
                    $gia = $_POST['gia'];
                    $soLuong = $_POST['soLuong'];

                    // Xử lý tệp ảnh được tải lên
                    $targetDir = "../img/";
                    $targetFiles = array();

                    foreach ($_FILES['anhSanPham']['tmp_name'] as $key => $tmp_name) {
                        $fileName = basename($_FILES["anhSanPham"]["name"][$key]);
                        $targetFile = $targetDir . $fileName;

                        // Kiểm tra xem tệp ảnh có hợp lệ không
                        $check = getimagesize($_FILES["anhSanPham"]["tmp_name"][$key]);
                        if ($check !== false) {
                            echo "File là ảnh - " . $check["mime"] . ".<br>";
                            move_uploaded_file($_FILES["anhSanPham"]["tmp_name"][$key], $targetFile);
                            $targetFiles[] = $targetFile;
                        } else {
                            echo "File không phải là ảnh.<br>";
                        }
                    }

                    // Chuỗi đường dẫn của ảnh thành một chuỗi dạng 'path1;path2;path3'
                    $anhSanPham = implode(";", $targetFiles);

                    // Thêm thông tin sản phẩm vào cơ sở dữ liệu
                    $sql = "INSERT INTO products (tensanpham, mota, gia, soluong, image) VALUES ('$tenSanPham', '$moTa', $gia, $soLuong, '$anhSanPham')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<h3 class='text-danger'>Thêm mới sản phẩm thành công. Đang chuyển hướng...</h3>";
                        echo '<script>
                setTimeout(function() {
                    window.location.href = "ProductsLietKe.php";
                }, 3000);
              </script>';
                    } else {
                        echo "Lỗi: " . $sql . "<br>" . $conn->error;
                    }
                }
                ?>
                    <form class="mt-1 " method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="tenSanPham" class="form-label fs-2">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                name="tenSanPham" required>
                        </div>
                        <div class="mb-3">
                            <label for="moTa" class="form-label fs-2">Mô tả: </label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                name="moTa" required>
                        </div>
                        <div class="mb-3">
                            <label for="gia" class="form-label fs-2">Giá</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                name="gia" required>
                        </div>

                        <div class="mb-3">
                            <label for="soLuong" class="form-label fs-2">Số lượng: </label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                name="soLuong" required>
                        </div>
                        <div class="mb-3">

                            <label for="anhSanPham">Ảnh sản phẩm:</label><br>
                            <input type="file" name="anhSanPham[]" accept="image/*" multiple>
                        </div><br>


                        <button type="submit" class="btn btn-primary p-3 fs-4 col-2">Thêm</button>

                    </form>
                    <br>
                </div>
            </div>
        </div>




    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->

    <!-- End of Footer -->

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