<?php
// We now use the new config file which starts the session and connects to the DB.
include 'config.php';

$ip_add = getenv("REMOTE_ADDR");

// Fetch Categories
if (isset($_POST["category"])) {
    $category_query = "SELECT * FROM categories";
    $run_query = mysqli_query($con, $category_query) or die(mysqli_error($con));
    echo "
        <div class='nav nav-pills nav-stacked'>
            <li class='active'><a href='#'><h4>Categories</h4></a></li>
    ";
    if (mysqli_num_rows($run_query) > 0) {
        while ($row = mysqli_fetch_array($run_query)) {
            $cid = $row["cat_id"];
            $cat_name = $row["cat_title"];
            echo "
                    <li><a href='#' class='category' cid='" . htmlspecialchars($cid) . "'>" . htmlspecialchars($cat_name) . "</a></li>
            ";
        }
        echo "</div>";
    }
}

// Fetch Brands
if (isset($_POST["brand"])) {
    $brand_query = "SELECT * FROM brands";
    $run_query = mysqli_query($con, $brand_query);
    echo "
        <div class='nav nav-pills nav-stacked'>
            <li class='active'><a href='#'><h4>Brands</h4></a></li>
    ";
    if (mysqli_num_rows($run_query) > 0) {
        while ($row = mysqli_fetch_array($run_query)) {
            $bid = $row["brand_id"];
            $brand_name = $row["brand_title"];
            echo "
                    <li><a href='#' class='selectBrand' bid='" . htmlspecialchars($bid) . "'>" . htmlspecialchars($brand_name) . "</a></li>
            ";
        }
        echo "</div>";
    }
}

// Handle Pagination
if (isset($_POST["page"])) {
    $sql = "SELECT COUNT(*) as total_products FROM products";
    $run_query = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($run_query);
    $count = $row['total_products'];
    $pageno = ceil($count / 9);
    for ($i = 1; $i <= $pageno; $i++) {
        echo "
            <li><a href='#' page='$i' id='page'>$i</a></li>
        ";
    }
}

// Fetch Products (Main Load and Filtering)
if (isset($_POST["getProduct"]) || isset($_POST["get_seleted_Category"]) || isset($_POST["selectBrand"]) || isset($_POST["search"])) {
    $limit = 9;
    $start = 0;
    $sql = "SELECT * FROM products";
    $params = [];
    $types = "";

    if (isset($_POST["setPage"]) && isset($_POST["pageNumber"])) {
        $pageno = intval($_POST["pageNumber"]);
        $start = ($pageno * $limit) - $limit;
    }

    $where_clauses = [];
    if (isset($_POST["get_seleted_Category"]) && !empty($_POST["cat_id"])) {
        $where_clauses[] = "product_cat = ?";
        $params[] = $_POST["cat_id"];
        $types .= "i";
    }
    if (isset($_POST["selectBrand"]) && !empty($_POST["brand_id"])) {
        $where_clauses[] = "product_brand = ?";
        $params[] = $_POST["brand_id"];
        $types .= "i";
    }
    if (isset($_POST["search"]) && !empty($_POST["keyword"])) {
        $where_clauses[] = "product_keywords LIKE ?";
        $params[] = "%" . $_POST["keyword"] . "%";
        $types .= "s";
    }

    if (!empty($where_clauses)) {
        $sql .= " WHERE " . implode(" AND ", $where_clauses);
    }

    $sql .= " LIMIT ?, ?";
    $params[] = $start;
    $params[] = $limit;
    $types .= "ii";
    
    $stmt = $con->prepare($sql);
    if ($stmt) {
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $run_query = $stmt->get_result();

        // ==========================================================
        // FINAL CLEANED CODE
        // ==========================================================
        while ($row = $run_query->fetch_assoc()) {
            $pro_id    = $row['product_id'];
            $pro_title = htmlspecialchars($row['product_title']);
            $pro_price = $row['product_price'];
            // Use trim() to remove any hidden whitespace from the filename
            $pro_image = trim(htmlspecialchars($row['product_image']));

            echo "
            <div class='col-md-4'>
                <div class='panel panel-info'>
                    <div class='panel-heading'>$pro_title</div>
                    <div class='panel-body'>
                        <img src='product_images/$pro_image' class='img-responsive' style='width:100%; height:250px;'/>
                    </div>
                    <div class='panel-footer'>
                        <h4>Rs. $pro_price</h4>
                        <button pid='$pro_id' class='btn btn-danger btn-xs product' title='For Taking On Rent'>Add To Cart</button>
                    </div>
                </div>
            </div>";
        }
        // ==========================================================
        // END OF FINAL CLEANED CODE
        // ==========================================================
        $stmt->close();
    }
}


