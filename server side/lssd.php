<?php

require_once 'core.inc.php';
$query = "SELECT val FROM loadshedding WHERE id=1";
$query_run = mysqli_query($mysql_con, $query);
if (mysqli_num_rows($query_run) > 0) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $loadShedding = $row['val'];
    }
}
echo "Msg:".$loadShedding;