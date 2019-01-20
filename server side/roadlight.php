<?php

session_start();
require_once 'core.inc.php';
if (isset($_SESSION['admin_username']) && !empty($_SESSION['admin_username'])) {
    if (isset($_GET['value']) && !empty($_GET['value'])) {
        $value = $_GET['value'];
        $query = "UPDATE roadlight SET value='$value' WHERE id = 1 ";
        $query_run = mysqli_query($mysql_con, $query);
        if ($query_run) {
            //echo 'done';
            header("location: controlpanel.php");
        }
    }
} else {
    header("location: adminlogin.php?msg=You must Log in first");
}
?>