// Handle Add to Cart
if(isset($_POST["addToProduct"])){
    $p_id = $_POST["proId"];

    if(!isset($_SESSION["uid"])){
        echo "
            <div class='alert alert-danger'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>Please sign in to add items to your cart.</b>
            </div>";
        exit();
    }
    
    $user_id = $_SESSION["uid"];

    $stmt = $con->prepare("SELECT * FROM cart WHERE p_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $p_id, $user_id);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();

    if($count > 0){
        echo "
            <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Product is already added to the cart!</b>
            </div>";
    } else {
        $stmt = $con->prepare("INSERT INTO cart (p_id, ip_add, user_id, qty) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("isi", $p_id, $ip_add, $user_id);
        if($stmt->execute()){
            echo "
                <div class='alert alert-success'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Product is Added!</b>
                </div>";
        }
        $stmt->close();
    }
}

// Count User cart items
if (isset($_POST["count_item"])) {
    $count = 0;
    if (isset($_SESSION["uid"])) {
        $stmt = $con->prepare("SELECT COUNT(*) AS count_item FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $_SESSION["uid"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $count = $row["count_item"];
        }
        $stmt->close();
    }
    echo $count;
    exit();
}

// Get Cart Items for Dropdown and Checkout Page
if (isset($_POST["Common"])) {
    $sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND ";
    $params = [];
    $types = "";

    if (isset($_SESSION["uid"])) {
        $sql .= "b.user_id = ?";
        $params[] = $_SESSION["uid"];
        $types .= "i";
    } else {
        $sql .= "b.ip_add = ? AND b.user_id = -1";
        $params[] = $ip_add;
        $types .= "s";
    }

    $stmt = $con->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $query = $stmt->get_result();

    if (isset($_POST["getCartItem"])) {
        if ($query->num_rows > 0) {
            $n = 0;
            while ($row = $query->fetch_assoc()) {
                $n++;
                $product_image = htmlspecialchars($row["product_image"]);
                $product_title = htmlspecialchars($row["product_title"]);
                $product_price = $row["product_price"];
                
                echo '
                    <div class="row">
                        <div class="col-md-3">'.$n.'</div>
                        <div class="col-md-3"><img class="img-responsive" src="product_images/'.$product_image.'" /></div>
                        <div class="col-md-3">'.$product_title.'</div>
                        <div class="col-md-3">Rs '.$product_price.'</div>
                    </div>';
            }
            echo '<a style="float:right;" href="cart.php" class="btn btn-warning">Go To Cart&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span></a>';
        }
    }

    if(isset($_POST["checkOutDetails"])){
        if ($query->num_rows > 0) {
            $total_price = 0;
            while ($row = $query->fetch_assoc()) {
                 $product_id = $row["product_id"];
                 $product_title = htmlspecialchars($row["product_title"]);
                 $product_price = $row["product_price"];
                 $product_image = htmlspecialchars($row["product_image"]);
                 $cart_item_id = $row["id"];
                 $qty = $row["qty"];
                 $total = $qty * $product_price;
                 $total_price += $total;

                 echo 
                       '<div class="row">
                           <div class="col-md-2">
                               <div class="btn-group">
                                   <a href="#" remove_id="'.$product_id.'" class="btn btn-danger remove"><span class="glyphicon glyphicon-trash"></span></a>
                                   <a href="#" update_id="'.$product_id.'" class="btn btn-primary update"><span class="glyphicon glyphicon-ok-sign"></span></a>
                               </div>
                           </div>
                           <div class="col-md-2"><img class="img-responsive" src="product_images/'.$product_image.'"></div>
                           <div class="col-md-2">'.$product_title.'</div>
                           <div class="col-md-2"><input type="text" class="form-control qty" value="'.$qty.'" id="qty-'.$product_id.'" pid="'.$product_id.'"></div>
                           <div class="col-md-2"><input type="text" class="form-control price" value="'.$product_price.'" id="price-'.$product_id.'" readonly></div>
                           <div class="col-md-2"><input type="text" class="form-control total" value="'.$total.'" id="total-'.$product_id.'" readonly></div>
                       </div>';
            }
            echo '<div class="row"><div class="col-md-8"></div><div class="col-md-4"><b class="net_total" style="font-size:20px">Total: Rs '.$total_price.'</b></div></div>';
        }
    }
    $stmt->close();
}


// Remove Item From Cart
if (isset($_POST["removeItemFromCart"])) {
    $remove_id = $_POST["rid"];
    $sql = "DELETE FROM cart WHERE p_id = ?";
    $params = [$remove_id];
    $types = "i";

    if (isset($_SESSION["uid"])) {
        $sql .= " AND user_id = ?";
        $params[] = $_SESSION["uid"];
        $types .= "i";
    } else {
        $sql .= " AND ip_add = ?";
        $params[] = $ip_add;
        $types .= "s";
    }

    $stmt = $con->prepare($sql);
    $stmt->bind_param($types, ...$params);
    if($stmt->execute()){
        echo "<div class='alert alert-danger'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>Product is removed from cart</b>
            </div>";
    }
    $stmt->close();
}

// Update Item From Cart
if (isset($_POST["updateCartItem"])) {
    $update_id = $_POST["update_id"];
    $qty = $_POST["qty"];
    $sql = "UPDATE cart SET qty = ? WHERE p_id = ?";
    $params = [$qty, $update_id];
    $types = "ii";

    if (isset($_SESSION["uid"])) {
        $sql .= " AND user_id = ?";
        $params[] = $_SESSION["uid"];
        $types .= "i";
    } else {
        $sql .= " AND ip_add = ?";
        $params[] = $ip_add;
        $types .= "s";
    }

    $stmt = $con->prepare($sql);
    $stmt->bind_param($types, ...$params);
    if($stmt->execute()){
        echo "<div class='alert alert-success'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <b>Cart has been updated</b>
            </div>";
    }
    $stmt->close();
}
?>