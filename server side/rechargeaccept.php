<?php

require_once 'core.inc.php';
//session_start();
if (isset($_SESSION['admin_username']) && !empty($_SESSION['admin_username'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (!empty($id)) {
            $query = "SELECT meter_id, amount FROM recharge_log WHERE id='$id' ";
            $query_run = mysqli_query($mysql_con, $query);
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $meter_id = $row['meter_id'];
                    $amount = $row['amount'];
                    $query = "SELECT balance FROM balance_table WHERE meter_id='$meter_id' ";
                    $query_run = mysqli_query($mysql_con, $query);
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($balance_row = mysqli_fetch_assoc($query_run)) {
                            $balance = $balance_row['balance'];
                            $balance = $balance + $amount;
                            $query = "UPDATE balance_table SET balance='$balance' WHERE meter_id='$meter_id' ";
                            $query_run = mysqli_query($mysql_con, $query);
                            if ($query_run) {
                                $query = "DELETE FROM recharge_log WHERE id='$id'";
                                $query_run = mysqli_query($mysql_con, $query);
                                if ($query_run) {
                                    header("location: rechargelog.php");
                                }
                                header("location: rechargelog.php");
                            }
                            header("location: rechargelog.php");
                        }
                    }
                    header("location: rechargelog.php");
                }
            } else {
                header("location: rechargelog.php");
            }
        }
    }
} else {
    header("location: adminlogin?msg=You must login first");
}