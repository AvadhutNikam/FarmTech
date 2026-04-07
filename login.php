<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";
session_start();

// Login script
// If credentials match, echo "login_success" so AJAX can redirect
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]); // no md5, plain text check

    $sql = "SELECT * FROM user_info WHERE email = '$email' AND password = '$password' LIMIT 1";
    $run_query = mysqli_query($con, $sql);
    $count = mysqli_num_rows($run_query);

    if ($count == 1) {
        $row = mysqli_fetch_array($run_query);
        $_SESSION["uid"] = $row["user_id"];
        $_SESSION["name"] = $row["first_name"];
        echo "login_success"; // AJAX will pick this up
        exit();
    } else {
        echo "<span style='color:red;'>Invalid email or password</span>";
        exit();
    }
}
?>
