<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Drip Clothing - Customer Reviews</title>
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

    <!-- Modals -->
    <?php
        include("Includes/modals.php");
    ?>

    <!-- ======= Hero Section ======= -->
    <section id="checkout-hero" class="hero-alt">
        <div class="container text-center" data-aos="fade-down">
            <h2>Customer Reviews</h2>
        </div>

    </section>
    <!-- End Hero Section -->

    <main id="main">

        <!-- Ticket Table Section ======= -->

        <div class="mt-4 container">

            <div class="row justify-content-center">

                <div class="col-md-10 text-center mb-5">
                    <h1><?php echo $_GET["reviewName"]; ?></h1>
                

                <?php
                    $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

                    if (mysqli_connect_errno()) {
                        printf ("Could not connect to DB: %s", mysqli_connect_error());
                    } else {

                        $avgQuery = "SELECT AVG(ReviewScore) AS Average FROM reviews WHERE ProductID = '".$_GET["reviewItem"]."'";
                        $query = "SELECT reviews.Review, reviews.ReviewTitle, reviews.ReviewScore, account.FirstName, account.City, product.Name FROM reviews
                                  JOIN product ON product.ProductID = reviews.ProductID
                                  JOIN account ON account.AccountID = reviews.AccountID
                                  WHERE reviews.ProductID = '".$_GET["reviewItem"]."'";

                        $avgRes = mysqli_query($sqlConnection, $avgQuery);

                            if($avgRes) {
                                $array = mysqli_fetch_array($avgRes, MYSQLI_ASSOC);

                                if (isset($array["Average"])) {

                                    $res = mysqli_query($sqlConnection, $query);

                                    if ($res) {
                                        
                                        
                                        if($array["Average"] <= 2) {
                                            printf ("<h4><b>Average score: <span class='text-danger'>%0.1f</span>/5</b></h4>", $array["Average"]);
                                        } else if($array["Average"] > 2 && $array["Average"] <= 3) {
                                            printf ("<h4><b>Average score: <span style='color: #fd7e14;'>%0.1f</span>/5</b></h4>", $array["Average"]);
                                        } else if($array["Average"] > 3 && $array["Average"] <= 4) {
                                            printf ("<h4><b>Average score: <span class='text-warning'>%0.1f</span>/5</b></h4>", $array["Average"]);
                                        } else {
                                            printf ("<h4><b>Average score: <span class='text-success'>%0.1f</span>/5</b></h4>", $array["Average"]);
                                        }
                                        echo "</div></div>";

                                        $count = 0;

                                        while ($reviewArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {

                                            

                                            if ($count % 3 == 0) {
                                                echo "<div class='row justify-content-center testimonials'>";
                                            }

                                            echo "<div class='col-md-3 mb-4 testimonial-item review text-center text-light'>";
                                            echo "<h3>".$reviewArray["ReviewTitle"]."</h3>";
                                            echo "<p class='text-center'>";

                                            $starCount = 0;
                                            while ($starCount++ < $reviewArray["ReviewScore"]) {
                                                echo "<i class='bi bi-star-fill' style='color: orange'></i>";
                                            }

                                            echo "</p>";
                                            echo "<p class='text-dark'>";
                                            echo "<em>".$reviewArray["Review"]."</em>";
                                            echo "</p>";
                                            echo "<p class='mt-3 text-dark'><b>".$reviewArray["FirstName"]." from ".$reviewArray["City"]."</b></p>";
                                            echo "</div>";

                                            if ($count % 3 == 2) {
                                                echo "</div>";
                                            }
                                            $count++;
                                        }
                                    }
                                } else {
                                    echo "<h1>There are no reviews to display</h1>";
                                }
                            }
                    }

                ?>
        </div>

    </main> <!-- End Main Section-->
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

</body>

</html>