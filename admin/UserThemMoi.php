<?php
include("./checklogin.php");

// Include the PDO connection file
include("../ConnectDB/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $fullname = $_POST["fullname"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    
    // Using prepared statements to prevent SQL injection
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=:username OR email=:email");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $error_message = "Người dùng đã tồn tại. Vui lòng chọn username hoặc email khác.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, fullname, gioitinh, phone, address) VALUES (:username, :password, :email, :fullname, :gender, :phone, :address)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);

        if ($stmt->execute()) {
            $error_message1 = "Thêm thành công .";

            echo "<script>
                setTimeout(function() {
                    window.location.href = 'UserLietKe.php';
                }, 1500); // 3000 milliseconds = 3 seconds
            </script>";
        } else {
            $error_message2 = "Thêm thất bại. Vui lòng kiểm tra lại thông tin." . $stmt->errorInfo();
        }
    }
}

// Close the PDO connection
$conn = null;
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
                    <h2>Thêm khách hàng</h2>

                    <div class="card-body">

                        <div class="container ">
                            <?php if (isset($error_message)) {
    echo '<p style="color:red;">' . $error_message . '</p>';
} ?>
                            <?php if (isset($error_message1)) {
    echo '<p style="color:red;">' . $error_message1 . '</p>';
} ?>
                            <?php if (isset($error_message2)) {
    echo '<p style="color:red;">' . $error_message2 . '</p>';
} ?>
                            <form class="mt-1 " method="post" action="">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label fs-2">Họ và tên</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="fullname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label fs-2">Email </label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label fs-2">Username</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label  fs-2">Password</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" name="password"
                                        required>
                                </div>
                                <label for="gender" class="fs-2 me-3">Giới tính: </label>
                                <select name="gender" required class="p-3 my-3 fs-3">
                                    <option value="Nam" class="fs-3">Nam</option>
                                    <option value="Nu" class="fs-3">Nữ</option>
                                </select>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label fs-2">Phone: </label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label fs-2">Address: </label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="address" required>
                                </div>
                                <br><br>

                                <button type="submit" class="btn btn-primary p-3 fs-4">Thêm</button>

                            </form>
                            <br>
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