<?php
session_start();
if (!isset($_SESSION["uid"])) {
    header("location:index.php");
    exit();
}
// Use the single, correct database connection
include 'db.php';

$user_id = $_SESSION["uid"];
$total_amount = 0;

// Use the correct connection variable: $con
$sql = "SELECT p.product_price, c.qty FROM products p JOIN cart c ON p.product_id = c.p_id WHERE c.user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $total_amount += $row['product_price'] * $row['qty'];
}
$stmt->close();

if ($total_amount <= 0) {
    header("location:productview.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FARMTECH - Make Payment</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/jquery2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header"><a href="#" class="navbar-brand">FARMTECH</a></div>
        <ul class="nav navbar-nav">
            <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
            <li><a href="productview.php"><span class="glyphicon glyphicon-modal-window"></span> Equipments</a></li>
        </ul>
    </div>
</div>
<p><br/></p><p><br/></p><p><br/></p>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Payment Details</h3></div>
                <div class="panel-body">
                    <h1>Order Summary</h1>
                    <hr/>
                    <h3>Total Amount: <strong class="pull-right">Rs <?php echo number_format($total_amount, 2); ?></strong></h3>
                    <hr/>
                    
                    <h4>Select a Payment Method:</h4>
                    
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#upiModal">
                        Pay with UPI / QR Code
                    </button>
                    
                    <hr>
                    <form action="checkout_process.php" method="POST">
                        <h4>Or Pay with Card</h4>
                        <div class="form-group">
                            <label for="card_name">Name on Card</label>
                            <input type="text" class="form-control" id="card_name" required>
                        </div>
                        <div class="form-group">
                            <label for="card_number">Card Number</label>
                            <input type="text" class="form-control" id="card_number" placeholder="XXXX-XXXX-XXXX-XXXX" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="text" class="form-control" id="expiry_date" placeholder="MM/YY" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cvv">CVV</label>
                                    <input type="text" class="form-control" id="cvv" placeholder="123" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg pull-right">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<div class="modal fade" id="upiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Pay with UPI</h4>
      </div>
      <div class="modal-body" style="text-align: center;">
        <p>Scan the QR code with your favorite UPI app.</p>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=upi://pay?pa=your-upi-id@okhdfcbank" alt="UPI QR Code" class="img-responsive" style="margin: 0 auto;">
        <p style="margin-top: 15px;">Or pay to UPI ID: <strong>your-upi-id@okhdfcbank</strong></p>
        <hr>
        <p>After completing the payment, click the button below.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="checkout_process.php" class="btn btn-success">I Have Paid</a>
      </div>
    </div>
  </div>
</div>

</body>
</html>