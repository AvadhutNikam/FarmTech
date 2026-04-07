<?php
// AFTER (This is the fix)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("Admin.php");

if (isset($_POST["admin_register"])) {
    
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($name == "" || $email == "" || $password == "") {
        echo json_encode(["status" => 303, "message" => "All fields are required"]);
        exit();
    }

    // Check if email already exists
    $admin = new Admin();
    if ($admin->adminExists($email)) {
        echo json_encode(["status" => 303, "message" => "Email already registered"]);
        exit();
    }

    // Store password as plain text (NO HASH)
    $res = $admin->registerAdmin($name, $email, $password);

    if ($res) {
        echo json_encode(["status" => 202, "message" => "Admin registered successfully"]);
    } else {
        echo json_encode(["status" => 303, "message" => "Failed to register admin"]);
    }

    exit();
}


if (isset($_POST["admin_login"])) {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email == "" || $password == "") {
        echo json_encode(["status" => 303, "message" => "All fields are required"]);
        exit();
    }

    $admin = new Admin();
    $row = $admin->getAdminByEmail($email);

    if ($row) {
        // Plain text password check
        if ($password === $row["password"]) {
            $_SESSION["admin_id"] = $row["id"];
            $_SESSION["admin_name"] = $row["name"];
            echo json_encode(["status" => 202, "message" => "Login successful"]);
        } else {
            echo json_encode(["status" => 303, "message" => "Invalid password"]);
        }
    } else {
        echo json_encode(["status" => 303, "message" => "No account found with this email"]);
    }

    exit();
}

echo json_encode(["status" => 303, "message" => "Invalid Request"]);
exit();
