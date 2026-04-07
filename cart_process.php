<?php
session_start();
if (!isset($_SESSION["uid"])) {
    header("location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        html, body {
            height: 100%;
            background-color: #BA68C8;
        }
        .box1 {
            background-color: #263238;
            color: white;
            height: 600px;
        }
        .box2 {
            height: 600px;
        }
        .heading {
            font-weight: 900;
        }
        .heading2 {
            padding-left: 40px;
        }
        .card-header {
            background: none;
            margin-top: 50px;
            padding-left: 19px;
        }
        .sub-heading {
            font-weight: 900;
            font-size: 14px;
        }
        .sub-heading1, .sub-heading2 {
            border: 1px solid white;
            padding: 10px 0;
        }
        .credit {
            position: absolute;
            left: 8vw;
        }
        .frnt {
            z-index: 2;
            position: absolute;
        }
        .back {
            position: absolute;
            z-index: 1;
            left: 70px;
            top: 30px;
        }
        .form-group > input {
            border: none;
            border-bottom: 1px solid lightgray;
        }
        .card-number {
            border-bottom: 1px solid lightgray;
        }
        .card-number > input {
            border: none;
        }
        .card-number > input::placeholder {
            color: peachpuff;
            font-size: 25px;
        }
        .input:focus {
            outline: 0;
            box-shadow: none !important;
        }
        .btn {
            height: 60px;
            background-color: #00B8D4;
            color: white;
        }
        .btn:focus {
            outline: 0;
            box-shadow: none !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-5 mb-5 p-0">
        <div class="inner row d-flex justify-content-center">
            <div class="card col-md-5 col-12 box1">
                <div class="card-content">
                    <div class="card-header">
                        <div class="heading mb-3">PAYMENT METHOD</div>
                        <div class="sub-heading row text-center m-0">
                            <div class="col-6 col-md-6 sub-heading1">By Credit Card</div>
                            <div class="col-6 col-md-6 sub-heading2">By Debit Card</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p><small>You choose the method of payment with a credit/debit card. Enter your payment details.</small></p>
                        <div class="credit d-block mt-5 mx-auto">
                            <img class="frnt" src="product_images/CardArt-Plain-Front-Spotlight.png" width="200px">
                            <img class="back" src="product_images/main-qimg-bd6b7e786c2fdb670c89c6ded8fcb973.webp" width="200px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-md-5 col-12 box2">
                <div class="card-content">
                    <div class="card-header">
                        <div class="heading2">PAYMENT DETAILS</div>
                    </div>
                    <div class="card-body col-10 offset-1">
                        <form onsubmit="return pay()" action="payment_process.php">
                            <div class="form-group">
                                <label><small><strong class="text-muted">CARD HOLDER</strong></small></label>
                                <input type="text" class="form-control" id="c_name" placeholder="CARD HOLDER NAME" required minlength="5" maxlength="30">
                            </div>
                            <div class="form-group">
                                <label><small><strong class="text-muted">CARD NUMBER</strong></small></label>
                                <div class="d-flex card-number">
                                    <input class="form-control" type="text" placeholder="1234 5678 9012 3456" id="cno" required>
                                </div>
                            </div>
                            <div class="line3">
                                <div class="txt d-flex">
                                    <p><small class="text-muted">EXPIRATION DATE</small></p>
                                    <p><small class="text-muted">CVV</small></p>
                                </div>
                                <div class="form-group row">
                                    <select class="form-control col-5">
                                        <option>January</option><option>February</option><option>March</option><option>April</option>
                                        <option>May</option><option>June</option><option>July</option><option>August</option>
                                        <option>September</option><option>October</option><option>November</option><option>December</option>
                                    </select>
                                    <select class="form-control col-4">
                                        <option>2024</option><option>2025</option><option>2026</option><option>2027</option>
                                        <option>2028</option><option>2029</option>
                                    </select>
                                    <input class="col-3 col-md-2 offset-md-1 text-left" type="text" placeholder="234" id="cv" required>
                                </div>
                            </div>
                            <div class="card-footer col-10 offset-1 border-0">
                                <div class="d-flex total mb-5">
                                    <p><strong>TOTAL</strong></p>
                                   <p><strong>Rs.<?php echo $_SESSION['finalcost']; ?></strong></p>

                                </div>
                                <input type="submit" class="btn col-12" id="pbtn" value="PAY">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var re1 = /^\d{4}[-\s]?\d{4}[-\s]?\d{4}[-\s]?\d{4}$/;
        var re2 = /^\d{3}$/;

        function pay() {
            var cn = document.getElementById("cno").value.trim();
            var cv = document.getElementById("cv").value.trim();

            if (!re1.test(cn)) {
                alert("Invalid Card Number. Use 16 digits with spaces or dashes.");
                return false;
            }
            if (!re2.test(cv)) {
                alert("Invalid CVV. It should be a 3-digit number.");
                return false;
            }

            return confirm("Make Payment?");
        }
    </script>
</body>
</html>
