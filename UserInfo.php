<?php
session_start();

$loggedIn = false;
$username1 = '';

if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username1 = $_SESSION['username'];
}

include("./ConnectDB/database.php");

$user_id = $_SESSION["user_id"];

$select_query = "SELECT * FROM users WHERE id=:user_id";
$stmt_select = $conn->prepare($select_query);
$stmt_select->bindParam(':user_id', $user_id);
$stmt_select->execute();

$user_data = $stmt_select->fetch(PDO::FETCH_ASSOC);

// Đóng kết nối sau khi sử dụng
$conn = null;
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
        <section class="banner banner-secondary" id="top" style="background-image: url(img/iphoneposter.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="banner-caption">
                            <div class="line-dec"></div>
                            <h2>Thông tin khách hàng</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container ">
            <br><br>
            <br><br>
            <br><br>




            </tr>
            </thead>

            <tbody>
                <?php
        if ($user_data) {
            echo "<div class='row d-flex flex-row'>";
            echo "<div class='col col-5'>";
            echo "<h2  class='text-secondary fw-bold'>Họ và tên: <span class='text-primary fw-normal'>" . $user_data['fullname'] . "</span></h2><br><hr>";
            echo "<h2  class='text-secondary fw-bold'>Email: <span class='text-primary fw-normal'>" . $user_data['email'] . "</span></h2><br><hr>";
            echo "<h2  class='text-secondary fw-bold'>Giới tính: <span class='text-primary fw-normal'>" . $user_data['gioitinh'] . "</span></h2><br><hr>";
            echo "</div>";
            echo "<div class='col col-5'>";
            echo "<h2  class='text-secondary fw-bold'>Số điện thoại: <span class='text-primary fw-normal'>" . $user_data['phone'] . "</span></h2><br><hr>";
            echo "<h2  class='text-secondary fw-bold'>Tên đăng nhập: <span class='text-primary fw-normal'>" . $user_data['username'] . "</span></h2><br><hr>";
            echo "<h2  class='text-secondary fw-bold'>Địa chỉ: <span class='text-primary fw-normal'>" . $user_data['address'] . "</span></h2><br><hr>";
            echo "</div>";
            echo "<div class='col-2'>";
            echo "<a href='UserEdit.php?id=" . $user_data['id'] . "'>
                        <button type='submit' name='update_user' class='btn btn-primary col-12 pt-3 pb-3'>
                            <h2>Sửa hồ sơ</h2>
                        </button></a>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "Không tìm thấy thông tin khách hàng.";
        }
        ?>




        </div>
        <br><br> <br><br> <br><br>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="about-veno">
                            <div class="logo">
                                <img src="img/footer_logo.png" alt="Venue Logo">
                            </div>
                            <p>Mauris sit amet quam congue, pulvinar urna et, congue diam. Suspendisse eu lorem massa.
                                Integer sit amet posuere tellustea dictumst.</p>
                            <ul class="social-icons">
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="useful-links">
                            <div class="footer-heading">
                                <h4>Useful Links</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li><a href="inde.php"><i class="fa fa-stop"></i>Home</a></li>
                                        <li><a href="about.php"><i class="fa fa-stop"></i>About</a></li>
                                        <li><a href="contact.php"><i class="fa fa-stop"></i>Contact Us</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li><a href="products.php"><i class="fa fa-stop"></i>Products</a></li>
                                        <li><a href="testimonials.php"><i class="fa fa-stop"></i>Testimonials</a></li>
                                        <li><a href="blog.php"><i class="fa fa-stop"></i>Blog</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="contact-info">
                            <div class="footer-heading">
                                <h4>Contact Information</h4>
                            </div>
                            <p><i class="fa fa-map-marker"></i> 212 Barrington Court New York, ABC</p>
                            <ul>
                                <li><span>Phone:</span><a href="#">+1 333 4040 5566</a></li>
                                <li><span>Email:</span><a href="#">contact@company.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>


</body>

</html>