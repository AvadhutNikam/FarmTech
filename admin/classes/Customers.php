<?php
session_start();

// Include database connection
require_once("db.php");

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['status' => 403, 'message' => 'Unauthorized access']);
    exit();
}

// Handle GET_CUSTOMERS request
if (isset($_POST['GET_CUSTOMERS'])) {
    getCustomers($con);
    exit();
}

// Handle GET_CUSTOMER_ORDERS request
if (isset($_POST['GET_CUSTOMER_ORDERS'])) {
    getCustomerOrders($con);
    exit();
}

function getCustomers($con) {
    try {
        $query = "SELECT 
                    user_id,
                    first_name,
                    last_name,
                    email,
                    mobile,
                    address1
                  FROM user_info
                  ORDER BY user_id DESC";
        
        $stmt = $con->prepare($query);
        
        if (!$stmt) {
            echo json_encode([
                'status' => 500,
                'message' => 'Database prepare error: ' . $con->error
            ]);
            return;
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result) {
            echo json_encode([
                'status' => 500,
                'message' => 'Database execution error: ' . $stmt->error
            ]);
            $stmt->close();
            return;
        }
        
        $customers = array();
        
        while ($row = $result->fetch_assoc()) {
            $customers[] = array(
                'user_id' => $row['user_id'],
                'first_name' => $row['first_name'] ? $row['first_name'] : '',
                'last_name' => $row['last_name'] ? $row['last_name'] : '',
                'email' => $row['email'] ? $row['email'] : 'N/A',
                'mobile' => $row['mobile'] ? $row['mobile'] : 'N/A',
                'address1' => $row['address1'] ? $row['address1'] : 'N/A'
            );
        }
        
        echo json_encode([
            'status' => 202,
            'message' => $customers
        ]);
        
        $stmt->close();
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 500,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
}

function getCustomerOrders($con) {
    try {
        $query = "SELECT 
                    o.order_id,
                    o.user_id,
                    o.product_id,
                    o.qty,
                    o.trx_id,
                    o.p_status,
                    p.product_title,
                    u.first_name,
                    u.last_name,
                    u.mobile,
                    u.address1 as order_address
                  FROM orders o
                  LEFT JOIN products p ON o.product_id = p.product_id
                  LEFT JOIN user_info u ON o.user_id = u.user_id
                  ORDER BY o.order_id DESC";
        
        $stmt = $con->prepare($query);
        
        if (!$stmt) {
            echo json_encode([
                'status' => 500,
                'message' => 'Database prepare error: ' . $con->error
            ]);
            return;
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result) {
            echo json_encode([
                'status' => 500,
                'message' => 'Database execution error: ' . $stmt->error
            ]);
            $stmt->close();
            return;
        }
        
        $orders = array();
        
        while ($row = $result->fetch_assoc()) {
            $orders[] = array(
                'order_id' => $row['order_id'],
                'user_id' => $row['user_id'],
                'product_id' => $row['product_id'],
                'product_title' => $row['product_title'] ? $row['product_title'] : 'N/A',
                'qty' => $row['qty'],
                'trx_id' => $row['trx_id'],
                'p_status' => $row['p_status'],
                'first_name' => $row['first_name'] ? $row['first_name'] : '',
                'last_name' => $row['last_name'] ? $row['last_name'] : '',
                'mobile' => $row['mobile'] ? $row['mobile'] : 'N/A',
                'order_address' => $row['order_address'] ? $row['order_address'] : 'N/A'
            );
        }
        
        echo json_encode([
            'status' => 202,
            'message' => $orders
        ]);
        
        $stmt->close();
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 500,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
}

$con->close();
?>