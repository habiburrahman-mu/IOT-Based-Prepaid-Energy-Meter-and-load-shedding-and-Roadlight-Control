<?php
session_start();
if(isset($_SESSION['cust_username']) && !empty($_SESSION['cust_username'])){
    $_SESSION = array();
    session_destroy();
    header("location: index.php?msg=Logged Out Successfully");
}else{
    header("location: index.php?msg=You must login first");
}