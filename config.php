<?php
// Start the session.
session_start();

// --- DATABASE CONNECTION ---
// (Move the content of your db.php file here)
$servername = "localhost";
$username = "root";
$password = "";
$db = "farmtek"; // <-- IMPORTANT: Change this to your actual database name!

// Create connection
$con = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


// --- DEFINE THE BASE URL ---
// This creates an absolute path like http://localhost/FarmTest/FarmTech.../
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$script_name = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . $host . $script_name);

// This defines the server file path
define('BASE_PATH', __DIR__ . '/');

?>