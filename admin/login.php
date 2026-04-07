<?php 
session_start();
// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("location: index.php");
    exit();
}

include "./templates/top.php"; 
include "./templates/navbar.php"; 
?>

<div class="container">
    <div class="row justify-content-center" style="margin:100px 0;">

        <div class="col-md-4">
            <h4>Admin Login</h4>
            <p class="message"></p>
            <form id="admin-login-form">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                </div>
                
                <input type="hidden" name="action" value="login">
                
                <button type="button" class="btn btn-primary login-btn">Submit</button>
            </form>
        </div>

    </div> </div> <?php include "./templates/footer.php"; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="js/main.js"></script>