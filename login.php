<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

include("./ConnectDB/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST["identifier"];
    $password = $_POST["password"];

    $identifier = htmlspecialchars($identifier);
    $password = htmlspecialchars($password);

    try {
        $query = "SELECT * FROM users WHERE (username=:identifier OR email=:identifier) AND password=:password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':identifier', $identifier);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin đăng nhập.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

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
                                <li class='active'><a href="./login.php">Đăng nhập</a></li>
                                <li><a href="./dangky.php">Đăng ký</a></li>
                            </ul>
                        </nav><!-- / #primary-nav -->
                    </div>
                </div>
            </div>
        </header>
        <div class="container ">
            <br class="" />
            <form class="mt-5 " method="POST" action="">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fs-2">Username hoặc email</label>
                    <input class="form-control" aria-describedby="emailHelp" name="identifier" required>
                    <div id="emailHelp" class="form-text fs-5">Chúng tôi sẽ không bao giờ chia sẻ email của bạn với bất
                        kỳ ai khác.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label  fs-2">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary p-4 fs-4">Đăng nhập</button>
            </form>
            <?php if (isset($error_message)) {
                echo '<p style="color:red;">' . $error_message . '</p>';
            } ?>

        </div>
    </div>


</body>

</html>