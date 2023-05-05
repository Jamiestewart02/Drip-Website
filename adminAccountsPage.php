<!DOCTYPE html>
<html lang="en">

<?php 

    function displayUsers($filter) {

        $sqlConnection = mysqli_connect("awseb-e-tepaspbsa2-stack-awsebrdsdatabase-wlxtc8wwfpvo.c8cmslagywrv.us-east-1.rds.amazonaws.com", "DrippyAdmin", "ThePasswordIsForDrippy", "dummyform");

        if (mysqli_connect_errno()) {
            printf("Could not connect to DB: %S", mysqli_connect_error());
        } else {
            $query = "SELECT AccountID, FirstName, LastName, Street, City, Country, Postcode, Email FROM account ".$filter;

            if (isset($_GET["userSearchSubmit"])) {
                $_GET["userSearch"] = mysqli_real_escape_string($sqlConnection, $_GET["userSearch"]);
                $query = "SELECT AccountID, FirstName, LastName, Street, City, Country, Postcode, Email FROM account WHERE AccountID = '".$_GET["userSearch"].
                "' OR FirstName = '".$_GET["userSearch"].
                "' OR LastName = '".$_GET["userSearch"].
                "' OR CONCAT(FirstName, ' ', LastName) = '".$_GET["userSearch"].
                "' OR Email = '".$_GET["userSearch"]."'";
            }

            $res = mysqli_query($sqlConnection, $query);

            if($res) {
                while ($array = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                    static $count;
                    $count++;

                    $accountID = $array["AccountID"];
                    $firstName = $array["FirstName"];
                    $lastName = $array["LastName"];
                    $street = $array["Street"];
                    $city = $array["City"];
                    $postcode = $array["Postcode"];
                    $country = $array["Country"];
                    $email = $array["Email"];
                    
                    echo "<tr class='table-active'>";
                    echo "<td>".$count."</td>";
                    echo "<td>".$accountID."</td>";
                    echo "<td>".$firstName."</td>";
                    echo "<td>".$lastName."</td>";
                    echo "<td>".$street."</td>";
                    echo "<td>".$city."</td>";
                    echo "<td>".$country."</td>";
                    echo "<td>".$postcode."</td>";
                    echo "<td>".$email."</td>";
                    echo "<td><a href='#' data-bs-toggle='modal' class='text-success' data-bs-target='#".$accountID."Modal'>Edit</a>";
    
                    ?>
                    <form class="form" id="<?php echo 'adminEdit'.$count; ?>" action="Includes/adminEditUsers.php" method="post">

                    <div class="modal fade" id="<?php echo $accountID."Modal"; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-light" id="signOutModalLabel"><?php echo $accountID ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="<?php echo "adminEditFirstName".$accountID; ?>" class="form-label">First Name</label>
                                                <input type="text" oninput='checkLengthFeedback("<?php echo "adminEditFirstName".$accountID; ?>", "<?php echo "adminEditFirstName".$accountID."Length"; ?>", "32")' name="adminEdit[firstName]" class="name small form-control" id="<?php echo "adminEditFirstName".$accountID; ?>" value="<?php echo $firstName ?>">
                                                <span id="<?php echo "adminEditFirstName".$accountID."Length"; ?>"></span>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="<?php echo "adminEditLastName".$accountID; ?>" class="form-label">Last Name</label>
                                                <input type="text" oninput='checkLengthFeedback("<?php echo "adminEditLastName".$accountID; ?>", "<?php echo "adminEditLastName".$accountID."Length"; ?>", "32")' name="adminEdit[lastName]" class="name small form-control" id="<?php echo "adminEditLastName".$accountID; ?>" value="<?php echo $lastName ?>">
                                                <span id="<?php echo "adminEditLastName".$accountID."Length"; ?>"></span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="<?php echo "adminEditAddress".$accountID; ?>" class="form-label">Address</label>
                                            <input type="text" oninput='checkLengthFeedback("<?php echo "adminEditAddress".$accountID; ?>", "<?php echo "adminEditAddress".$accountID."Length"; ?>", "100")' name="adminEdit[street]" class="med form-control" id="<?php echo "adminEditAddress".$accountID; ?>" value="<?php echo $street ?>">
                                            <span id="<?php echo "adminEditAddress".$accountID."Length"; ?>"></span>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="<?php echo "adminEditCity".$accountID; ?>" class="form-label">City</label>
                                                <input type="text" oninput='checkLengthFeedback("<?php echo "adminEditCity".$accountID; ?>", "<?php echo "adminEditCity".$accountID."Length"; ?>", "32")' name="adminEdit[city]" class="small form-control" id="<?php echo "adminEditCity".$accountID; ?>" value="<?php echo $city ?>">
                                                <span id="<?php echo "adminEditCity".$accountID."Length"; ?>"></span>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="<?php echo "adminEditCountry".$accountID; ?>" class="form-label">Country</label>
                                                <select id="<?php echo "adminEditCountry".$accountID; ?>" name="adminEdit[country]" class="form-select">
                                                    <option value="England" <?php echo ($country == "England") ? "selected" : ""; ?>>England</option>
                                                    <option value="Scotland" <?php echo ($country == "Scotland") ? "selected" : ""; ?>>Scotland</option>
                                                    <option value="Northern Ireland" <?php echo ($country == "Northern Ireland") ? "selected" : ""; ?>>Northern Ireland</option>
                                                    <option value="Wales" <?php echo ($country == "Wales") ? "selected" : ""; ?>>Wales</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">

                                            <div class="col-md-6">
                                                <label for="<?php echo "adminEditPostcode".$accountID; ?>" class="form-label">Zip</label>
                                                <input type="text" oninput='checkLengthFeedback("<?php echo "adminEditPostcode".$accountID; ?>", "<?php echo "adminEditPostcode".$accountID."Length"; ?>", "8")' name="adminEdit[postcode]" class="tiny form-control" id="<?php echo "adminEditPostcode".$accountID; ?>" value="<?php echo $postcode ?>">
                                                <span id="<?php echo "adminEditPostcode".$accountID."Length"; ?>"></span>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="<?php echo "adminEditEmail".$accountID; ?>" class="email med form-label">Email</label>
                                                <input type="text" oninput='checkLengthFeedback("<?php echo "adminEditEmail".$accountID; ?>", "<?php echo "adminEditEmail".$accountID."Length"; ?>", "100")' name="adminEdit[email]" class="email med form-control" id="<?php echo "adminEditEmail".$accountID; ?>" value="<?php echo $email ?>">
                                                <span id="<?php echo "adminEditEmail".$accountID."Length"; ?>"></span>
                                            </div>

                                        </div>

                                        <div class="row mb-3 justify-content-center">
                                                <label for="<?php echo "adminEditAdminID".$accountID; ?>" class="form-label text-center"><b>To delete this account, please enter your administrator's ID</b></label>
                                                <input type="text" name="adminEdit[adminID]" class="optional form-control" id="<?php echo "adminEditAdminID".$accountID; ?>">
                                                <?php echo (isset($_GET["invalidID"])) ? "<span class='text-danger text-center'>Invalid administrator ID</span>" : ""; ?>
                                        </div>

                                        <div class="row-mb-3 text-center">
                                            <input type="hidden" name="adminEdit[id]" value="<?php echo $accountID; ?>">
                                            <p><span id="<?php echo 'adminEditError'.$count; ?>"></span></p>
                                            <button type="submit" onclick="checkForm('<?php echo '#adminEdit'.$count; ?>', '<?php echo 'adminEditError'.$count; ?>')" style="background-color: #008d7d;" name="<?php echo "adminEdit[".$accountID."submit]"; ?>" class="btn text-light">Save Changes</button>
                                            <button type="submit" onclick="checkAdminID('<?php echo '#adminEdit'.$count; ?>', '<?php echo $_SESSION['account']['AdminID']; ?>', '<?php echo 'adminEditError'.$count; ?>')" style="background-color: rgba(248, 90, 64, 0.8); font-weight: 600" name="<?php echo "adminEdit[".$accountID."delete]"; ?>" id="adminEditDelete" class="btn text-dark">Delete Account</button>
                                        </div>

                                        <hr class="hr-splitter">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                echo "</td></tr>";
                    
                }
            }
        }

        mysqli_close($sqlConnection);
    }

