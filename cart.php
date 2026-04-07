<?php
session_start();
include "db.php"; // Use the correct, existing DB connection

// Check if user is logged in
if (!isset($_SESSION["uid"])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION["uid"];

// Fetch address and mobile for the logged-in user
$sql = "SELECT address1, mobile FROM user_info WHERE user_id = ? LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $current_address = htmlspecialchars($row["address1"]);
    $current_mobile  = htmlspecialchars($row["mobile"]);
} else {
    $current_address = "Not Available";
    $current_mobile  = "Not Available";
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FARMTECH - Cart</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/jquery2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class="wait overlay">
    <div class="loader"></div>
</div>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
                <span class="sr-only">navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">FARMTECH</a>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                <li><a href="productview.php"><span class="glyphicon glyphicon-modal-window"></span>Equipments</a></li>
            </ul>
        </div>
    </div>
</div>
<p><br/></p>
<p><br/></p>
<p><br/></p>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8" id="cart_msg">
            </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">Cart Checkout</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2 col-xs-2"><b>Action</b></div>
                        <div class="col-md-2 col-xs-2"><b>Equipment Image</b></div>
                        <div class="col-md-2 col-xs-2"><b>Equipment Name</b></div>
                        <div class="col-md-2 col-xs-2"><b>Hiring Time(in Hours)</b></div>
                        <div class="col-md-2 col-xs-2"><b>Equipment Cost in Rs(for 1 Hour)</b></div>
                        <div class="col-md-2 col-xs-2"><b>Cost in Rs</b></div>
                    </div>
                    <div id="cart_checkout"></div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Delivery Address</h4>
                            <hr>
                            <form id="address_form" onsubmit="return false;">
                                <div class="form-group">
                                    <div class="radio">
                                        <label><input type="radio" name="address_option" value="current" checked> Use your current address</label>
                                    </div>
                                    <div class="well" style="margin-top: 10px; margin-bottom: 15px; padding: 10px;">
                                        <p><strong>Current Address:</strong> <span id="current_address_display"><?php echo $current_address; ?></span></p>
                                        <p><strong>Mobile:</strong> <span id="current_mobile_display"><?php echo $current_mobile; ?></span></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="radio">
                                        <label><input type="radio" name="address_option" value="new"> Use a different address</label>
                                    </div>
                                    <div id="new_address_form" style="display:none; border: 1px solid #ddd; padding: 15px; margin-top: 10px; border-radius: 4px;">
                                        <div class="form-group">
                                            <label for="address">New Address:</label>
                                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="mobile">New Mobile Number:</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile">
                                        </div>
                                        <button type="button" id="save_address" class="btn btn-primary">Save Address</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="pull-right">
                                    <button type="submit" id="checkout_button" class="btn btn-success btn-lg">Proceed to Checkout</button>
                                </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Your existing script for handling address changes
        $('input[name="address_option"]').change(function() {
            if ($(this).val() === 'new') {
                $('#new_address_form').show();
            } else {
                $('#new_address_form').hide();
            }
        });
        
        // Your existing script for saving a new address
        $('#save_address').click(function() {
            // ... (your existing save address ajax call) ...
        });

        // Add a click handler for the new checkout button
        $("#checkout_button").click(function(event){
    // Prevent the form from submitting in a weird way
    event.preventDefault(); 

    // This is the magic line: it sends the user to your payment script
    window.location.href = "payment.php"; 
});
    });
</script>
</body>
</html>