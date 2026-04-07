<?php
session_start();
session_destroy();
header("Location: user-agreement.html");
exit();
?>
