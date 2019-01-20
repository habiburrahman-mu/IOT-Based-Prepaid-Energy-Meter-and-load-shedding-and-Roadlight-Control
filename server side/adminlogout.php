<?php
session_start();
if(isset($_SESSION['admin_username']) && !empty($_SESSION['admin_username'])){
    $_SESSION = array();
    session_destroy();
    header("location: adminlogin.php?msg=Logged Out Successfully");
}else{
    header("location: adminlogin?msg=You must login first");
}