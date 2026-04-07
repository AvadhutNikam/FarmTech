<?php
// THIS MUST BE THE VERY FIRST LINE
session_start(); 

// Now include the database connection
include_once("db.php");

// Check if the user is logged in
if (!isset($_SESSION["uid"])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION["uid"];
$trx_id = uniqid("TRX_");
$p_status = "completed";

// Use the correct connection variable: $con
$cart_query = "SELECT p_id, qty FROM cart WHERE user_id = ?";
$stmt_cart = mysqli_prepare($con, $cart_query);
mysqli_stmt_bind_param($stmt_cart, "i", $user_id);
mysqli_stmt_execute($stmt_cart);
$cart_result = mysqli_stmt_get_result($stmt_cart);

if (mysqli_num_rows($cart_result) == 0) {
    echo "<h1>Your cart is empty.</h1><p>Please add items to your cart before checking out.</p><a href='productview.php' class='btn btn-primary'>Continue Shopping</a>";
    exit();
}

$cart_items = array();
while ($cart_row = mysqli_fetch_assoc($cart_result)) {
    $cart_items[] = $cart_row;
}

mysqli_begin_transaction($con);

try {
    $order_query = "INSERT INTO orders (user_id, product_id, qty, trx_id, p_status) VALUES (?, ?, ?, ?, ?)";
    $stmt_order = mysqli_prepare($con, $order_query);

    foreach ($cart_items as $cart_item) {
        $product_id = $cart_item["p_id"];
        $qty = $cart_item["qty"];
        mysqli_stmt_bind_param($stmt_order, "iiiss", $user_id, $product_id, $qty, $trx_id, $p_status);
        if (!mysqli_stmt_execute($stmt_order)) {
            throw new Exception("Error inserting order: " . mysqli_stmt_error($stmt_order));
        }
    }
    
    $clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
    $stmt_clear = mysqli_prepare($con, $clear_cart_query);
    mysqli_stmt_bind_param($stmt_clear, "i", $user_id);
    if (!mysqli_stmt_execute($stmt_clear)) {
        throw new Exception("Error clearing cart: " . mysqli_stmt_error($stmt_clear));
    }
    
    mysqli_commit($con);
    
    header("Location: payment_success.php?trx_id=$trx_id");
    exit();
    
} catch (Exception $e) {
    mysqli_rollback($con);
    echo "<h1>Transaction Failed</h1>";
    echo "<p>An error occurred: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<a href='cart.php' class='btn btn-primary'>Return to Cart</a>";
    exit();
}
?>