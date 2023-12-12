<?php
include("./checklogin.php");

include("../ConnectDB/database.php");

if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];
    $new_fullname = $_POST['new_fullname'];
    $new_gender = $_POST['new_gender'];
    $new_phone = $_POST['new_phone'];
    $new_address = $_POST['new_address'];

    $update_query = "UPDATE users SET username=:new_username, email=:new_email, fullname=:new_fullname, gioitinh=:new_gender, phone=:new_phone, address=:new_address WHERE id = :user_id";
    $stmt = $conn->prepare($update_query);
    $stmt->bindParam(':new_username', $new_username);
    $stmt->bindParam(':new_email', $new_email);
    $stmt->bindParam(':new_fullname', $new_fullname);
    $stmt->bindParam(':new_gender', $new_gender);
    $stmt->bindParam(':new_phone', $new_phone);
    $stmt->bindParam(':new_address', $new_address);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        $message = "Thông tin người dùng đã được cập nhật thành công.";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'UserLietKe.php';
            }, 1500); // 3000 milliseconds = 3 seconds
          </script>";
    } else {
        echo "Lỗi cập nhật thông tin người dùng: " . $stmt->errorInfo()[2];
    }
}

$user_id = $_GET['id'];

$select_query = "SELECT * FROM users WHERE id=:user_id";
$stmt = $conn->prepare($select_query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
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


                    <div class="container mt-5">
                        <h2 class="mb-4">Sửa thông tin người dùng</h2>
                        <?php if (isset($message)) {
                            echo '<p style="color:red;">' . $message . '</p>';
                        } ?>

                        <!-- Biểu mẫu sửa thông tin -->
                        <form method="post" action="" class="needs-validation" novalidate>
                            <input type="hidden" name="user_id" value="<?php echo $user_data['id']; ?>">

                            <div class="form-group">
                                <label for="new_username">Username:</label>
                                <input type="text" name="new_username" class="form-control"
                                    value="<?php echo $user_data['username']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="new_email">Email:</label>
                                <input type="email" name="new_email" class="form-control"
                                    value="<?php echo $user_data['email']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="new_fullname">Fullname:</label>
                                <input type="text" name="new_fullname" class="form-control"
                                    value="<?php echo $user_data['fullname']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="new_gender">Giới tính:</label>
                                <select name="new_gender" class="form-control" required>
                                    <option value="Nam" <?php if ($user_data['gioitinh'] == 'Nam')
                                        echo 'selected'; ?>>Nam</option>
                                    <option value="Nu" <?php if ($user_data['gioitinh'] == 'Nu')
                                        echo 'selected'; ?>>Nữ</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="new_phone">SĐT:</label>
                                <input type="text" name="new_phone" class="form-control"
                                    value="<?php echo $user_data['phone']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="new_address">Địa chỉ:</label>
                                <input type="text" name="new_address" class="form-control"
                                    value="<?php echo $user_data['address']; ?>" required>
                            </div>

                            <button type=" submit" name="update_user" class="btn btn-primary">Cập nhật</button>
                        </form>
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
$conn = null;
?>