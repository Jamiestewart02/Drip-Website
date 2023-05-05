<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Drip Clothing - Purchase History</title>
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
            <h2>Purchase History</h2>
        </div>

    </section>
    <!-- End Hero Section -->

    <main id="main">

        <!-- Checkout Section ======= -->
        <section id="purchaseHistory" class="main">

            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <h2 class="mb-4">Your Purchased Items</h2>

                    <?php

                        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

                        if (mysqli_connect_errno()) {
                            printf("Could not connect to DB: %s", mysqli_connect_error());
                        } else {

                            $query = "SELECT product.ImagePath, product.Name, purchaseHistory.Size, purchaseHistory.Quantity, purchaseHistory.ProductID, purchaseHistory.PurchaseDate FROM purchaseHistory JOIN product ON purchaseHistory.ProductID = product.ProductID WHERE AccountID = '".$_SESSION["account"]["AccountID"]."' ORDER BY purchaseDate DESC";

                            $res = mysqli_query($sqlConnection, $query);
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($array = mysqli_fetch_array($res, MYSQLI_ASSOC)) { ?>

                                <!--------- Item Pill ------->

                                    <div class="row mb-4 border border-4 rounded-pill">
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-3">
                                            <img src="<?php echo $array["ImagePath"]; ?>" class="img-thumbnail" style="border: none;">
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="mt-3 mb-3"><?php echo $array["Name"]; ?></h4>
                                            <p><?php echo (isset($array["Size"])) ? "Size: <b>".$array["Size"]. "</b>" : "Size: <b>-</b>"; ?></p>
                                            <p><?php echo "Quantity: <b>".$array["Quantity"]."</b>"; ?></p>
                                            <p><?php echo "Purchased on: <b>".$array["PurchaseDate"]. "</b>" ?></p>
                                        </div>
                                        <?php
                                            $fetchReviewQuery = "SELECT * FROM reviews WHERE AccountID = '". $_SESSION["account"]["AccountID"]. "' AND ProductID = '". $array["ProductID"]. "'";
                                            $fetchReview = mysqli_query($sqlConnection, $fetchReviewQuery);
                                            $reviewCount = mysqli_num_rows($fetchReview);

                                            if ($reviewCount == 0) {
                                        ?>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="<?php echo '#'. $array["ProductID"].'reviewModal'; ?>"><b style="color: #006460;">Leave A Review</b></a>
                                    <?php   } ?> 
                                    </div>

                                    <!--------- Item Review Modal Box ------->

                                    <div class="modal fade" id="<?php echo $array["ProductID"]."reviewModal"; ?>" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reviewModalLabel"><?php echo $array["Name"]; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="<?php echo "reviewForm".$array["ProductID"]; ?>" action="Includes/submitReview.php" method="post">

                                                        <div class="row mb-3">
                                                            <label for="<?php echo "reviewScore".$array["ProductID"]; ?>" class="form-label">Score</label>
                                                            <select id="<?php echo "reviewScore".$array["ProductID"]; ?>" name="review[score]" class="form-select">
                                                                <option value="">Choose...</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="row mb-3">
                                                            <label for="<?php echo "reviewTitle".$array["ProductID"]; ?>" class="form-label">Title</label>
                                                            <input type="text" oninput='checkLengthFeedback("<?php echo "reviewTitle".$array["ProductID"]; ?>", "<?php echo "reviewTitle".$array["ProductID"]."Length"; ?>", "100")' name="review[title]" class="med form-control" id="<?php echo "reviewTitle".$array["ProductID"]; ?>">
                                                            <p><span id="<?php echo "reviewTitle".$array["ProductID"]."Length"; ?>"></span></p>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="<?php echo "reviewBody".$array["ProductID"]; ?>" class="form-label">Leave your thoughts and opinions (no more than 500 characters)</label>
                                                            <textarea type="text" oninput='checkLengthFeedback("<?php echo "reviewBody".$array["ProductID"]; ?>", "<?php echo "reviewBody".$array["ProductID"]."Length"; ?>", "500")' name="review[body]" class="long form-control" rows="3" id="<?php echo "reviewBody".$array["ProductID"]; ?>"></textarea>
                                                            <p><span id="<?php echo "reviewBody".$array["ProductID"]."Length"; ?>"></span></p>
                                                        </div>

                                                        <div class="d-grid">
                                                            <input type="hidden" name="review[product]" value="<?php echo $array["ProductID"]; ?>">
                                                            <button type="submit" onclick='checkForm("<?php echo "#reviewForm".$array["ProductID"]; ?>", "<?php echo "reviewForm".$array["ProductID"]."Error"; ?>")' name="review[submit]" class="btn btn-primary">Leave Review</button>
                                                            <p class="text-center"><span id="<?php echo "reviewForm".$array["ProductID"]."Error"; ?>"></span></p>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            <?php
                                }
                            } else {
                                echo "<h3>You have not purchased any items yet.</h3>";
                            } 
                        } 
                    ?>
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