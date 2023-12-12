<?php

include("./ConnectDB/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $fullname = $_POST["fullname"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);
    $email = htmlspecialchars($email);
    $fullname = htmlspecialchars($fullname);
    $gender = htmlspecialchars($gender);
    $phone = htmlspecialchars($phone);
    $address = htmlspecialchars($address);

    try {
        // Kiểm tra xem người dùng đã tồn tại hay chưa
        $check_query = "SELECT * FROM users WHERE username=:username OR email=:email";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bindParam(':username', $username);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $error_message = "Người dùng đã tồn tại. Vui lòng chọn username hoặc email khác.";
        } else {
            // Thêm người dùng mới
            $insert_query = "INSERT INTO users (username, password, email, fullname, gioitinh, phone, address) 
                            VALUES (:username, :password, :email, :fullname, :gender, :phone, :address)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bindParam(':username', $username);
            $insert_stmt->bindParam(':password', $password);
            $insert_stmt->bindParam(':email', $email);
            $insert_stmt->bindParam(':fullname', $fullname);
            $insert_stmt->bindParam(':gender', $gender);
            $insert_stmt->bindParam(':phone', $phone);
            $insert_stmt->bindParam(':address', $address);

            if ($insert_stmt->execute()) {
                $error_message2 = "Đăng ký thành công";
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 1500); 
                </script>";
            } else {
                $error_message2 = "Đăng ký thất bại. Vui lòng kiểm tra lại thông tin.";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Phone Shopping</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>

    <div class="wrap">
        <header id="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button id="primary-nav-button" type="button">Menu</button>
                        <a href="index.php">
                            <div class="logo">
                                <img src="img/logo.png" alt="Venue Logo">
                            </div>
                        </a>
                        <nav id="primary-nav" class="dropdown cf">
                            <ul class="dropdown menu">
                                <li><a href="index.php">Home</a></li>

                                <li><a href="products.php">Products</a></li>



                                <li><a href="contact.php">Contact Us</a></li>

                                <li><a href="./login.php">Đăng nhập</a></li>
                                <li class='active'><a href="./dangky.php">Đăng ký</a></li>

                            </ul>
                        </nav><!-- / #primary-nav -->
                    </div>
                </div>
            </div>
        </header>
        <div class="container ">
            <br class="" />
            <?php if (isset($error_message)) {
                echo '<p style="color:red;">' . $error_message . '</p>';
            } ?>
            <?php if (isset($error_message2)) {
                echo '<p style="color:red;">' . $error_message2 . '</p>';
            } ?>
            <form class="mt-5 " method="post" action="">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fs-2">Họ và tên</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        name="fullname" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fs-2">Email </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        name="email" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fs-2">Username</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        name="username" required>
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label  fs-2">Password</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fs-2">Số điện thoại: </label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fs-2">Địa chỉ: </label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        name="address" required>
                </div>
                <label for="gender" class="fs-2 me-3">Giới tính: </label>
                <select name="gender" required class="p-3 my-3 fs-3">
                    <option value="Nam" class="fs-3">Nam</option>
                    <option value="Nu" class="fs-3">Nữ</option>
                </select><br><br>

                <button type="submit" class="btn btn-primary p-4 fs-4">Đăng ký</button>
            </form>
            <br>


        </div>
    </div>


</body>

</html>