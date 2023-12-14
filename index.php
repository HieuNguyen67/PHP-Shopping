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

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <style>
    .product-card {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 10px;
        text-align: center;
    }

    .image {
        width: 200px;
        height: 200px;
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
                                <li class='active'><a href="index.php">Home</a></li>

                                <li><a href="products.php">Products</a></li>





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

    <section class="banner" id="top" style="background-image: url(img/iphoneposter.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>IPhone 15 Pro Max.</h2>
                        <div class="blue-button">
                            <a href="contact.php">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="our-services">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="left-content">
                            <br>
                            <h4>About us</h4>
                            <p>Aenean hendrerit metus leo, quis viverra purus condimentum nec. Pellentesque a sem
                                semper, lobortis mauris non, varius urna. Quisque sodales purus eu tellus
                                fringilla.<br><br>Mauris sit amet quam congue, pulvinar urna et, congue diam.
                                Suspendisse eu lorem massa. Integer sit amet posuere tellus, id efficitur leo. In hac
                                habitasse platea dictumst. Vel sequi odit similique repudiandae ipsum iste, quidem
                                tenetur id impedit, eaque et, aliquam quod.</p>
                            <div class="blue-button">
                                <a>Discover More</a>
                            </div>

                            <br>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <img src="img/iphone12.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">

                            <h1>DANH SÁCH SẢN PHẨM</h1>
                        </div>
                    </div>
                </div>

                <?php
            include("./ConnectDB/database.php");

            $sql = "SELECT id, tensanpham, gia, image FROM products";
          
                $stmt = $conn->prepare($sql);
             
                $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<div class='row d-flex flex-row row-cols-3'>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $images = explode(';', $row['image']);
                    echo "<a class='text-decoration-none' href='product_details.php?product_id=" . $row["id"] . "'>";
                    echo "<div class='col product-card shadow rounded'>";
                    echo "<img src='./img/" . $images[0] . "' alt='Ảnh sản phẩm' class='image'><br><br>";
                    echo "<h1 class='text-dark'>" . $row['tensanpham'] . "</h1>";
                    $formatted_price = number_format($row["gia"], 0, ',', '.') . "";
                    echo "<h3 class='text-secondary' >Giá: " . $formatted_price . "&nbsp;VNĐ</h3>";
                    echo "<hr>";
                    echo "<h3 class='text-warning'>XEM SẢN PHẨM</h3>";
                    echo "</div>";
                    echo "</a>";
                }
                echo "</div>";
            } else {
                echo "Không có sản phẩm nào.";
            }

         
            $conn = null;
            ?>




            </div>
        </section>

        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <span>Latest blog posts</span>
                            <h2>Lorem ipsum dolor sit amet ctetur.</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/blog-1-720x480.jpg" alt="">
                                </div>

                                <div class="overlay-content">
                                    <strong title="Author"><i class="fa fa-user"></i> John Doe</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong title="Posted on"><i class="fa fa-calendar"></i> 12/06/2020 10:30</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong title="Views"><i class="fa fa-map-marker"></i> 115</strong>
                                </div>
                            </div>

                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur adipisicing elit hic</h4>

                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim consectetur assumenda
                                    nam facere voluptatibus totam veritatis. </p>

                                <div class="text-button">
                                    <a href="blog-details.php">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/blog-2-720x480.jpg" alt="">
                                </div>

                                <div class="overlay-content">
                                    <strong title="Author"><i class="fa fa-user"></i> John Doe</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong title="Posted on"><i class="fa fa-calendar"></i> 12/06/2020 10:30</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong title="Views"><i class="fa fa-map-marker"></i> 115</strong>
                                </div>
                            </div>

                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur adipisicing elit hic</h4>

                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim consectetur assumenda
                                    nam facere voluptatibus totam veritatis. </p>

                                <div class="text-button">
                                    <a href="blog-details.php">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/blog-3-720x480.jpg" alt="">
                                </div>

                                <div class="overlay-content">
                                    <strong title="Author"><i class="fa fa-user"></i> John Doe</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong title="Posted on"><i class="fa fa-calendar"></i> 12/06/2020 10:30</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong title="Views"><i class="fa fa-map-marker"></i> 115</strong>
                                </div>
                            </div>

                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur adipisicing elit hic</h4>

                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Enim consectetur assumenda
                                    nam facere voluptatibus totam veritatis. </p>

                                <div class="text-button">
                                    <a href="blog-details.php">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="video-container">
            <div class="video-overlay"></div>
            <div class="video-content">
                <div class="inner">
                    <div class="section-heading">
                        <span>Contact Us</span>
                        <h2>Vivamus nec vehicula felis</h2>
                    </div>
                    <!-- Modal button -->

                    <div class="blue-button">
                        <a href="contact.php">Talk to us</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="popular-places" id="popular">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <span>Testimonials</span>
                            <h2>Lorem ipsum dolor sit amet</h2>
                        </div>
                    </div>
                </div>

                <div class="owl-carousel owl-theme">
                    <div class="item popular-item">
                        <div class="thumb">
                            <img src="img/popular_item_1.jpg" alt="">
                            <div class="text-content">
                                <h4>John Doe</h4>
                                <span>"Lorem ipsum dolor sit amet, consectetur an adipisicing elit. Itaque, corporis
                                    nulla at quia quaerat."</span>
                            </div>
                            <div class="plus-button">
                                <a href="testimonials.php"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="item popular-item">
                        <div class="thumb">
                            <img src="img/popular_item_2.jpg" alt="">
                            <div class="text-content">
                                <h4>John Doe</h4>
                                <span>"Lorem ipsum dolor sit amet, consectetur an adipisicing elit. Itaque, corporis
                                    nulla at quia quaerat."</span>
                            </div>
                            <div class="plus-button">
                                <a href="testimonials.php"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="item popular-item">
                        <div class="thumb">
                            <img src="img/popular_item_3.jpg" alt="">
                            <div class="text-content">
                                <h4>John Doe</h4>
                                <span>"Lorem ipsum dolor sit amet, consectetur an adipisicing elit. Itaque, corporis
                                    nulla at quia quaerat."</span>
                            </div>
                            <div class="plus-button">
                                <a href="testimonials.php"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="item popular-item">
                        <div class="thumb">
                            <img src="img/popular_item_4.jpg" alt="">
                            <div class="text-content">
                                <h4>John Doe</h4>
                                <span>"Lorem ipsum dolor sit amet, consectetur an adipisicing elit. Itaque, corporis
                                    nulla at quia quaerat."</span>
                            </div>
                            <div class="plus-button">
                                <a href="testimonials.php"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="item popular-item">
                        <div class="thumb">
                            <img src="img/popular_item_5.jpg" alt="">
                            <div class="text-content">
                                <h4>John Doe</h4>
                                <span>"Lorem ipsum dolor sit amet, consectetur an adipisicing elit. Itaque, corporis
                                    nulla at quia quaerat."</span>
                            </div>
                            <div class="plus-button">
                                <a href="testimonials.php"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="item popular-item">
                        <div class="thumb">
                            <img src="img/popular_item_1.jpg" alt="">
                            <div class="text-content">
                                <h4>John Doe</h4>
                                <span>"Lorem ipsum dolor sit amet, consectetur an adipisicing elit. Itaque, corporis
                                    nulla at quia quaerat."</span>
                            </div>
                            <div class="plus-button">
                                <a href="testimonials.php"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="item popular-item">
                        <div class="thumb">
                            <img src="img/popular_item_2.jpg" alt="">
                            <div class="text-content">
                                <h4>John Doe</h4>
                                <span>"Lorem ipsum dolor sit amet, consectetur an adipisicing elit. Itaque, corporis
                                    nulla at quia quaerat."</span>
                            </div>
                            <div class="plus-button">
                                <a href="testimonials.php"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
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