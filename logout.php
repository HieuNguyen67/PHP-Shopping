<?php
session_start();



$keep_variables = array('admin_id', 'adminname'); 

foreach ($_SESSION as $key => $value) {
    if (!in_array($key, $keep_variables)) {
        unset($_SESSION[$key]);
    }
}


header("Location: index.php");
exit();
?>