<html>
    <head>
        <?php
        $page = $_SERVER['PHP_SELF'];
        $sec = 5;
        //header("Refresh: $sec; url=$page");
        ?>
        <title>Customer Panel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
        <style type="text/css">
            @media print
            {
                .no-print {display:none;}
            }
        </style>
    </head>
    <?php
    session_start();
    require_once 'core.inc.php';
    if (isset($_SESSION['cust_username']) && !empty($_SESSION['cust_username'])) {
        $username = $_SESSION['cust_username'];
        $query = "SELECT id, name, address, phone FROM user_table WHERE meter_id='$username' ";
        $query_run = mysqli_query($mysql_con, $query);
        while ($row = mysqli_fetch_assoc($query_run)) {
            $name = $row['name'];
            $address = $row['address'];
            $phone = $row['phone'];
        }
        $query = "SELECT time, kwh, user_defined_status FROM meter_table WHERE meter_id='$username' ";
        $query_run = mysqli_query($mysql_con, $query);
        while ($row = mysqli_fetch_assoc($query_run)) {
            $time = $row['time'];
            $kwh = $row['kwh'];
            $user_defined_status = $row['user_defined_status'];
            $state = state($time);
            $color = state_color($time);
        }
        $query = "SELECT id, balance FROM balance_table WHERE meter_id='$username'";
        $query_run = mysqli_query($mysql_con, $query);
        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                $balance = $row['balance'];
            }
        }
        function statusgiveData() {
        global $user_defined_status;
        if ($user_defined_status == 1)
            return "Off";
        else
            return "On";
    }

    function statusgiveReverse() {
        global $user_defined_status;
        if ($user_defined_status == 1)
            return 2;
        else
            return 1;
    }

    function statusgiveClass() {
        global $user_defined_status;
        if ($user_defined_status == 1)
            return " btn-danger ";
        else
            return " btn-success ";
    }
    } else {
        header("location: index.php?msg=You must Log in first");
    }
    ?>
    <body>
        <h3 style="text-align: right">Automated Electric Bill System</h3>
        <hr style="height: 4px; margin-left: 0px; margin-bottom:-3px; background-image: -webkit-linear-gradient(right, rgba(66,133,244,.8), rgba(66, 133, 244,.6), rgba(0,0,0,0));">
        <?php
        $rem_balance = $balance - ($kwh * $charge);
        ?>
        <div class="card container-fluid bg-light">
            <div class="card-body ">
                <h2 style="text-align: center">Remaining Balance: <?php global $rem_balancebalance;
        printf("%.2f", $rem_balance) ?> BDT
                    &nbsp;&nbsp;<a href="recharge.php" target="_blank" class="btn btn-outline-success btn-sm" role="button">Recharge</a>
                </h2>
            </div>
        </div>
        <div class="jumbotron">
            <?php
            if (isset($_GET['msg']) && !empty($_GET['msg'])) {
                ?>
                <div class="alert alert-danger alert-dismissible fade show no-print" role="alert" style="text-align: center;">
                    <strong><?php echo $_GET['msg'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <h2>Consumer Information</h2>
                    <table class="table">
                        <tr>
                            <td align="right"><img src="<?php echo "img/" . $username . ".jpg" ?>" height="100px" width="100px" ></td>
                        </tr>
                        <tr>
                            <td><b>Consumer Name:</b></td>
                            <td><?php echo $name; ?> &nbsp;&nbsp;&nbsp;<div class="btn-group btn-group-sm no-print"><a href="logout.php" class="btn btn-outline-danger" role="button">Logout</a></div></td>
                        </tr>
                        <tr>
                            <td><b>Service Address:</b></td>
                            <td> <?php echo $address; ?></td>
                        </tr>
                        <tr>
                            <td><b>Phone No.:</b></td>
                            <td> <?php echo $phone; ?></td>
                        </tr>
                        <tr>
                            <td><b>Meter Id:</b></td>
                            <td> <?php echo $username; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6 no-print">
                    <div class="container-fluid">
                        <h2>Meter Information</h2>
                        <table class="table">
                            <tr>
                                <th scope="col">Meter Id</th>
                                <td><?php echo $username; ?></td>
                            </tr>
                            <tr>
                                <th scope="col">Status</th>
                                <td style="color: <?php echo $color; ?>"><?php echo $state; ?></td>
                            </tr>
                            <tr>
                                <th scope="col">Last Reading Time</th>
                                <td><?php echo date("Y-m-d h:i:sA", $time); ?></td>
                            </tr>
                            <tr>
                                <th scope="col">Reading Type</th>
                                <td>Tot KWh</td>
                            </tr>
                            <tr>
                                <th scope="col">Meter Reading</th>
                                    <?php $kwh ?>
                                <td><?php printf("%.2f", $kwh); ?> KWh</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-10">
                        <div class="container" style=" background-color: rgba(124, 132, 140, 0.15); padding: 2%">
                            <h4 style="text-align: center">Load Control</h4>
                            <a class="btn <?php echo statusgiveClass() ?> btn-lg btn-block" href="user_defined_status.php?value=<?php echo statusgiveReverse() ?>" role="button">Load : <?php echo statusgiveData() ?></a>
                        </div>
                    </div>
                </div>   
            </div>
        </div>

        <div class="alert alert-info no-print" role="alert">
            <div class="container">
                <h4>Emergency & Repair</h4>
                <h2>856974</h2>
                <p>This is the number to call to report power outages and safety hazards related to Electric Equipment</p>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script>
            function myFunction() {
                window.print();
            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>
</html>
