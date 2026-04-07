<?php 
session_start(); 

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("location: login.php");
    exit();
}

// Include necessary template files
include "./templates/top.php"; 
include "./templates/navbar.php"; 
include "./templates/sidebar.php"; 
?>

<div class="container">
    <div class="row">
        
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <h2>Hello, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</h2>
            <p>Welcome to the admin dashboard.</p>

            <h3 class="mt-4">Other Admins</h3>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="admin_list">
                        <tr><td colspan="5" class="text-center">Loading admin data...</td></tr>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

<?php include "./templates/footer.php"; ?>

<script type="text/javascript" src="./js/admin.js"></script>