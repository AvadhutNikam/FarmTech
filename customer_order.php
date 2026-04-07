<?php
session_start();
if (!isset($_SESSION["uid"])) {
    header("location:index.php");
    exit();
}

include_once("db.php");

// Ensure database connection is established
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION["uid"];

// Fetch user's orders with address information using prepared statement
$orders_list = "SELECT o.order_id, o.user_id, o.product_id, o.qty, o.trx_id, o.p_status, 
                o.order_address, o.order_date, p.product_title, p.product_price, p.product_image 
                FROM orders o 
                INNER JOIN products p ON o.product_id = p.product_id 
                WHERE o.user_id = ?
                ORDER BY o.order_date DESC"; // Added order date sorting

$stmt = mysqli_prepare($con, $orders_list);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);

// Debugging: Check if the query fetched any results
if (!$query) {
    die("Query Failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FARMTECH - Orders</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/jquery2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="main.js"></script>
    <style>
        table tr td { padding: 10px; }
        .order-item { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">    
            <div class="navbar-header">
                <a href="#" class="navbar-brand">FARMTECH</a>
            </div>
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
                    <div class="panel-heading">
                        <h2>Customer Order Details</h2>
                    </div>
                    <div class="panel-body">
                        <?php
                        if (mysqli_num_rows($query) > 0) {
                            $current_trx = '';
                            while ($row = mysqli_fetch_array($query)) {
                                // Group orders by transaction ID
                                if ($current_trx != $row['trx_id']) {
                                    if ($current_trx != '') {
                                        echo '</div>'; // Close previous transaction group
                                    }
                                    echo '<div class="transaction-group" style="margin-bottom: 40px;">';
                                    echo '<h4>Transaction #: ' . $row['trx_id'] . '</h4>';
                                    echo '<p>Order Date: ' . date('M j, Y g:i A', strtotime($row['order_date'])) . '</p>';
                                    $current_trx = $row['trx_id'];
                                }
                        ?>
                                <div class="order-item">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="product_images/<?php echo $row['product_image']; ?>" 
                                                 class="img-responsive img-thumbnail"/>
                                        </div>
                                        <div class="col-md-8">
                                            <table class="table">
                                                <tr><td><strong>Equipment Name:</strong></td><td><?php echo $row["product_title"]; ?></td></tr>
                                                <tr><td><strong>Equipment Cost:</strong></td><td><?php echo "Rs " . $row["product_price"]; ?></td></tr>
                                                <tr><td><strong>Hiring Time (in Hrs):</strong></td><td><?php echo $row["qty"]; ?></td></tr>
                                                <tr><td><strong>Payment Status:</strong></td><td><?php echo ucfirst($row["p_status"]); ?></td></tr>
                                                <?php if (!empty($row["order_address"])): ?>
                                                <tr><td><strong>Delivery Address:</strong></td><td><?php echo $row["order_address"]; ?></td></tr>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                            echo '</div>'; // Close last transaction group
                        } else {
                            echo "<div class='alert alert-info text-center'>No orders found!</div>";
                        }
                        ?>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="productview.php" class="btn btn-primary">Shop More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</body>
</html>