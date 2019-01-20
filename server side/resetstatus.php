<?php

require_once 'core.inc.php';


$query = "SELECT meter_id,reset_state FROM reset_table";
$query_run = mysqli_query($mysql_con, $query);
if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        echo $meter_id = $row['meter_id'];
        $reset_state = $row['reset_state'];
        printf("Msg:%d", $reset_state);
        
        echo "<br>";
    }
}

