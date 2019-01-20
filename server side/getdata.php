<?php

require_once 'core.inc.php';

if (isset($_GET['user']) && isset($_GET['pass']) && isset($_GET['kwh'])) {
    $username = $_GET['user'];
    $password = $_GET['pass'];
    $kwh = $_GET['kwh'];

    if (!empty($username) && !empty($password)) {
        $query = "SELECT id, kwh FROM meter_table WHERE meter_id='$username' AND meter_pass='$password'";
        $query_run = mysqli_query($mysql_con, $query);
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                $id = $row['id'];
                $kwh_prev = $row['kwh'];
                $time_now = time();
                $sql = "UPDATE meter_table SET time='$time_now', kwh='$kwh' WHERE id='$id'";
                // Execute SQL statement
                mysqli_query($mysql_con, $sql);
            }
        }
    }
}
