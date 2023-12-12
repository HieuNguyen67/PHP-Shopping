<?php
session_start();

if (isset($_SESSION["admin_id"])) {
    header("Location: admin.php");
    exit();
}

include("../ConnectDB/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST["identifier"];
    $password = $_POST["password"];

    $identifier = htmlspecialchars($identifier);
    $password = htmlspecialchars($password);

    $query = "SELECT * FROM admins WHERE (username=:identifier OR email=:identifier) AND password=:password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':identifier', $identifier);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["admin_id"] = $user["id"];
        $_SESSION["adminname"] = $user["username"];
        header("Location: admin.php");
        exit();
    } else {
        $error_message = "Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin đăng nhập.";
    }
}

$conn = null; // Đóng kết nối đến cơ sở dữ liệu
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <?php if (isset($error_message)) {
                                        echo '<p style="color:red;">' . $error_message . '</p>';
                                    } ?>
                                    <form class="mt-5 " method="POST" action="">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label fs-2">Username hoặc
                                                email</label>
                                            <input class="form-control" aria-describedby="emailHelp" name="identifier"
                                                required>

                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label  fs-2">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1"
                                                name="password" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary  fs-4">Đăng nhập</button>
                                    </form>
                                    <hr>

                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>