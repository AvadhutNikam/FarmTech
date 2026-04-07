<?php

// The filename we want to check for.
$filename = 'jcb_tracked_excavator.jpg';

// Get the directory of the current script.
$current_directory = __DIR__;

// Construct the full path to the image file.
$full_path = $current_directory . DIRECTORY_SEPARATOR . $filename;

echo "<h1>Image Access Test</h1>";
echo "<p>This script is running from: <strong>" . htmlspecialchars($current_directory) . "</strong></p>";
echo "<p>Checking for file: <strong>" . htmlspecialchars($filename) . "</strong></p>";
echo "<hr>";

echo "<p>Full path being tested:</p>";
echo "<code>" . htmlspecialchars($full_path) . "</code>";
echo "<hr>";

echo "<h2>Result:</h2>";

if (file_exists($full_path)) {
    echo "<h3 style='color:green;'>SUCCESS!</h3>";
    echo "<p>PHP has successfully found the image file.</p>";
    echo "<p>This means the problem is not with file permissions or the server's ability to read the folder.</p>";
    echo "<p>The issue must be in the way the main application is calling the script.</p>";
} else {
    echo "<h3 style='color:red;'>FAILURE!</h3>";
    echo "<p>PHP could NOT find the image file, even though this script is in the same folder.</p>";
    echo "<p>This strongly indicates a problem with your XAMPP/Apache server configuration or a file/folder permissions issue on your Windows operating system.</p>";
}

?>