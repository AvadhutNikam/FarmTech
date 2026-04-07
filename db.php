<?php
$servername = "localhost";
$username   = "root";
$password   = "";
// This MUST match your database name in phpMyAdmin
$db         = "farmtek"; 

$con = mysqli_connect($servername, $username, $password, $db);

if (!$con) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
?>