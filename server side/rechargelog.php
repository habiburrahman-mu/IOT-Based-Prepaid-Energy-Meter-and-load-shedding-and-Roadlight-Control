<html>
    <head>
        <?php
        $page = $_SERVER['PHP_SELF'];
        session_start();
        $num=0;
        require_once 'core.inc.php';
        if (isset($_SESSION['admin_username']) && !empty($_SESSION['admin_username'])) {
            $username = $_SESSION['admin_username'];
            $query = "SELECT name FROM admin_table WHERE username='$username'";
            $query_run = mysqli_query($mysql_con, $query);
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $name = $row['name'];
                }
            }
        } else {
            header("location: adminlogin.php?msg=You must Log in first");
        }
        ?>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <div class="col-lg-6" style="color: white;">
                    <span class="lead"> Logged in as <b><?php echo $name; ?></b></span>
                    <div class="btn-group btn-group-sm">
                        <a href="adminlogout.php" class="btn btn-sm btn-danger" role="button">Logout</a>
                    </div>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample07">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ">
                            <a class="nav-link" href="live.php">Live <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="controlpanel.php">Control Panel</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link " href="rechargelog.php">Recharge Log</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav><br>
        <?php
        if (isset($_GET['msg']) && !empty($_GET['msg'])) {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="text-align: center;">
                <strong><?php echo $_GET['msg'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <?php
        }
        ?>
        <h3 class="display-4" style="text-align: center">Recharge Log</h3>
        <div class="container">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">Meter Id</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Tx Id</th>
                        <th scope="col">Mobile No</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM recharge_log";
                    $query_run = mysqli_query($mysql_con, $query);
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        $num++;
                        echo '<tr class="bg-primary">';
                        $meter_id = $row['meter_id'];
                        echo '<td><a class="btn btn-sm btn btn-outline-light" role="button" style="text-decoration: none;" href="customerlive.php?meter_id=' . $meter_id . '">' . $row['meter_id'] . '</a></td>';
                        echo '<td>' . $row['method'] . '</td>';
                        echo '<td>' . $row['tx_id'] . '</td>';

                        echo '<td>'.$row['mobile'].'</td>';    
                        echo '<td>' . $row['amount'] . '</td>';
                        $id = $row['id'];
                        ?>
                <td>
                    <a class="btn btn-success btn-sm" href="rechargeaccept.php?id=<?php echo $id ?>" role="button">Accept</a>
                    <a class="btn btn-danger btn-sm" href="rechargereject.php?id=<?php echo $id ?>" role="button">Reject</a>
                </td>
                <?php
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
    <head> <title>Recharge Log<?php if($num!=0){echo '('.$num.')';} ?></title> </head>
</html>