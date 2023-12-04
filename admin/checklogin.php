<?php
session_start();

// Kiểm tra nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
if (!isset($_SESSION["admin_id"])) {
    header("Location: index.php");
    exit();
}
?>