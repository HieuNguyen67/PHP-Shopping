<?php
include("./checklogin.php");
// Kết nối đến cơ sở dữ liệu
include("../ConnectDB/database.php");

// Xử lý khi người dùng nhấn nút Xoá
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['delete_user'];

    // Thực hiện truy vấn để xoá người dùng
    $delete_query = "DELETE FROM users WHERE id = '$user_id'";
    if ($conn->query($delete_query) === TRUE) {
        $message_delete= "Người dùng đã được xoá thành công.";
    } else {
        echo "Lỗi xoá người dùng: " . $conn->error;
    }
}

// Truy vấn để lấy danh sách người dùng
$select_query = "SELECT * FROM users";
$result = $conn->query($select_query);
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


                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <!-- Page Heading -->
                    <h2>Danh sách người dùng</h2>

                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="d-flex flex-row">
                                <div class="col-11"></div>
                                <div class="col-1"> <a href="./UserThemMoi.php"> <button type=" submit"
                                            name="update_user" class="btn btn-primary col-12 ms-3">Thêm</button></a>
                                </div>
                            </div>
                            <br>
                            <?php if (isset($message_delete)) {
                                echo '<p style="color:red;">' . $message_delete . '</p>';
                            } ?>
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Fullname</th>
                                        <th>Giới tính</th>
                                        <th>SĐT</th>
                                        <th>Địa chỉ</th>
                                        <th>Sửa</th>
                                        <th>Xoá</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    // Hiển thị dữ liệu từ cơ sở dữ liệu trong bảng HTML
                                    $id1=1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $id1++ . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['fullname'] . "</td>";
                                        echo "<td>" . $row['gioitinh'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>" . $row['address'] . "</td>";
                                        echo "<td><a href='edit_user.php?id=" . $row['id'] . "'><button type='submit' class='btn btn-warning pe-4 col-10'>Sửa</button></a></td>";

                                        // Nút Xoá
                                        echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='delete_user' value='" . $row['id'] . "'>
                         <button type='submit' class='btn btn-danger pe-4 fs-4  col-10'>Xoá</button>
                    </form>
                </td>";
                                        echo "</tr>";
                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                    </div>





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