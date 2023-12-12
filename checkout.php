<?php
session_start();

$loggedIn = false;
$username = '';


if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username = $_SESSION['username'];
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

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

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
                                <li class='active'><a href="checkout.php">Giỏ hàng</a></li>
                                <li><a href="UserInfo.php">Xin chào,
                                        <?php echo $username; ?>
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
    </div>

    <section class="banner banner-secondary" id="top" style="background-image: url(img/iphoneposter.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Giỏ hàng</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="featured-places">
            <div class="container">
                <div class='row d-flex flex-row'>
                    <div class='col fs-3 text-center'>
                        <h1>STT</h1>
                    </div>
                    <div class='col fs-3 text-center'>
                        <h1>Tên sản phẩm</h1>
                    </div>

                    <div class='col fs-3 text-center'>
                        <h1>Ảnh sản phẩm</h1>
                    </div>

                    <div class='col fs-3 text-center'>
                        <h1>Đơn Giá</h1>
                    </div>

                    <div class='col fs-3 text-center'>
                        <h1>Số lượng</h1>
                    </div>

                    <div class='col fs-3 text-center'>
                        <h1>Thành tiền</h1>
                    </div>

                    <div class='col fs-3 text-center'>
                        <h1> Xoá</h1>
                    </div>


                </div><br><br>
                <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }

                        include("./ConnectDB/database.php");

                        if (!isset($_SESSION['user_id'])) {
                            header("Location: login.php");
                            exit();
                        }

                        $index = 0;

                        if (isset($_SESSION['user_cart']) && count($_SESSION['user_cart']) > 0) {

                            $total_all = 0;
                            foreach ($_SESSION['user_cart'] as $item) {
                                $product_id = $item['product_id'];
                                $quantity = $item['quantity'];

                                $sql_cart_product = "SELECT * FROM products WHERE id = :product_id";
                                $stmt_cart_product = $conn->prepare($sql_cart_product);
                                $stmt_cart_product->bindParam(':product_id', $product_id);
                                $stmt_cart_product->execute();
                                $row_cart_product = $stmt_cart_product->fetch(PDO::FETCH_ASSOC);

                                if ($row_cart_product) {
                                    $total = 0;
                                    $total = $quantity * $row_cart_product['gia'];
                                    $total_all += $total;
                                    $images = explode(';', $row_cart_product['image']);
                                    echo "<div class='row d-flex flex-row'>";
                                    echo "<div class='col'>";
                                    echo "<p class='text-center fs-3 text-dark'>" . $index++ . "</p>";
                                    echo "</div>";
                                    echo "<div class='col'>";
                                    echo "<p class='text-center fs-3  text-dark'>{$row_cart_product['tensanpham']}</p>";
                                    echo "</div>";

                                    echo "<div class='col'>";
                                    echo "<img src='./img/" . $images[0] . "' alt='Ảnh sản phẩm' class='image' style='width:150px; height:150px;'>";
                                    echo "</div>";

                                    echo "<div class='col'>";
                                    echo "<p  class='text-center fs-3  text-dark'>" . number_format($row_cart_product['gia'], 0, ',', '.') . "&nbsp;VNĐ</p>";
                                    echo "</div>";

                                    echo "<div class='col'>";
                                    echo "<p class='text-center fs-3  text-dark'>$quantity</p>";
                                    echo "</div>";

                                    echo "<div class='col'>";
                                    echo "<p   class='text-center fs-3 fw-bold text-danger'>" . number_format($total, 0, ',', '.') . "&nbsp;VNĐ</p>";
                                    echo "</div>";

                                    echo "<div class='col'>";
                                    echo "<p class='text-center fs-3  text-dark'><a href='remove_item.php?product_id={$item['product_id']}'><button class='btn btn-danger p-4'>Xoá</button></a></p>";
                                    echo "</div>";

                                    echo "</div>";
                                }
                            }
                        } else {
                            echo "<p>Không có sản phẩm trong giỏ hàng.</p>";
                        }

                        // Đóng kết nối sau khi sử dụng
                        $conn = null;

                        // Chức năng đặt hàng
                        echo "<div class='row d-flex flex-row'>";
                        echo "<div class='col col-8'>";

                        echo "</div>";

                        echo "<div class='col '>";
                        if (isset($total_all)) {
                            echo "<h1 class='text-dark ms-4 fw-bold'>Tổng tiền : " . number_format($total_all, 0, ',', '.') . "&nbsp;VNĐ</h1>";
                        }

                        echo "</div>";
                        echo "</div><br><br><br>";

                        echo "<div class='row d-flex flex-row'>";
                        echo "<div class='col col-8'>";

                        echo "</div>";

                        echo "<div class='col '>";
                        echo "<form method='post' action='place_order.php'>";
                        echo "<button type='submit' class='btn btn-dark p-4 fs-3 col-10'>Đặt hàng</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
?>



            </div>
        </section>
    </main>

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

    <div class="sub-footer">
        <p>Copyright © 2020 Company Name - Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a></p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>
    window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>

    <script src="js/vendor/bootstrap.min.js"></script>

    <script src="js/datepicker.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>

</html>