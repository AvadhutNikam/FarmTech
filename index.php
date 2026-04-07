<?php
session_start();
//if(isset($_SESSION["uid"])){
//	header("location:profile.php");
//}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>FARMTECH</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="main.js"></script>
		<script src="script.js"></script>

		<script src="https://kit.fontawesome.com/26504e4a1f.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="instyle.css">
		<style></style>
	</head>
<body>
<div class="wait overlay">
	<div class="loader"></div>
</div>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">	
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="sr-only">navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand"><img src="product_images/EASLogo4.jpg" alt="FARMTECH"></a>
			</div>
		<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
				<li><a href="productview.php"><span class="glyphicon glyphicon-modal-window"></span>Equipments</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
    <!-- Cart always visible -->
    <li>
        <a href="cart.php">
            <span class="glyphicon glyphicon-shopping-cart"></span> Cart
            <span class="badge">0</span>
        </a>
    </li>

    <!-- If user is logged in -->
    <?php if (isset($_SESSION["uid"])): ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["name"]; ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </li>

    <!-- If user is not logged in -->
    <?php else: ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user"></span> SignIn
            </a>
            <ul class="dropdown-menu">
                <div style="width:300px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading"><center><h4>Login</h4></center></div>
                        <div class="panel-heading">
                            <form onsubmit="return false" id="login1">
                                <label for="email1">Email</label>
                                <input type="email" class="form-control" name="email" id="email1" required/>
                                <label for="password1">Password</label>
                                <input type="password" class="form-control" name="password" id="password1" required/>
                                <br> 	
                                <center>
                                    <input type="submit" class="btn btn-success"><br>
                                    <a href="customer_registration.php?register=1" style="color:white;">New Here? Create an account!</a><br>
                                    <a href="admin/index.php" style="color:orange;">Login as Vendor</a><br>
                                </center>
                            </form>
                        </div>
                        <div class="panel-footer" id="e_msg"></div>
                    </div>
                </div>
            </ul>
        </li>
    <?php endif; ?>
</ul>

		</div>
	</div>
</div>


<section class="home" id="home" >
	<div class="content">
		<h2>FARMTECH!</h2>
		<h4>Farming Made Easy,with FARMTECH<br>
		    Farming Innovation Start with FARMTECH</h4>
	</div>
</section>


<section class="features" id="features">
	<h1 class="heading">Our<span>Features</span></h1>
	<div class="box-container">
		<div class="box">
			<img src="product_images/durablelogo.jpg" alt="">
			<h3>Durability</h3>
			<p>We only supply Durable equipments/products</p>
		</div>

		<div class="box">
			<img src="product_images/qualitylogo.jpg" alt="">
			<h3>Quality Equipments</h3>
			<p>We only provide Quality and Branded products and equipments</p>
		</div>

		<div class="box">
			<img src="product_images/paylogo.jpeg" alt="">
			<h3>Easy Payments</h3>
			<p>Customers get Easy and Secure Payment environment</p>
		</div>
	</div>
</section>

<section class="categories" id="categories">

	<h1 class="heading">Equipment<span>Categories</span></h1>

	<div class="box-container">
		<div class="box">
			<img src="product_images/heavyvehicles-icon-.png" alt="">
			<h3>Heavy Vehicles</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/farmeqlogo.jpg" alt="">
			<h3>Farming Equipments</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/mininglogo.jpg" alt="">
			<h3>Mining Equipments</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/gardenlogo.jpeg" alt="">
			<h3>Gardening Equipments</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/constructlogo.jpg" alt="">
			<h3>Construction Equipments</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

	</div>	
</section>

<section class="brands" id="brands">

	<h1 class="heading">Top<span>Brands</span></h1>

	<div class="box-container">
		<div class="box">
			<img src="product_images/Mahindra-logo.png" alt="">
			<h3>Mahindra</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/tatalogo.png" alt="">
			<h3>TATA</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/JCB-Logo.jpg" alt="">
			<h3>JCB</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/agtlogo.png" alt="">
			<h3>AGT</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/allogo.png" alt="">
			<h3>Ashok Leyland</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

		<div class="box">
			<img src="product_images/catlogo.jpeg" alt="">
			<h3>Caterpillar inc</h3>
			<a href="productview.php" class="btn">Shop Now</a>
		</div>

	</div>	
</section>
<br>
<section class="footer">
	<div class="box-container">
		<div class="box">
			<h3>FARMTECH</h3>
			<p class="off"> <i class="fa fa-building-o"></i> IT Dept., PHCET,RASAYANI</p>
			<div class="share">
				<a href="https://www.facebook.com/aaditya_mahajan_03" target="_blank" class="fab fa-facebook-f"></a>
				<a href="https://twitter.com/aaditya_mahajan_03" target="_blank" class="fab fa-twitter"></a>
				<a href="https://www.instagram.com/aaditya_mahajan_03/" target="_blank" class="fab fa-instagram"></a><br><br>
			
			</div>
		</div>

		<div class="box">
			<h3>Contact Info</h3>
			<a href="#" class="links"> <i class="fas fa-phone"></i> +91 7720051561 </a>
			<a href="#" class="links"> <i class="fas fa-phone"></i> +91 85518 05726 </a>
			<a href="https://accounts.google.com/v3/signin/identifier?continue=https%3A%2F%2Fmail.google.com%2Fmail%2Fu%2F0%2F&emr=1&followup=https%3A%2F%2Fmail.google.com%2Fmail%2Fu%2F0%2F&osid=1&passive=1209600&service=mail&ifkv=ARZ0qKJ44eMdUj1t3CovyhRPrBOpaYgLmWu3aQk2lGe0F-MFASqISNGV-VXerilk0K9EAghlfWtD_A&theme=mn&ddm=0&flowName=GlifWebSignIn&flowEntry=ServiceLogin" class="links"> <i class="fas fa-envelope"></i> nikhil@gmail.com </a> 
			<a href="https://www.google.com/maps/place/Pillai+HOC+College+Of+Engineering+%26+Technology/@18.8941071,73.1742673,17z/data=!3m1!4b1!4m6!3m5!1s0x3be7e6af4a9b7a47:0x30dbd3b0d3c14416!8m2!3d18.8941071!4d73.1768422!16s%2Fg%2F11cn6dm3zp?entry=ttu&g_ep=EgoyMDI1MDIxMC4wIKXMDSoASAFQAw%3D%3D" class="links"> <i class="fas fa-map-marker-alt"></i> PANVEL, Maharashtra-410207,India </a>
		</div>
		
		<div class="box">
			<h3>Quick Links</h3>
			<a href="index.php" class="links"> <i class="fas fa-arrow-right"></i> Home </a>
			<a href="productview.php" class="links"> <i class="fas fa-arrow-right"></i> Equipments </a> 
			<a href="login_form.php" class="links"> <i class="fas fa-arrow-right"></i> Customer Login </a>
			<a href="admin/index.php" class="links"> <i class="fas fa-arrow-right"></i> Admin/Vendor Login </a>
		</div>
	</div>
	<div class="credit">Created by <span>PHCET IT dept. Students </span> | All Rights Reserved </div>
</section>
<div id="descModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Details</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(document).on("click", ".showDescription", function () {
            var description = $(this).data("desc"); // Get the description

            if (!description || description.trim() === "") {
                alert("No details available.");
            } else {
                $("#descModal .modal-body p").text(description);
                $("#descModal").modal("show"); // Show Bootstrap modal
            }
        });
    });
</script>

</body>
</html>