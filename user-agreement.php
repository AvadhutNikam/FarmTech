<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["agreementAccepted"] = true; // ✅ Set session variable
    echo "Accepted";
}
?>
