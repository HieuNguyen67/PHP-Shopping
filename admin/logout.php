<?php
session_start();



$keep_variables = array('user_id', 'username'); // Thêm các biến session bạn muốn giữ lại

foreach ($_SESSION as $key => $value) {
    if (!in_array($key, $keep_variables)) {
        unset($_SESSION[$key]);
    }
}


header("Location: index.php");
exit();
?>