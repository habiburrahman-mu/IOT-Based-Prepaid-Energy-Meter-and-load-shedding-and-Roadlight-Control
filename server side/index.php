<?php
require_once 'core.inc.php';
if (isset($_SESSION['cust_username'])) {
    header("location: customer.php?msg=You're Already logged in");
}
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Enter Your Meter Id</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    </head>
    <body>
        <div class="jumbotron">
            <h2 class="display-3" style="text-align: center">Automated Electric Bill System</h2>
        </div>

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
        <div class="container" style=" max-width: 400px; background-color:rgba(47, 42, 117, 0.02); padding: 1%">

            <a href="recharge.php" target="_blank" class="btn btn-lg btn-primary btn-block" role="button">Recharge Now</a>

            <form class="form-signin" method="POST" action="">
                <br>
                <h3 class="form-signin-heading" style="text-align: center">Please Enter Meter Id & Password</h3>
                <label for="inputEmail" class="sr-only">Meter Id</label>
                <input id="inputEmail" class="form-control" required autofocus name="user" type="number" placeholder="Please Enter your Meter ID">
                <br>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="inputPassword" class="form-control" required name="pass" placeholder="Please Enter Your User Password">
                <br>
                <input class="btn btn-lg btn-outline-success btn-block" type="submit" name="submit">
                <br>
            </form>
        </div>
        <?php
        if (isset($_POST['submit']) && isset($_POST['user']) && isset($_POST['pass'])) {
            $username = $_POST['user'];
            $password = $_POST['pass'];
            if (!empty($username) && !empty($password)) {
                $query = "SELECT meter_id FROM user_table WHERE meter_id='$username' AND password='$password' ";
                $query_run = mysqli_query($mysql_con, $query);
                if (mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        $_SESSION['cust_username'] = $username;
                        header("location: customer.php");
                    }
                } else {
                    header("location: index.php?msg=Wrong Meter Id or Password");
                }
            } else {
                header("location: index.php?msg=Meter Id or Password cannot be empty");
            }
        }
        ?>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    </body>
</html>