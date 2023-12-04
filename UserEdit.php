<?php
session_start();

$loggedIn = false;
$username1 = '';

// Kiểm tra xem đã đăng nhập chưa
if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username1 = $_SESSION['username'];
}

include("./ConnectDB/database.php");

// Xử lý khi người dùng nhấn nút Cập nhật
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];
    $new_fullname = $_POST['new_fullname'];
    $new_gender = $_POST['new_gender'];
    $new_phone = $_POST['new_phone'];
    $new_address = $_POST['new_address'];

    // Thực hiện truy vấn để cập nhật thông tin người dùng
    $update_query = "UPDATE users SET username='$new_username', email='$new_email', fullname='$new_fullname', gioitinh='$new_gender' , phone='$new_phone', address='$new_address' WHERE id = '$user_id'";

    if ($conn->query($update_query) === TRUE) {
        $message = "Thông tin người dùng đã được cập nhật thành công.";
        echo "<script>
     
            setTimeout(function() {
                window.location.href = 'UserInfo.php';
            }, 1500); // 3000 milliseconds = 3 seconds
          </script>";
    } else {
        echo "Lỗi cập nhật thông tin người dùng: " . $conn->error;
    }
}

// Lấy ID người dùng từ tham số URL
$user_id = $_GET['id'];

// Truy vấn để lấy thông tin người dùng cần sửa
$select_query = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($select_query);

// Lấy dữ liệu người dùng hiện tại
$user_data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>PHPJabbers.com | Free Shopping Website Template</title>

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

                                <li class='active'><a href="products.php">Products</a></li>





                                <li><a href="contact.php">Contact Us</a></li>
                                <?php if ($loggedIn): ?>
                                <li><a href="checkout.php">Giỏ hàng</a></li>
                                <li><a href="UserInfo.php">Xin chào,
                                        <?php echo $username1; ?>
                                    </a></li>
                                <li><a href="index.php?logout=true">
                                        <form class="dropdown-item" action="logout.php" method="post">
                                            <input type="submit" value="Đăng xuất"
                                                style="border: none; background-color: transparent ;">

                                        </form>
                                    </a></li>
                                <?php else: ?>
                                <li><a href="./login.php">Đăng nhập</a></li>
                                <li><a href="./dangky.php">Đăng ký</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav><!-- / #primary-nav -->
                    </div>
                </div>
            </div>
        </header>

        <div class="container ">
            <br><br>
            <div class="container mt-5">
                <div class="row d-flex flex-row">
                    <div class="col "></div>
                    <div class="col col-4">
                        <h1 class="text-center fw-bold">Sửa thông tin cá nhân</h1>
                    </div>
                    <div class="col "></div>
                </div>
                <br> <br>
                <?php if (isset($message)) {
    echo '<h3 style="color:red;">' . $message . '</h3><br>';
} ?>
                <!-- Biểu mẫu sửa thông tin -->
                <form method="post" action="" class="needs-validation" novalidate>
                    <input type="hidden" name="user_id" value="<?php echo $user_data['id']; ?>">
                    <div class="form-group">
                        <label for="new_fullname">
                            <h3>Họ và tên:</h3>
                        </label>
                        <input type="text" name="new_fullname" class="form-control"
                            value="<?php echo $user_data['fullname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="new_email">
                            <h3>Email:</h3>
                        </label>
                        <input type="email" name="new_email" class="form-control"
                            value="<?php echo $user_data['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="new_gender">
                            <h3>Giới tính:</h3>
                        </label>
                        <select name="new_gender" class="form-control" required>
                            <option value="Nam" <?php if ($user_data['gioitinh'] == 'Nam')
                                echo 'selected'; ?>>Nam</option>
                            <option value="Nu" <?php if ($user_data['gioitinh'] == 'Nu')
                                echo 'selected'; ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="new_phone">
                            <h3>SĐT:</h3>
                        </label>
                        <input type="text" name="new_phone" class="form-control"
                            value="<?php echo $user_data['phone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="new_username">
                            <h3>Tên đăng nhập:</h3>
                        </label>
                        <input type="text" name="new_username" class="form-control"
                            value="<?php echo $user_data['username']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="new_address">
                            <h3>Địa chỉ:</h3>
                        </label>
                        <input type="text" name="new_address" class="form-control"
                            value="<?php echo $user_data['address']; ?>" required>
                    </div>

                    <button type=" submit" name="update_user" class="btn btn-primary p-4">
                        <h4>Cập nhật</h4>
                    </button>
                </form>
                <br>

            </div>
        </div>


</body>

</html>