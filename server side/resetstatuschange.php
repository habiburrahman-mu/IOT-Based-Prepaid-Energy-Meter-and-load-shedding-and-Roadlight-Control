<?php
require_once 'core.inc.php';

if( isset($_GET['user']) && isset($_GET['pass']) && isset($_GET['reset'])){
    $username = $_GET['user'];
    $password = $_GET['pass'];
    $reset=$_GET['reset'];
    
    if (!empty($username) && !empty($password)) {
        $query = "SELECT id FROM reset_table WHERE meter_id='$username' AND meter_pass='$password'";
        $query_run = mysqli_query($mysql_con, $query);
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                $id = $row['id'];
                $sql = "UPDATE reset_table SET reset_state='$reset' WHERE id='$id' ";
                // Execute SQL statement
                mysqli_query($mysql_con, $sql);
            }
            $sql = "UPDATE meter_table SET kwh='0' WHERE meter_id='$username' ";
            mysqli_query($mysql_con, $sql);
        }
    }
}
