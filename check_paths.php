<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server Path Diagnostic</title>
    <style>
        body { font-family: monospace; padding: 20px; }
        .success { color: green; font-weight: bold; }
        .fail { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h1>Server Path Diagnostic Report</h1>

<hr>
<h2>Server Variables</h2>
<p>This is what the Apache server reports as its root directory.</p>
<p><strong>$_SERVER['DOCUMENT_ROOT']:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>

<hr>
<h2>PHP Script Path</h2>
<p>This is the absolute path to THIS script on your hard drive.</p>
<p><strong>__DIR__:</strong> <?php echo __DIR__; ?></p>

<hr>
<h2>Image File Test</h2>
<p>Now, let's try to find a specific image file using the path we think is correct.</p>

<?php
// Construct the full, absolute path to one of your image files
$image_file_path = __DIR__ . '/product_images/jcb_tracked_excavator.jpg';
?>

<p><strong>Attempting to find file at this path:</strong></p>
<p><code><?php echo $image_file_path; ?></code></p>

<p><strong>Result:</strong>
    <?php
    if (file_exists($image_file_path)) {
        echo "<span class='success'>SUCCESS: The file was found by PHP!</span>";
    } else {
        echo "<span class='fail'>FAILURE: PHP could not find the file at that path.</span>";
    }
    ?>
</p>

</body>
</html>