<?php

require_once 'core.inc.php';


$query = "SELECT meter_id,balance FROM balance_table";
$query_run = mysqli_query($mysql_con, $query);
if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        echo $meter_id = $row['meter_id'];
        $query = "SELECT kwh, user_defined_status FROM meter_table WHERE meter_id='$meter_id' ";
        $query_run_kwh = mysqli_query($mysql_con, $query);
        if (mysqli_num_rows($query_run_kwh) > 0)
        {
            while ($kwh_row = mysqli_fetch_assoc($query_run_kwh)) {
                $kwh = $kwh_row['kwh'];
                $user_defined_status = $kwh_row['user_defined_status'];
            }
        }
        $rem_balance = $row['balance']-($kwh*$charge);
        if ($rem_balance > 50 && $user_defined_status==2) {
            $state = 1;
        } else {
            $state = 0;
        }
        printf("Msg:%d", $state);
        echo "<br>";
    }
}