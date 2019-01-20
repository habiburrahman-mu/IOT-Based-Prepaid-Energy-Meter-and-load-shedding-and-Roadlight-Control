<?php

session_start();
require_once 'core.inc.php';
if (isset($_SESSION['admin_username']) && !empty($_SESSION['admin_username'])) {
    if (isset($_GET['val']) && !empty($_GET['val'])) {
        $val = $_GET['val'];
        $query = "UPDATE loadshedding SET val='$val' WHERE id = 1";
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
