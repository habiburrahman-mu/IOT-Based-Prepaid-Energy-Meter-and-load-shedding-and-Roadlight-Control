<?php
if (isset($_GET['meter_id']) && !empty($_GET['meter_id'])) {
    $username = $_GET['meter_id'];
}
?>
<html>
    <head>
        <title><?php echo "Meter: " . $username; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
    </head>
    <?php
    session_start();
    require_once 'core.inc.php';
    if (isset($_SESSION['admin_username']) && !empty($_SESSION['admin_username'])) {
        if (isset($_GET['meter_id']) && !empty($_GET['meter_id'])) {

            $query = "SELECT id, name, address, phone FROM user_table WHERE meter_id='$username' ";
            $query_run = mysqli_query($mysql_con, $query);
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $name = $row['name'];
                    $address = $row['address'];
                    $phone = $row['phone'];
                }
            } else {
                echo 'Wrong Meter Id';
                die();
            }

            $query = "SELECT time, kwh, user_defined_status FROM meter_table WHERE meter_id='$username' ";
            $query_run = mysqli_query($mysql_con, $query);
            while ($row = mysqli_fetch_assoc($query_run)) {
                $time = $row['time'];
                $kwh = $row['kwh'];
                $state = state($time);
                $color = state_color($time);
                $user_defined_status = $row['user_defined_status'];
                if ($user_defined_status == 1) {
                    $user_status = "Off";
                } else if ($user_defined_status == 2) {
                    $user_status = "On";
                }
            }
            $query = "SELECT id, balance FROM balance_table WHERE meter_id='$username'";
            $query_run = mysqli_query($mysql_con, $query);
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_assoc($query_run)) {
                    $balance = $row['balance'];
                }
            }
        } else {
            header("location: live.php");
        }
    } else {
        header("location: adminlogin.php?msg=You must Log in first");
    }
    ?>
    <body>
        <h3 style="text-align: right">Automated Electric Bill System</h3>
        <hr style="height: 4px; margin-left: 0px; margin-bottom:-3px; background-image: -webkit-linear-gradient(right, rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.37), rgba(0, 0, 0, 0.52));">


        <div class="jumbotron">
            <div class="col-lg-6" style="text-align: right">
                <a class="btn btn-outline-dark btn-sm" href="live.php" role="button">Back</a>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <h2>Consumer Information</h2>
                    <table class="table">
                        <tr>
                            <td align="right"><img src="<?php echo "img/" . $username . ".jpg" ?>" height="100px" width="100px" ></td>
                        </tr>
                        <tr>
                            <td><b>Consumer Name:</b></td>
                            <td><?php echo $name; ?></td>
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
                            <tr>
                                <th scope="col">Status By User</th>
                                <td><?php global $user_status;
                                echo $user_status; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>   
            </div>
        </div>
        <?php
        global $balance;
        $rem_balance = $balance - ($kwh * $charge);
        ?>
        <div class="card container-fluid bg-light">
            <div class="card-body ">
                <h2 style="text-align: center">Remaining Balance: <?php
                    global $rem_balancebalance;
                    printf("%.2f", $rem_balance)
                    ?> BDT
                    &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-sm btn-outline-success no-print" onclick="myFunction()"><img src="bootstrap/print.png" height="15px" width="15px"> Print </button>
                </h2>
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
