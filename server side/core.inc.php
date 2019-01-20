<?php
require 'connect.inc.php';
date_default_timezone_set("Asia/Dhaka");
ob_start();
global $charge;
$charge = 5;
if (!isset($_SESSION)) {
    session_start();
}

function loggedin() {
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}

function getuserfield($field) {
    global $mysql_con;
    $id = $_SESSION['username'];
    $sql = "SELECT $field FROM users WHERE id=$id";
    if ($query_run = mysqli_query($mysql_con, $sql)) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $final_res = $row[$field];
        }
        return $final_res;
    }
}
function state($time)
{
    $time_now = time();
    if( ($time_now-$time) > 1*60)
    {
        return $state = "Disconnected";
    } else{
        return $state = "Connected";
    }
}
function state_color($time)
{
    $time_now = time();
    if( ($time_now-$time) > 1*60)
    {
        return $color='red';
    } else{
        return $color='green';
    }
}
function tr_color($time)
{
    $time_now = time();
    if( ($time_now-$time) > 1*60)
    {
        return "bg-danger";
    } else{
        return "bg-success";
    }
}