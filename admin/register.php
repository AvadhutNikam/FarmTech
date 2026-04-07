<?php include "./templates/top.php"; ?>
<?php include "./templates/navbar.php"; ?>

<div class="container">
  <div class="row justify-content-center" style="margin:100px 0;">
    <div class="col-md-4">
      <h4>Register New Admin</h4>
      <p class="register-message"></p>
      <form id="admin-register-form">
        <div class="form-group">
          <label for="reg_name">Name</label>
          <input type="text" class="form-control" name="name" id="reg_name" placeholder="Full Name">
        </div>
        <div class="form-group">
          <label for="reg_email">Email address</label>
          <input type="email" class="form-control" name="email" id="reg_email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="reg_password">Password</label>
          <input type="password" class="form-control" name="password" id="reg_password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="reg_cpassword">Confirm Password</label>
          <input type="password" class="form-control" name="cpassword" id="reg_cpassword" placeholder="Confirm Password">
        </div>
        <input type="hidden" name="action" value="register">
        <button type="button" class="btn btn-success register-btn">Register</button>
      </form>
      <br>
      <a href="login.php">Already an admin? Login here</a>
    </div>
  </div>
</div>

<?php include "./templates/footer.php"; ?>
<script type="text/javascript" src="./js/main.js"></script>
