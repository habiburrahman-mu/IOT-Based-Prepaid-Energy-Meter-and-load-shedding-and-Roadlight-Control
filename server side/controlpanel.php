<?php
session_start();
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
    $query = "SELECT val FROM loadshedding WHERE id=1";
    $query_run = mysqli_query($mysql_con, $query);
    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $loadShedding = $row['val'];
        }
    }
    $query = "SELECT value FROM roadlight WHERE id=1";
    $query_run = mysqli_query($mysql_con, $query);
    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $roadlight = $row['value'];
        }
    }

    function giveLoadSheddingData($num) {
        if ($num == 1) {
            return "Area 1";
        } else if ($num == 2) {
            return "Area 2";
        } else if ($num == 3) {
            return "Area 3";
        } else if ($num == 4) {
            return "Area 4";
        } else if ($num == 5) {
            return "None";
        } else if ($num == 6) {
            return "Area 1, Area 2, Area 3, Area 4";
        }
    }

    function loadSheddingClass($num) {
        global $loadShedding;
        if ($loadShedding == $num)
            return " btn-danger disabled";
        else
            return " btn-success ";
    }

    function loadSheddingCSupplyData($num) {
        global $loadShedding;
        if ($loadShedding == $num || $loadShedding == 6)
            return "Supply Off";
        else
            return "Supply on";
    }

    function roadLightgiveData() {
        global $roadlight;
        if ($roadlight == 1)
            return "Off";
        else
            return "On";
    }

    function roadLightgiveReverse() {
        global $roadlight;
        if ($roadlight == 1)
            return 2;
        else
            return 1;
    }

    function roadLightgiveClass() {
        global $roadlight;
        if ($roadlight == 1)
            return " btn-danger ";
        else
            return " btn-success ";
    }

} else {
    header("location: adminlogin.php?msg=You must Log in first");
}
?>
<html lang="en">
    <head>
        <title>Admin Control Panel</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
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
                        <li class="nav-item active">
                            <a class="nav-link" href="controlpanel.php">Control Panel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="rechargelog.php">Recharge Log</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        </div>
        <div class="jumbotron " style="margin-bottom: -5%">
            <h3 class="display-4" style="text-align: center">Control Panel</h3>
            <h3 style="text-align: center">Current Status</h3>
            <p style="text-align: center">Load Shedding in: <?php echo giveLoadSheddingData($loadShedding) ?> <br>
                Road Light : <?php echo roadLightgiveData() ?>
            </p>

        </div>
        <div class="row" >
            <div class="col-md-7">
                <div class="container" style=" max-width: 600px;min-height: 278px; background-color: rgba(124, 132, 140, 0.15); padding: 2%">
                    <h4 style="text-align: center">Load Shedding Control</h4><br>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn <?php echo loadSheddingClass(1); ?> btn-lg btn-block" href="loadshedding.php?val=1" role="button">Area 1 : <?php echo loadSheddingCSupplyData(1); ?></a>
                            <a class="btn <?php echo loadSheddingClass(2); ?> btn-lg btn-block" href="loadshedding.php?val=2" role="button">Area 2 : <?php echo loadSheddingCSupplyData(2); ?></a>
                            <a class="btn <?php echo loadSheddingClass(3); ?> btn-lg btn-block" href="loadshedding.php?val=3" role="button">Area 3 : <?php echo loadSheddingCSupplyData(3); ?></a>
                            <a class="btn <?php echo loadSheddingClass(4); ?> btn-lg btn-block" href="loadshedding.php?val=4" role="button">Area 4 : <?php echo loadSheddingCSupplyData(4); ?></a>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary btn-lg btn-block <?php if ($loadShedding == 5) echo "disabled"; ?>" href="loadshedding.php?val=5" role="button">All Supply On</a>
                            <a class="btn <?php echo loadSheddingClass(6); ?> btn-lg btn-block" href="loadshedding.php?val=6" role="button">All Supply Off</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="container" style=" max-width: 600px;min-height: 307px;background-color: rgba(124, 132, 140, 0.15); padding: 2%">
                    <h4 style="text-align: center">Road Light Control</h4><br><br>
                    <a class="btn <?php echo roadLightgiveClass() ?> btn-lg btn-block" href="roadlight.php?value=<?php echo roadLightgiveReverse() ?>" role="button">Road Light : <?php echo roadLightgiveData() ?></a>
                </div>
            </div>

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