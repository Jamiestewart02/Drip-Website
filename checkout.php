<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Drip Clothing - Checkout</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/dripTabLogo.png" rel="icon">
    <link href="assets/img/dripTabLogo.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Impact - v1.2.0
    * Template URL: https://bootstrapmade.com/impact-bootstrap-business-website-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->

    <?php
        include("Includes/header.php");
    ?>
    <!-- End Header -->

    <!-- Sign-in Modal -->
    
    <?php
        include("Includes/modals.php");
    ?>

    <!-- ======= Hero Section ======= -->
    <section id="checkout-hero" class="hero-alt">
        <div class="container" data-aos="fade-down">
            <h2>Checkout</h2>
        </div>

    </section>
    <!-- End Hero Section -->

    <main id="main">

        <!-- Checkout Section ======= -->
        <section id="checkout" class="main">
            <div class="container" data-aos="fade-up">

                <div class="container">

                    <div class="row justify-content-between">
                        <div class="col-md-6 text-center">
                            <h2 class="mb-4">Your Cart Items</h2>

                            <?php

                                if (isset($_SESSION["cart"])){ 

                                    $total = 0;
                                     
                                    foreach ($_SESSION["cart"] as $key => $value) {

                                        
                                            $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

    
                                            if (mysqli_connect_errno()) {
                                                printf ("Could not connect to DB: %s", mysqli_connect_error());
                                            } else {
                                                if (isset($value["Size"])) {
                                                    $query = "SELECT * FROM stock WHERE ProductID = '". $value["ProductID"]. "' AND Size = '". $value["Size"]. "'";
                                                } else {
                                                    $query = "SELECT * FROM stock WHERE ProductID = '". $value["ProductID"]. "'";
                                                }
                                                $res = mysqli_query($sqlConnection, $query);

                                                if ($res) {
                                                    $array = mysqli_fetch_array($res, MYSQLI_ASSOC);
                                                    if ($value["Quantity"] > $array["Amount"]) {
                                                        $overOrder = true;
                                                        $overOrderedItem = $value["Name"];
                                                        $overOrderedQuantity = $value["Quantity"];
                                                    }
                                                }
                                            mysqli_close($sqlConnection);
                                            }
                                        
                            ?>
                                        <div class="row mb-4 border border-4 rounded-pill">
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-3">
                                                <img src="<?php echo $value["ImagePath"]; ?>" class="img-thumbnail" style="border: none;">
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="mt-3 mb-3"><?php echo $value["Name"]; ?></h4>
                                                <p><?php echo (isset($value["Size"])) ? "Size: <b>".$value["Size"]. "</b>" : "Size: <b>-</b>"; ?></p>
                                                <p><?php echo "Quantity: ".$value["Quantity"]; ?></p>
                                                <p><?php printf ("Price: <b>£%0.2f</b>", $value["Price"]); ?></p>
                                                <?php $total += $value["Price"]; ?>
                                            </div>
                                        </div>
                            <?php   } ?>
                                    <div class="row mb-4 border border-4 rounded-pill">
                                        <h3 class="mt-2"><?php printf ("<b>Total: £%0.2f</b>", $total); ?></h3>
                                    </div>
                                
                            <?php } else {
                                    echo "<p>Your cart is empty</p>";
                                }
                            ?>
                        </div>

                        <div class="col-md-5">
                            <h2 class="mb-4 text-center">Billing Details</h2>

                            <form id="billingForm" action="Includes/purchaseItems.php" method="post">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="payment[FirstName]" class="form-label">First Name</label>
                                        <input type="text" oninput="checkLengthFeedback('payment[FirstName]', 'inputFirstNameLength', '32')" class="name small form-control" id="payment[FirstName]" name="payment[FirstName]">
                                        <p><span id="inputFirstNameLength"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                    <label for="payment[LastName]" class="form-label">Last Name</label>
                                        <input type="text" oninput="checkLengthFeedback('payment[LastName]', 'inputLastNameLength', '32')" class="name small form-control" id="payment[LastName]" name="payment[LastName]">
                                        <p><span id="inputLastNameLength"></span></p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="payment[Email]" class="form-label">Email</label>
                                    <input type="email" oninput="checkLengthFeedback('payment[Email]', 'inputEmailLength', '100')" class="email med form-control" id="payment[Email]" name="payment[Email]">
                                    <p><span id="inputEmailLength"></p>
                                </div>

                                <div class="mb-3">
                                    <label for="payment[Address]" class="form-label">Address</label>
                                    <input type="text" oninput="checkLengthFeedback('payment[Address]', 'inputAddressLength', '100')" class="med form-control" id="payment[Address]" name="payment[Address]">
                                    <p><span id="inputAddressLength"></p>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="payment[City]" class="form-label">City</label>
                                        <input type="text" oninput="checkLengthFeedback('payment[City]', 'inputCityLength', '32')" class="small form-control" id="payment[City]" name="payment[City]">
                                        <p><span id="inputCityLength"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="payment[Country]" class="form-label">Country</label>
                                        <select id="payment[Country]" name="payment[Country]" class="form-select">
                                            <option value="">Choose...</option>
                                            <option value="England">England</option>
                                            <option value="Scotland">Scotland</option>
                                            <option value="Northern Ireland">Northern Ireland</option>
                                            <option value="Wales">Wales</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="payment{Postcode]" class="form-label">Postcode</label>
                                    <input type="text" class="form-control" id="payment[Postcode]" name="payment[Postcode]">
                                </div>

                                <hr class="hr-splitter">

                                <h2 class="mb-4 text-center">Payment Details</h2>

                                <div class="mb-3">
                                    <label for="payment[CardNumber]" class="form-label">Card Number</label>
                                    <input type="text" class="cardNumber form-control" id="payment[CardNumber]" name="payment[CardNumber]">
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="payment[CardExpiration]" class="form-label">Expiration</label>
                                        <input type="text" class="expiry form-control" id="payment[CardExpiration]" name="payment[CardExpiration]" placeholder="MM/YY">
                                    </div>
                                    <div class="col-md-6">
                                    <label for="payment[CVV]" class="form-label">CVV</label>
                                        <input type="text" class="secCode form-control" id="payment[CVV]" name="payment[CVV]" placeholder="123">
                                    </div>
                                </div>
                                
                                <div class="row mb-3 jusitfy-content-center">
                                <?php 
                                    if (isset($overOrder)) {
                                ?>
                                        <p class="text-danger text-center">Sorry, we may not have enough stock to cover your order of: </p>
                                        <p class="text-danger text-center"><b><?php echo $overOrderedItem."  x  ". $overOrderedQuantity; ?></b></p>
                            <?php   } else if (!isset($_SESSION["account"])) { ?>
                                        <p class="text-danger text-center">Sorry, you must be logged in to make a purchase. No account? <a href="registerPage.php">Register here</a></p>
                            <?php   } else if (isset($_GET["purchase"]) && $_GET["purchase"] == "unsuccessful") { ?>
                                        <p class="text-danger text-center">Sorry, your purchase was unsuccessful</p>
                            <?php   } else if (isset($_GET["purchase"]) && $_GET["purchase"] == "successful") { ?>
                                        <p class="text-success text-center">Your purchase was successful! You can review your items in your <a href="purchaseHistory.php">Purchase History</a></p>
                            <?php   } else { ?>
                                        <input type="hidden" name="payment[Total]" value="<?php echo $total; ?>">
                                        <div class="modal-footer d-flex justify-content-center row-mb-3">
                                            <p class="text-center mb-3"><span id="billingErrorMessage"></span></p>
                                            <button type="submit" onclick="checkForm('#billingForm', 'billingErrorMessage')" name="payment[submit]" class="btn btn-secondary text-light">Place Order</button>
                                        </div>
                            <?php   } ?>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main> 
    <!-- End Main Section-->

    <!-- ======= Footer ======= -->
    <?php
        include("Includes/footer.php");
    ?>
    <!-- End Footer -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/formValidation.js"></script>

</body>

</html>