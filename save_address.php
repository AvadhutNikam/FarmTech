<?php
session_start();
include "db.php";  // make sure db.php is in the same folder

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION["uid"])) {
    echo json_encode([
        "status" => "error",
        "message" => "User not logged in"
    ]);
    exit();
}

// Check if form data is sent
if (isset($_POST['address']) && isset($_POST['mobile'])) {
    $user_id = $_SESSION["uid"];
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $mobile  = mysqli_real_escape_string($con, $_POST['mobile']);

    // Update user_info table
    $sql = "UPDATE user_info SET address1 = '$address', mobile = '$mobile' WHERE user_id = '$user_id'";
    if (mysqli_query($con, $sql)) {
        echo json_encode([
            "status" => "success",
            "message" => "Address updated successfully!",
            "address" => $address,
            "mobile"  => $mobile
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database error: " . mysqli_error($con)
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request"
    ]);
}
?>
