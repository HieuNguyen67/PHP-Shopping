<?php
// Kết nối đến cơ sở dữ liệu và truy vấn chi tiết sản phẩm
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, 'UTF8');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>