<?php
session_start();
if(!isset($_SESSION["uid"])){
    header("location:index.php");
    exit();
}

// Get transaction ID from URL parameter
$trx_id = isset($_GET['trx_id']) ? $_GET['trx_id'] : 'Unknown';

// Get user information
$cm_user_id = $_SESSION["uid"];
$f_name = $_SESSION["name"];

include_once("db.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>FARMTECH</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <script src="js/jquery2.js"></script>
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="main.js"></script>
        <style>
            table tr td {padding:10px;}
            .success-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
            }
            .success-message {
                flex: 1;
                padding: 20px;
            }
            .animation-container {
                flex: 1;
            }
        </style>
    </head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">	
            <div class="navbar-header">
                <a href="#" class="navbar-brand">FARMTECH</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                <li><a href="profile.php"><span class="glyphicon glyphicon-modal-window"></span>Equipments</a></li>
            </ul>
        </div>
    </div>
    <p><br/></p>
    <p><br/></p>
    <p><br/></p>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#4CAF50; color:white;">
                        <h3>Payment Successful</h3>
                    </div>
                    <div class="panel-body success-container">
                        <div class="animation-container">
                            <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_lc7svuzc.json" background="transparent" speed="1" style="width: 300px; height: 300px;" autoplay></lottie-player>
                        </div>
                        <div class="success-message">
                            <h1>Thank You!</h1>
                            <hr/>
                            <p>Hello <b><?php echo $_SESSION["name"]; ?></b>, your payment process is 
                            successfully completed and your Transaction ID is <b><?php echo $trx_id; ?></b><br/>
                            You can continue your Shopping <br/></p>
                            <a href="index.php" class="btn btn-success btn-lg">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</body>
</html>
