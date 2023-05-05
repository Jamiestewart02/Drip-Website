<!DOCTYPE html>
<html lang="en">

<?php

    function deleteTicket($email, $date, $time) {

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");
        $query = "DELETE FROM userQueries WHERE Email = '$email' AND queryDate= '$date' AND time='$time'";

        $res = mysqli_query($sqlConnection, $query);

        if ($res == 1) {
            header("location: ticketPage.php");
        } else {
            echo "ERROR";
        }

        mysqli_close($sqlConnection);
    }

    function displayTickets() {
        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");
        $query = "SELECT * from userQueries ORDER BY queryDate";
        $res = mysqli_query($sqlConnection, $query);

        if ($res) {
            while($array = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                static $count;
                $count++;

                $name = $array["Name"];
                $email = $array["Email"];
                $subject = $array["Subject"];
                $message = $array["Message"];
                $date = $array["queryDate"];
                $time = $array["time"];

                echo "<tr class='table-active'>";
                echo "<td>".$count."</td>";
                echo "<td>".$name."</td>";
                echo "<td>".$email."</td>";
                echo "<td><b><a href='#' data-bs-toggle='modal' class='text-success' data-bs-target='#Modal".$count."'>".$subject."</a></b></td>";
                echo "<td>".$date."</td>";
                echo "<td>".$time."</td>";
                echo "<td><form action='Includes/deleteUserQueryTicket.php' method='post'>";
                echo "<input type='hidden' name='delete[email]' value='".$email."'>";
                echo "<input type='hidden' name='delete[date]' value='".$date."'>";
                echo "<input type='hidden' name='delete[time]' value='".$time."'>";
                echo "<input type='hidden' name='delete[count]' value='".$count."'>";
                echo "<button type='submit' name='delete[".$count."submit]' class='btn btn-danger'>Delete</button>";
                echo "</form></td>";
                echo "</tr>";
?>

                <div class="modal fade" id="<?php echo "Modal".$count; ?>" tabindex="-1" aria-labelledby="signOutModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-light" id="signOutModalLabel"><?php echo $subject ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3 text-center">
                                    <p><?php echo $message; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <?php
            }
        }
        mysqli_close($sqlConnection);
    }
?>

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

    <!-- Modals -->
    <?php
        include("Includes/modals.php");
    ?>

    <!-- ======= Hero Section ======= -->
    <section id="checkout-hero" class="hero-alt">
        <div class="container" data-aos="fade-down">
            <h2>User Tickets</h2>
        </div>

    </section>
    <!-- End Hero Section -->

    <main id="main">

        <!-- Ticket Table Section ======= -->

        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-10">
                    <h2 class="mb-4">Account Creation</h2>

                    <table class="table table-dark table-striped">

                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <?php
                            include("Includes/portfolio.php");
                            displayTickets();
                        ?>
                    </table>
                </div>
            </div>
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