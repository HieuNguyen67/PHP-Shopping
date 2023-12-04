<?php
session_start();

$loggedIn = false;
$username = '';

// Kiểm tra xem đã đăng nhập chưa
if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username = $_SESSION['username'];
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>PHPJabbers.com | Free Shopping Website Template</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    .hinhanh {
        width: 100px;
        height: 100px;
    }

    .image1 {
        width: 400px;
        height: 400px;
    }
    </style>
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
                        <h2 ">Thông tin sản phẩm.</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class=" featured-places">
                            <div class="container">
                                <?php
         
         
// Kiểm tra xem có session hay không, nếu không có thì khởi tạo session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra xem có tham số product_id trong URL không
if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Lưu product_id vào session để sử dụng ở các trang khác nếu cần
    $_SESSION['product_id'] = $product_id;

    // Kết nối đến cơ sở dữ liệu và truy vấn chi tiết sản phẩm
    include("./ConnectDB/database.php");

    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);
        // Xử lý thêm vào giỏ hàng
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
            $quantity = $_POST['quantity'];

            // Kiểm tra xem user đã đăng nhập hay chưa
            if (!isset($_SESSION['user_id'])) {
                // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
                header("Location: login.php");
                exit();
            }
            // Kiểm tra xem giỏ hàng của user đã tồn tại trong session hay chưa
            if (!isset($_SESSION['user_cart'])) {
                // Nếu chưa, tạo giỏ hàng cho user
                $_SESSION['user_cart'] = [];
            }

            // Kiểm tra xem sản phẩm đã có trong giỏ hàng của user chưa
            $product_exists = false;
            foreach ($_SESSION['user_cart'] as &$item) {
                if ($item['product_id'] == $product_id) {
                    // Nếu có, cập nhật số lượng
                    $item['quantity'] += $quantity;
                    $product_exists = true;
                    break;
                }
            }

            // Nếu sản phẩm chưa có trong giỏ hàng của user, thêm mới vào
            if (!$product_exists) {
                $product = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ];
                array_push($_SESSION['user_cart'], $product);

            }


            // Chuyển hướng về trang product_details
            header("Location: checkout.php");
        }

                                    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Hiển thị chi tiết sản phẩm
        echo "<div class='row d-flex flex-row'>";
                        echo "<div class='col border rounded' >";
                        $images = explode(';', $row['image']);
                        echo "<p class='text-center'><img src='./img/" . $images[0] . "' alt='Ảnh sản phẩm' class='image1 ' ></p><br><hr>"; // Tách chuỗi thành mảng các đường dẫn hình ảnh
                        foreach ($images as $image) {
                            echo "<img src='./img/" . $image . "' alt='Ảnh sản phẩm' class='hinhanh'>";
                        }
                        echo "</div>";
                        echo "<div class='col '><br> ";
                        
                        echo "<p style='font-size:40px;' class='text-dark fw-bold'>" . $row["tensanpham"] . "</p><br><br> ";
                     // Định dạng giá theo VNĐ
                        $formatted_price = number_format($row["gia"], 0, ',', '.') . "";
 
                        echo "<p style='font-size:30px;' class='text-danger fw-bold'> " . $formatted_price. "&nbsp;VNĐ</p><br>";



                                        // Hiển thị form thêm vào giỏ hàng
                                        echo "<form method='post' action='product_details.php?product_id=$product_id'>";
                                        echo "<label for='quantity' class='fs-3'>Số lượng: &ensp; </label>";
                                        echo "<input type='number' name='quantity' value='1' min='1' required class='fs-3'><br><br>";
                                        echo "<input type='submit' name='add_to_cart' value='Thêm vào giỏ hàng' class='btn btn-primary p-4 fs-3'>";
                                        echo "</form>";
                        echo "</div>";
                        echo "</div><br><br><br>";
                        echo "<p  style='font-size:20px;' class='text-dark'>Mô tả: " . $row["mota"] . "</p>";

    } else {
        echo "Sản phẩm không tồn tại.";
    }

    $conn->close();
} else {
    echo "Thiếu tham số product_id trong URL.";
}
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