?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Drip Clothing - Account Management</title>
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

    <!-- Modals -->
    <?php
        include("Includes/modals.php");
    ?>

    <!-- ======= Hero Section ======= -->
    <section id="checkout-hero" class="hero-alt">
        <div class="container text-center" data-aos="fade-down">
            <h2>User Management</h2>
        </div>

    </section>
    <!-- End Hero Section -->

    <main id="main">

        <!-- Account Table Section -->

        <div class="mt-4 container">

            <div class="row justify-content-center">
                <div class="col-md-10">

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                        <div class="row g-3 justify-content-center mb-4">
                            <div class="col-auto">
                                <label for="userSearch" class="col-form-label">For a specific account, please enter the full name, email, or account ID: </label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="userSearch" name="userSearch" class="form-control">
                            </div>
                            <div class="col-auto">
                                <input type="submit" class="btn btn-success" name="userSearchSubmit" value="Search">
                            </div>
                        </div>
                    </form>

                    <div class="row g-3 justify-content-center mb-4">
                    <div class="modal-footer d-flex justify-content-center row-mb-3">
                        <button class="btn btn-secondary text-light" href='#' data-bs-toggle='modal' data-bs-target='#newUserModal'>Add New User</button>
                    </div>
                    <div class="row-mb-3">
                    <?php if (isset($_GET["AccountCreated"])) {
                                echo "<p class='text-success text-center'>Account successfully created</p>";
                            } else if (isset($_GET["EmailAlreadyExists"])) {
                                echo "<p class='text-danger text-center'>This email already exists</p>";
                            } ?>
                    </div>
                    </div>

                    <h2 class="mb-4 text-center">Account List</h2>

                    <table class="table table-dark table-striped">

                        <thead>
                            <tr>
                                    <th scope="col"><a style="background: none; border: none; font-weight: 800;" class="text-light" type="submit" name="filter" value="default">#</a></th>
                                    <th scope="col"><a href="adminAccountsPage.php?filter=account" class="text-light">Account ID</a></th>
                                    <th scope="col"><a href="adminAccountsPage.php?filter=firstName" class="text-light">First Name</a></th>
                                    <th scope="col"><a href="adminAccountsPage.php?filter=lastName" class="text-light">Last Name</a></th>
                                    <th scope="col"><a href="adminAccountsPage.php?filter=street" class="text-light">Street</a></th>
                                    <th scope="col"><a href="adminAccountsPage.php?filter=city" class="text-light">Town/City</a></th>
                                    <th scope="col"><a href="adminAccountsPage.php?filter=country" class="text-light">Country</a></th>
                                    <th scope="col"><a href="adminAccountsPage.php?filter=postcode" class="text-light">Postcode</a></th>
                                    <th scope="col"><a href="adminAccountsPage.php?filter=email" class="text-light">Email</a></th>
                                    <th scope="col"></th>
                            </tr>
                        </thead>

                        <?php
                            if (isset($_GET["filter"])) {

                                switch ($_GET["filter"]) {
                                    case "account":
                                        displayUsers("ORDER BY AccountID");
                                        break;
                                    case "firstName":
                                        displayUsers("ORDER BY FirstName");
                                        break;
                                    case "lastName":
                                        displayUsers("ORDER BY LastName");
                                        break;
                                    case "street":
                                        displayUsers("ORDER BY Street");
                                        break;
                                    case "city":
                                        displayUsers("ORDER BY City");
                                        break;
                                    case "country":
                                        displayUsers("ORDER BY Country");
                                        break;
                                    case "postcode":
                                        displayUsers("ORDER BY Postcode");
                                        break;
                                    case "email":
                                        displayUsers("ORDER BY Email");
                                        break;
                                    case "default":
                                        displayUsers("");
                                        break;
                                }
                            } else {
                                displayUsers("");
                            }
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
    <script src="assets/js/formValidation.js"></script>

</body>

</html>