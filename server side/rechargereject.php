<?php

require_once 'core.inc.php';
//session_start();
if (isset($_SESSION['admin_username']) && !empty($_SESSION['admin_username'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (!empty($id)) {

            $query = "DELETE FROM recharge_log WHERE id='$id'";
            $query_run = mysqli_query($mysql_con, $query);
            if ($query_run) {
                header("location: rechargelog.php");
            } else {
                header("location: rechargelog.php");
            }
        }
    }
} else {
    header("location: adminlogin?msg=You must login first");
}