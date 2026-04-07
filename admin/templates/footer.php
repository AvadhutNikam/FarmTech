<!-- templates/footer.php -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>

<?php 
// Allow pages to load additional scripts
if (isset($page_scripts)) {
    foreach ($page_scripts as $script) {
        echo '<script src="' . $script . '"></script>';
    }
}
?>
</body>
</html>