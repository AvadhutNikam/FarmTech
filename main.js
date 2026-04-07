console.log("main.js is running");

$(document).ready(function(){
	cat();
	brand();
	product();
	//cat() is a funtion fetching category record from database whenever page is load
	function cat(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{category:1},
			success	:	function(data){
				$("#get_category").html(data);
				
			}
		})
	}
	//brand() is a funtion fetching brand record from database whenever page is load
	function brand(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{brand:1},
			success	:	function(data){
				$("#get_brand").html(data);
			}
		})
	}
	//product() is a funtion fetching product record from database whenever page is load
		function product(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{getProduct:1},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	}
	/*
		when page is load successfully then there is a list of categories when user click on category we will get category id and 
		according to id we will show products
	*/
	$("body").delegate(".category","click",function(event){
		event.preventDefault();
		var cid = $(this).attr('cid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{get_seleted_Category:1,cat_id:cid},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	
	})
	
	/*
		when page is load successfully then there is a list of brands when user click on brand we will get brand id and 
		according to brand id we will show products
	*/
	$("body").delegate(".selectBrand","click",function(event){
		event.preventDefault();
		var bid = $(this).attr('bid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{selectBrand:1,brand_id:bid},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	
	})
	
	/*
		Whenever user write name in search box we will take the value from user and with the help of action.php we will give
		that product to user
	*/
	$("#search_btn").click(function(){
		var keyword = $("#search").val();
		
		if(keyword != ""){
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{search:1,keyword:keyword},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
		}
	})
	//end

	/*
		At the top of page there is a signup form available when user fill this form we will take all the 
		user information and send it to action.php
	*/
	$("#signup_form").on("submit",function(event){
		event.preventDefault();
		$.ajax({
			url	:	"register.php",
			method:	"POST",
			data: $("#signup_form").serialize(),
			success	:	function(data){
				$("#signup_msg").html(data);
			}
		})
	})
	
	

// For Login Part
$(document).on("submit", "#login, #login1", function(event){
    event.preventDefault(); // stop normal form submit

    let formData = $(this).serialize(); // serialize whichever form triggered

    $.ajax({
        url: "login.php",
        method: "POST",
        data: formData,
        success: function(data){
            if (data == "login_success") {
                window.location.href = "index.php"; // redirect after login
            } else if (data == "cart_login") {
                window.location.href = "cart.php"; // if checkout login
            } else {
                $("#e_msg").html(data); // show error message
            }
        }
    });
});


	//Add Product into Cart
	$("body").delegate(".product","click",function(event){
		event.preventDefault();
		var p_id = $(this).attr('pid');
		$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{addToProduct:1,proId:p_id},
			success	:	function(data){
				count_item();
				getCartItem();
				$('#product_msg').html(data);
			}
		})
	})
	
	//count user cart items funtion
	count_item();
	function count_item(){
		$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{count_item:1},
			success	:	function(data){
				$(".badge").html(data);
			}
		})
	}
	
	//Fetch Cart item from Database to dropdown menu
	getCartItem();
	function getCartItem(){
		$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{Common:1,getCartItem:1},
			success	:	function(data){
				$("#cart_product").html(data);
			}
		})
	}
	//Fetch Cart item from Database to Cart Table
	page();
	function page(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{page:1},
			success	:	function(data){
				$("#pageno").html(data);
			}
		})
	}
	
	$("body").delegate("#page","click",function(event){
		event.preventDefault();
		var pn = $(this).attr("page");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{getProduct:1,setPage:1,pageNumber:pn},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	})
	
	$("body").delegate("#qty","keyup",function(){
		var pid = $(this).attr("pid");
		var qty = $("#qty-"+pid).val();
		var price = $("#price-"+pid).val();
		var total = qty * price;
		$("#total-"+pid).val(total);
	})
	
	$("body").delegate(".remove","click",function(event){
		event.preventDefault();
		var remove = $(this).attr("remove_id");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{removeItemFromCart:1,rid:remove},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		})
	})
	$("body").delegate(".update","click",function(event){
		event.preventDefault();
		var update = $(this).attr("update_id");
		var qty = $("#qty-"+update).val();
		var price = $("#price-"+update).val();
		var total = $("#total-"+update).val();
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{updateCartItem:1,update_id:update,qty:qty,price:price,total:total},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		})
	})
	
	checkOutDetails();
	function checkOutDetails(){
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{Common:1,checkOutDetails:1},
			success	:	function(data){
				$("#cart_checkout").html(data);
			}
		})
	}
	
	$("#cart_container").on("click","#checkout",function(event){
		event.preventDefault();
		$.ajax({
			url	:	"login.php",
			method:	"POST",
			data	:	{cart_checkout:1},
			success	:	function(data){
				$("#e_msg").html(data);
			}
		})
	})
	page();
	function page(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{page:1},
			success	:	function(data){
				$("#pageno").html(data);
			}
		})
	}
	
	$("body").delegate("#page","click",function(event){
		event.preventDefault();
		var pn = $(this).attr("page");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{getProduct:1,setPage:1,pageNumber:pn},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	})
	
	$("body").delegate("#qty","keyup",function(){
		var pid = $(this).attr("pid");
		var qty = $("#qty-"+pid).val();
		var price = $("#price-"+pid).val();
		var total = qty * price;
		$("#total-"+pid).val(total);
	})
	$("body").delegate(".remove","click",function(event){
		event.preventDefault();
		var remove = $(this).attr("remove_id");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{removeItemFromCart:1,rid:remove},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		})
	})
	
	$("body").delegate(".update","click",function(event){
		event.preventDefault();
		var update = $(this).attr("update_id");
		var qty = $("#qty-"+update).val();
		var price = $("#price-"+update).val();
		var total = $("#total-"+update).val();
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{updateCartItem:1,update_id:update,qty:qty,price:price,total:total},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		})
	})
	
	checkOutDetails();
	function checkOutDetails(){
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{Common:1,checkOutDetails:1},
			success	:	function(data){
				$("#cart_checkout").html(data);
			}
		})
	}
	$("#cart_container").on("click","#checkout",function(event){
		event.preventDefault();
		$.ajax({
			url	:	"login.php",
			method:	"POST",
			data	:	{cart_checkout:1},
			success	:	function(data){
				$("#e_msg").html(data);
			}
		})
	})

	// User logout
	$("#logout").click(function(event){
		event.preventDefault();
		$.ajax({
			url	:	"logout.php",
			method:	"POST",
			data	:	{userLogout:1},
			success	:	function(data){
				window.location.href="index.php";
			}
		})
	})

	// Get user order
	$("#order_form").on("submit",function(event){
		event.preventDefault();
		$.ajax({
			url	:	"order.php",
			method:	"POST",
			data: $("#order_form").serialize(),
			success	:	function(data){
				$("#order_msg").html(data);
			}
		})
	})
})
