<?php 
session_start(); 
if (!isset($_SESSION['admin_id'])) {
    header("location:login.php");
    exit();
}
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <h2 class="page-header">Hello, <?php echo htmlspecialchars($admin_name); ?></h2>
      
      <div class="card" style="width:100%;">
        <div class="card-header">
          <h3>Customer Orders</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Order ID</th>
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Transaction ID</th>
                  <th>Payment Status</th>
                  <th>Customer Name</th>
                  <th>Customer Contact</th>
                  <th>Delivery Address</th>
                </tr>
              </thead>
              <tbody id="customer_order_list">
                <tr>
                  <td colspan="10" class="text-center">Loading orders...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include_once("./templates/footer.php"); ?>
<script type="text/javascript" src="js/customer_orders.js"></script>