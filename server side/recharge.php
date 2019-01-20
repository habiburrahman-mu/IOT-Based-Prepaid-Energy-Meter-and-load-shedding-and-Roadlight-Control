<?php
require_once 'core.inc.php';
?>
<html lang="en">
    <head>
        <title>Recharge</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    </head>
    <body>
        <div class="jumbotron ">
            <h3 class="display-4" style="text-align: center">Recharge</h3>
            <div style="text-align: center">
                <a href="index.php" class="btn btn-outline-success btn-lg" role="button">Home Page</a>
            </div>
            
        </div>
        <?php
        if (isset($_GET['meter_id']) && isset($_GET['method']) && isset($_GET['tx_id']) && isset($_GET['mobile']) && isset($_GET['mobile']) && isset($_GET['amount']) && isset($_GET['submit'])) {
            $meter_id = $_GET['meter_id'];
            $method = $_GET['method'];
            $tx_id = $_GET['tx_id'];
            $mobile = $_GET['mobile'];
            $amount = $_GET['amount'];

            if (!empty($meter_id) && !empty($amount) && !empty($tx_id) && !empty($mobile) && !empty($method)) {
                $query = "INSERT INTO recharge_log (meter_id, method, tx_id, mobile, amount) VALUES ('$meter_id', '$method', '$tx_id', '$mobile', '$amount');";
                $query_run = mysqli_query($mysql_con, $query);
                if ($query_run) {
                    ?>
                    <div class="container col-md-6">
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <p style="text-align: center">
                                <?php
                                echo "<i>Meter Id: " . $meter_id . "<br>";
                                echo "Tx Id: " . $tx_id . "<br>";
                                echo "Amount: " . $amount . "<br></i>";
                                echo '<b>Payment in Queue</b>';
                                ?>
                            </p>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?php
                        }
                    } else {
                        echo 'Please submit all data<br>';
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="container" style=" max-width: 600px; background-color:rgba(47, 42, 117, 0.02)">
            <form class="form-signin" method="GET" action="">
                <br>
                <label class="sr-only">Meter Id:</label>
                <input class="form-control" required autofocus name="meter_id" type="text" placeholder="Meter ID">
                <br>
                <label class="sr-only">Payment Method:</label>
                <select type="text" class="form-control" name="method" >
                    <option value="Bkash">Bkash</option>
                    <option value="Rocket">Rocket</option>
                    
                </select>
                <br>
                <label class="sr-only">Tx Id</label>
                <input type="text" class="form-control" required name="tx_id" placeholder="Tx ID">
                <br>
                <label class="sr-only">Mobile No.</label>
                <input type="text" class="form-control" required name="mobile" placeholder="Mobile No.">
                <br>
                <label class="sr-only">Amount</label>
                <input type="text" class="form-control" required name="amount" placeholder="Amount(min 100)">
                <br>
                <input class="btn btn-lg btn-outline-success btn-block" type="submit" name="submit">
                <input class="btn btn-lg btn-outline-dark btn-block" type="reset" name="submit">
                <br>
            </form>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>



    </div>
</body>
</html>