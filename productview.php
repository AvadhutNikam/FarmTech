<?php
session_start();
if(isset($_SESSION["uid"])){
	header("location:profile.php");
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>FARMTECH</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>

		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".showDescription").forEach(button => {
        button.addEventListener("click", function () {
            var description = this.getAttribute("data-desc");

            if (description.trim() === "" || description === "undefined") {
                alert("No details available.");
            } else {
                document.querySelector("#descModal .modal-body p").textContent = description;
                $("#descModal").modal("show"); // Show Bootstrap modal
            }
        });
    });
});
</script>

		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script> <!-- Link to the JavaScript file -->

		<script src="main.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<script src="script.js"></script>

		<link rel="stylesheet" type="text/css" href="style.css">
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
				<a href="index.php" class="navbar-brand">FARMTECH</a>
			</div>
		<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
				<li><a href="productview.php"><span class="glyphicon glyphicon-modal-window"></span>Equipments</a></li>
				<li style="width:300px;left:10px;top:10px;"><input type="text" class="form-control" id="search" placeholder="Enter Location"></li>
				<li style="top:10px;left:20px;"><button class="btn btn-primary" id="search_btn" placeholder="Enter City">Search</button></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-shopping-cart"></span>Cart<span class="badge">0</span></a>
					<div class="dropdown-menu" style="width:400px;">
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-3">Sr.No</div>
									<div class="col-md-3">Equipment Image</div>
									<div class="col-md-3">Equipment Name</div>
									<div class="col-md-3">Equipment Cost(for 1 Hour)</div>
								</div>
							</div>
							<div class="panel-body">
								<div id="cart_product">
								<!--<div class="row">
									<div class="col-md-3">Sl.No</div>
									<div class="col-md-3">Product Image</div>
									<div class="col-md-3">Product Name</div>
									<div class="col-md-3">Price in Rs.</div>
								</div>-->
								</div>
							</div>
							<div class="panel-footer"></div>
						</div>
					</div>
				</li>
				<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>SignIn</a>
					<ul class="dropdown-menu">
						<div style="width:300px;">
							<div class="panel panel-primary">
								<div class="panel-heading"><center><h4>Login</h4></center></div>
								<div class="panel-heading">
									<form onsubmit="return false" id="login">
										<label for="email">Email</label>
										<input type="email" class="form-control" name="email" id="email" required/>
										<label for="email">Password</label>
										<input type="password" class="form-control" name="password" id="password" required/>
										<br> 	
										<center><input type="submit" class="btn btn-success" style="float:center; "><br>
										<a href="customer_registration.php?register=1" style="color:white; list-style:none;">New Here! Create an account!</a><br>
											<a href="admin/index.php" style="color:orange; list-style:none;">Login as Vendor</a><br></center>
									</form>
								</div>
								<div class="panel-footer" id="e_msg"></div>
							</div>
						</div>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>	
	<p><br/></p>
	<p><br/></p>
	<p><br/></p>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-2 col-xs-12">
				<div id="get_category">
				</div>
				<!--<div class="nav nav-pills nav-stacked">
					<li class="active"><a href="#"><h4>Categories</h4></a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
				</div> -->
				<div id="get_brand">
				</div>
				<!--<div class="nav nav-pills nav-stacked">
					<li class="active"><a href="#"><h4>Brand</h4></a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
					<li><a href="#">Categories</a></li>
				</div> -->
			</div>
			<div class="col-md-8 col-xs-12">
				<div class="row">
					<div class="col-md-12 col-xs-12" id="product_msg">
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading"><h4>Equipments</h4></div>
					<div class="panel-body">
						<div id="get_product">
							<!--Here we get product jquery Ajax Request-->
						</div>
						<!--<div class="col-md-4">
							<div class="panel panel-info">
								<div class="panel-heading">Samsung Galaxy</div>
								<div class="panel-body">
									<img src="product_images/images.JPG"/>
								</div>
								<div class="panel-heading">$.500.00
									<button style="float:right;" class="btn btn-danger btn-xs">AddToCart</button>
								</div>
							</div>
						</div> -->
					</div>
					<div class="panel-footer">&copy; Equipment at Service @ 2025</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<center>
					<ul class="pagination" id="pageno">
						<li><a href="#">1</a></li>
					</ul>
				</center>
			</div>
		</div>
	</div>


	<script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".showDescription").forEach(button => {
                button.addEventListener("click", function () {
                    var description = this.getAttribute("data-desc");

                    if (description.trim() === "" || description === "undefined") {
                        alert("No details available.");
                    } else {
                        document.querySelector("#descModal .modal-body p").textContent = description;
                        $("#descModal").modal("show"); // Show Bootstrap modal
                    }
                });
            });
        });
    </script>
</body>
</html>
