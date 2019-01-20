<?php

session_start();
require_once 'core.inc.php';
if (isset($_SESSION['cust_username']) && !empty($_SESSION['cust_username'])) {
    if (isset($_GET['value']) && !empty($_GET['value'])) {
        $meter_id = $_SESSION['cust_username'];
        $value = $_GET['value'];
        $query = "UPDATE meter_table SET user_defined_status='$value' WHERE meter_id = '$meter_id' ";
        $query_run = mysqli_query($mysql_con, $query);
        if ($query_run) {
            //echo 'done';
            header("location: customer.php");
        }
    }else{
        header("location: customer.php");
    }
} else {
    header("location: index.php?msg=You must Log in first");
}
?>
